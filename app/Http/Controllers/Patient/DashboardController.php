<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveAppointmentRequest;
use App\Http\Requests\ApproveRescheduleRequest;
use App\Http\Requests\CancelAppointmentRequest;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\RescheduledAppointmentRequest;
use App\Mail\AppointmentEmailNotif;
use App\Mail\DeclineAppointmentEmailNotif;
use App\Mail\EmailUpdateQueue;
use App\Mail\RescheduleAppointmentEmailNotif;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\Notification;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index()
    {
        $appointments  = Appointment::where('user_id', auth()->user()->id)->with('doctor')->paginate(10);
        $appbooked =  Appointment::where('user_id', auth()->user()->id)->count();
        $appcancelled =  Appointment::where('user_id', auth()->user()->id)
        ->where('status', 'cancelled')
        ->count();

        $appdone =  Appointment::where('user_id', auth()->user()->id)
        ->where('status', 'done')
        ->count();

        return view('portals.patients.dashboard', compact('appointments', 'appbooked', 'appcancelled', 'appdone'));
    }

    public function rescheduleAppointment(RescheduledAppointmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedRequest = $request->validated();

            //Get Admin emails
            $adminEmails = User::select('email')->where('user_type', 'admin')->pluck('email');

            //Update the appointment
            $appointment = Appointment::find($validatedRequest['appointment_id']);

            if($appointment) {
                $validatedRequest['status'] = 'rescheduled';
                $validatedRequest['reschedule_status'] = (auth()->user()->user_type == 'admin') ? 'rescheduled_by_admin' : 'rescheduled_by_patient';
                $appointment->fill($validatedRequest);
                $appointment->save();


                Mail::to($adminEmails)->send(new RescheduleAppointmentEmailNotif($appointment));
                $dentistName = $appointment->doctor->full_name;
                $patientName = $appointment->bookedUser->full_name;
                //Create notification
                $notification = new Notification();
                $notification->notify_to = auth()->user()->id;
                $notification->event_type = 'reschedule_appointment';
                $notification->description = "Your appointment with $dentistName has been rescheduled. Please wait for the admin's approval.";
                $notification->save();

                $notification = new Notification();
                $notification->notify_to = auth()->user()->id;
                $notification->event_type = 'admin_reschedule_appointment';
                $notification->description = "Patient $patientName has rescheduled their appointment with Dr. $dentistName. Please review and approve the new schedule.";
                $notification->save();

                DB::commit();
                return response()->json(['status' => true, 'message' => 'Appointment Successfully Rescheduled']);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'The Appointment is not found.',
                ]);
            }


        }  catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }

    }

    private function checkAvailability($data)
    {
        // Retrieve the availability for the specified doctor and date
        $availability = DoctorAvailability::where('doctor_id', $data['doctor_id'])
            ->where('id', $data['availability_id'])
            ->first();

        if (!$availability) {
            return false; // Availability not found
        }

        // Extract the start and end times from the availability
        $startTime = Carbon::parse($availability->start_time);
        $endTime = Carbon::parse($availability->end_time);

        // Extract the selected appointment start and end times
        $appointmentStartTime = Carbon::parse($data['start_time']);
        $appointmentEndTime = Carbon::parse($data['end_time']);

        // Check for overlap with existing appointments
        $existingAppointments = Appointment::where('date_schedule', $data['date_schedule'])
            ->where('availability_id', $data['availability_id'])
            ->where('status', '!=', 'approved')
            ->where('status', '!=', 'done')
            ->get();

        foreach ($existingAppointments as $existingAppointment) {
            $existingStartTime = Carbon::parse($existingAppointment->start_time);
            $existingEndTime = Carbon::parse($existingAppointment->end_time);

            // Check for overlap
            if (
                $appointmentStartTime < $existingEndTime &&
                $appointmentEndTime > $existingStartTime
            ) {
                return false; // Appointment overlaps with an existing one
            }
        }

        // Check if the appointment time is within the availability time
        return $appointmentStartTime >= $startTime && $appointmentEndTime <= $endTime;
    }

    public function cancelAppointment(CancelAppointmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedRequest = $request->validated();

            //Update the appointment
            $appointment = Appointment::find($validatedRequest['appointment_id']);

            if($appointment) {

                $nextAppointments = Appointment::where('doctor_id', $appointment->doctor_id)
                ->where('date_schedule', $appointment->date_schedule)
                ->where('status', '!=', 'cancelled')
                ->where('status', '!=', 'done')
                ->where('slot_no', '>', $appointment->slot_no)
                ->orderBy('slot_no')
                ->get();

                if(count($nextAppointments) > 0) {
                    // Calculate the time difference between slots
                   $timeDifference = 60; // Assuming you have a duration_minutes attribute
                   // Update the slot numbers for the next appointments
                   $newSlotNumber = $appointment->slot_no;
                   $newStartTime = $appointment->start_time;
                   $newEndTime = $appointment->end_time;
                   foreach ($nextAppointments as $nextAppointment) {
                       $nextAppointment->slot_no = $newSlotNumber;
                       $nextAppointment->start_time = $newStartTime;
                       $nextAppointment->end_time = $newEndTime;
                       $nextAppointment->save();

                       $newStartTime = Carbon::parse($newStartTime)->addMinutes($timeDifference)->toTimeString();
                       $newEndTime = Carbon::parse($newEndTime)->addMinutes($timeDifference)->toTimeString();
                       $newSlotNumber++;

                       Mail::to($nextAppointment->bookedUser->email)->send(new EmailUpdateQueue($nextAppointment));
                   }
                //    $affectedUserEmails = $nextAppointments->pluck('bookedUser.email')->toArray();
                //    Mail::to($affectedUserEmails)->send(new EmailUpdateQueue($appointment));
               }

                $validatedRequest['status'] = 'cancelled';
                $appointment->fill($validatedRequest);
                $appointment->save();

                $dentistName = $appointment->doctor->full_name;
                $patientName = $appointment->bookedUser->full_name;

                //Create notification
                $notification = new Notification();
                $notification->notify_to = auth()->user()->id;
                $notification->event_type = 'cancel_appointment';
                $notification->description = "Your appointment with $dentistName has been cancelled.";
                $notification->save();

                $notification = new Notification();
                $notification->notify_to = auth()->user()->id;
                $notification->event_type = 'admin_cancel_appointment';
                $notification->description = "Patient $patientName has cancelled their appointment with Dr. $dentistName.";
                $notification->save();

                DB::commit();
                return response()->json(['status' => true, 'message' => 'Appointment Successfully Cancelled']);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'The Appointment is not found.',
                ]);
            }


        }  catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function approveRescheduleAppointment(ApproveAppointmentRequest $request)
    {

        $validatedRequest = $request->validated();

        $appointment = Appointment::find($validatedRequest['appointment_id']);

        //Get Admin emails
        $adminEmails = User::select('email')->where('user_type', 'admin')->pluck('email');

        if($appointment) {
            $validatedRequest['status'] = 'approved';
            $validatedRequest['reschedule_status'] = null;
            $validatedRequest['reason'] = null;
            $validatedRequest['availability_id'] = $appointment->suggested_availability;
            $validatedRequest['date_schedule'] = $appointment->suggested_date;
            $validatedRequest['suggested_availability'] = null;
            $validatedRequest['suggested_date'] = null;
            $appointment->fill($validatedRequest);
            $appointment->save();

            $countApprovedAppointments = Appointment::where('availability_id', $appointment->availability_id)
            ->where('status', 'approved')
            ->count();

            $appointment->slot = $countApprovedAppointments;

            Mail::to($adminEmails)->send(new AppointmentEmailNotif($appointment));

            return response()->json(['status' => true, 'message' => 'Appointment Succesfully Approved']);
        }
        return response()->json(['status' => false, 'message' => 'The Appointment not found']);
    }

    public function declineRescheduleAppointment(ApproveAppointmentRequest $request)
    {

        $validatedRequest = $request->validated();

        $appointment = Appointment::find($validatedRequest['appointment_id']);

        if($appointment) {
            $validatedRequest['status'] = 'declined';
            $appointment->fill($validatedRequest);
            $appointment->save();

            $countApprovedAppointments = Appointment::where('availability_id', $appointment->availability_id)
            ->where('status', 'approved')
            ->count();

            $appointment->slot = $countApprovedAppointments;

            Mail::to([$appointment->bookedUser->email, $appointment->doctor->email])->send(new DeclineAppointmentEmailNotif($appointment));

            return response()->json(['status' => true, 'message' => 'Appointment Succesfully Approved']);
        }
        return response()->json(['status' => false, 'message' => 'The Appointment not found']);
    }

    public function updateNotifications() {
        // Get the authenticated user's ID
        $userId = auth()->user()->id;

        // Update all notifications for the user to 'is_read' = true
        Notification::where('notify_to', $userId)->update(['is_read' => true]);

        return response()->json([ 'status' => true , 'message' => 'All notifications updated successfully.']);
    }

    public function sendFeedback(FeedbackRequest $request)
    {
        try {
            DB::beginTransaction();

            $validatedRequest = $request->validated();

            $appointment = Appointment::findOrFail($validatedRequest['appointment_id']);
            $validatedRequest['doctor_id'] = $appointment->doctor_id;
            $validatedRequest['user_id'] = auth()->user()->id;
            // Create the user
            Rating::create($validatedRequest);

            //update the is_rated to true;
            $appointment->is_rated = true;
            $appointment->save();

            DB::commit();
            return response()->json([ 'status' => true , 'message' => 'Feedback successfully sent']);
        }  catch (\Throwable $th) {
            DB::rollBack();

            return $th;
        }
    }
}
