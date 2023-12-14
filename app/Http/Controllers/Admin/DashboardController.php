<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveAppointmentRequest;
use App\Http\Requests\CancelAppointmentRequest;
use App\Http\Requests\RescheduledAppointmentRequest;
use App\Mail\AppointmentEmailNotif;
use App\Mail\CancelAppointmentEmailNotif;
use App\Mail\DeclineAppointmentEmailNotif;
use App\Mail\EmailUpdateQueue;
use App\Mail\RescheduleAppointmentEmailNotif;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;

        $appointments = Appointment::where('date_schedule', '>=', $today)
        ->whereHas('bookedUser', function ($query) {
            $query->whereNull('deleted_at');
        })
        ->orderBy('slot_no', 'asc')
        ->with(['bookedUser','doctor'])->paginate(10);

        $countunread = Notification::where('is_read_by_admin', false)->count();
        $notifications = Notification::adminNotifications()->get();
        $appmonthly = Appointment::whereMonth('created_at', $currentMonth)->count();
        $appcancelled = Appointment::where('status', 'cancelled')->count();
        $totalclient = User::where('user_type', 'user')->count();

        return view('portals.admins.dashboard', compact('appointments',
         'countunread', 'notifications', 'appmonthly', 'totalclient','appcancelled'));
    }

    public function approveAppointment(ApproveAppointmentRequest $request)
    {

        $validatedRequest = $request->validated();

        $appointment = Appointment::find($validatedRequest['appointment_id']);

        if($appointment) {
            $validatedRequest['status'] = 'approved';
            $appointment->fill($validatedRequest);
            $appointment->save();

            $countApprovedAppointments = Appointment::where('availability_id', $appointment->availability_id)
            ->where('status', 'approved')
            ->count();

            $appointment->slot = $countApprovedAppointments;

            //Create notification
            $dentistName = $appointment->doctor->full_name;
            $formattedStartTime = Carbon::parse($appointment->start_time)->format('g:i A');
            $formattedEndTime = Carbon::parse($appointment->end_time)->format('g:i A');
            $appointmentSchedule = "$formattedStartTime - $formattedEndTime";
            $patientName = $appointment->bookedUser->full_name;

            $notification = new Notification();
            $notification->notify_to = $appointment->bookedUser->id;
            $notification->event_type = 'approved_appointment';
            $notification->description = "Your appointment with $dentistName has been approved. The scheduled time is $appointmentSchedule. We look forward to seeing you!";
            $notification->save();

            $notification = new Notification();
            $notification->notify_to = 1;
            $notification->event_type = 'admin_approved_appointment';
            $notification->description = "The appointment with Dr. $dentistName has been approved. The scheduled time is $appointmentSchedule. Patient: $patientName.";
            $notification->save();

            Mail::to($appointment->bookedUser->email)->send(new AppointmentEmailNotif($appointment));

            return response()->json(['status' => true, 'message' => 'Appointment Succesfully Approved']);
        }
        return response()->json(['status' => false, 'message' => 'The Appointment not found']);
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
                    }
                    $affectedUserEmails = $nextAppointments->pluck('bookedUser.email')->toArray();
                    Mail::to($affectedUserEmails)->send(new EmailUpdateQueue($appointment));
                }

                // Update the status of the current appointment to 'cancelled'
                $validatedRequest['status'] = 'cancelled';
                $appointment->fill($validatedRequest);
                $appointment->save();

                //Create notification
                $dentistName = $appointment->doctor->full_name;
                $formattedStartTime = Carbon::parse($appointment->start_time)->format('g:i A');
                $formattedEndTime = Carbon::parse($appointment->end_time)->format('g:i A');
                $appointmentSchedule = "$formattedStartTime - $formattedEndTime";
                $patientName = $appointment->bookedUser->full_name;

                $notification = new Notification();
                $notification->notify_to = $appointment->bookedUser->id;
                $notification->event_type = 'canceled_appointment';
                $notification->description = "Your appointment with $dentistName has been canceled.";
                $notification->save();

                $notification = new Notification();
                $notification->notify_to = 1;
                $notification->event_type = 'admin_canceled_appointment';
                $notification->description = "The appointment with Dr. $dentistName has been canceled. The scheduled time is $appointmentSchedule. Patient: $patientName.";
                $notification->save();

                DB::commit();

                Mail::to([$appointment->bookedUser->email, $appointment->doctor->email])->send(new CancelAppointmentEmailNotif($appointment));

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

    public function rescheduleAppointment(RescheduledAppointmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedRequest = $request->validated();

            //Update the appointment
            $appointment = Appointment::find($validatedRequest['appointment_id']);

            if($appointment) {
                $validatedRequest['status'] = 'rescheduled';
                $validatedRequest['reschedule_status'] = (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'doctor') ? 'rescheduled_by_admin' : 'rescheduled_by_patient';
                $appointment->fill($validatedRequest);
                $appointment->save();


                //Create notification
                $dentistName = $appointment->doctor->full_name;
                $formattedStartTime = Carbon::parse($appointment->start_time)->format('g:i A');
                $formattedEndTime = Carbon::parse($appointment->end_time)->format('g:i A');
                $appointmentSchedule = "$formattedStartTime - $formattedEndTime";
                $patientName = $appointment->bookedUser->full_name;

                $notification = new Notification();
                $notification->notify_to = $appointment->bookedUser->id;
                $notification->event_type = 'rescheduled_appointment';
                $notification->description = "Your appointment with $dentistName has been rescheduled.";
                $notification->save();

                $notification = new Notification();
                $notification->notify_to = 1;
                $notification->event_type = 'admin_rescheduled_appointment';
                $notification->description = "The appointment with Dr. $dentistName has been rescheduled. The scheduled time is $appointmentSchedule. Patient: $patientName.";
                $notification->save();

                DB::commit();

                Mail::to($appointment->bookedUser->email)->send(new RescheduleAppointmentEmailNotif($appointment));

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

    public function approveRescheduleAppointment(ApproveAppointmentRequest $request)
    {

        $validatedRequest = $request->validated();

        $appointment = Appointment::find($validatedRequest['appointment_id']);

        if($appointment) {
            $validatedRequest['status'] = 'approved';
            $validatedRequest['reschedule_status'] = null;
            $validatedRequest['reason'] = null;
            $validatedRequest['availability_id'] = $appointment->suggested_availability;
            $validatedRequest['suggested_availability'] = null;
            $validatedRequest['suggested_date'] = null;
            $appointment->fill($validatedRequest);
            $appointment->save();

            $countApprovedAppointments = Appointment::where('availability_id', $appointment->availability_id)
            ->where('status', 'approved')
            ->count();

            $appointment->slot = $countApprovedAppointments;

            //Create notification
            $dentistName = $appointment->doctor->full_name;
            $formattedStartTime = Carbon::parse($appointment->start_time)->format('g:i A');
            $formattedEndTime = Carbon::parse($appointment->end_time)->format('g:i A');
            $appointmentSchedule = "$formattedStartTime - $formattedEndTime";
            $patientName = $appointment->bookedUser->full_name;

            $notification = new Notification();
            $notification->notify_to = $appointment->bookedUser->id;
            $notification->event_type = 'rescheduled_appointment';
            $notification->description = "Your appointment with $dentistName has been approved.";
            $notification->save();

            $notification = new Notification();
            $notification->notify_to = 1;
            $notification->event_type = 'admin_rescheduled_appointment';
            $notification->description = "The appointment with Dr. $dentistName has been approved. The scheduled time is $appointmentSchedule. Patient: $patientName.";
            $notification->save();

            Mail::to($appointment->bookedUser->email)->send(new AppointmentEmailNotif($appointment));

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

            //Create notification
            $dentistName = $appointment->doctor->full_name;
            $formattedStartTime = Carbon::parse($appointment->start_time)->format('g:i A');
            $formattedEndTime = Carbon::parse($appointment->end_time)->format('g:i A');
            $appointmentSchedule = "$formattedStartTime - $formattedEndTime";
            $patientName = $appointment->bookedUser->full_name;

            $notification = new Notification();
            $notification->notify_to = $appointment->bookedUser->id;
            $notification->event_type = 'declined_appointment';
            $notification->description = "Your appointment with $dentistName has been declined.";
            $notification->save();

            $notification = new Notification();
            $notification->notify_to = 1;
            $notification->event_type = 'admin_declined_appointment';
            $notification->description = "The appointment with Dr. $dentistName has been declined. The scheduled time is $appointmentSchedule. Patient: $patientName.";
            $notification->save();

            Mail::to([$appointment->bookedUser->email, $appointment->doctor->email])->send(new DeclineAppointmentEmailNotif($appointment));

            return response()->json(['status' => true, 'message' => 'Appointment Succesfully Approved']);
        }
        return response()->json(['status' => false, 'message' => 'The Appointment not found']);
    }

    public function updateNotifications() {

        // Update all notifications for the user to 'is_read_by_admin' = true
        Notification::query()->update(['is_read_by_admin' => true]);

        return response()->json([ 'status' => true , 'message' => 'All notifications updated successfully.']);
    }

    public function doneAppointment(ApproveAppointmentRequest $request)
    {
        $validatedRequest = $request->validated();

        $appointment = Appointment::find($validatedRequest['appointment_id']);

        if($appointment) {
            $validatedRequest['status'] = 'done';
            $appointment->fill($validatedRequest);
            $appointment->save();

            //Create notification
            $dentistName = $appointment->doctor->full_name;

            $notification = new Notification();
            $notification->notify_to = 1;
            $notification->event_type = 'admin_done_appointment';
            $notification->description = "The appointment with Dr. $dentistName has been marked as done.";
            $notification->save();

            return response()->json(['status' => true, 'message' => 'Appointment successfully marked as done.']);
        }
        return response()->json(['status' => false, 'message' => 'The Appointment not found']);
    }
}
