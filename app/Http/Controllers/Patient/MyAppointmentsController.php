<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookAppointmentRequest;
use App\Mail\BookAppointmentEmailNotif;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\Notification;
use App\Models\ServicesSetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use stdClass;

class MyAppointmentsController extends Controller
{
    public function index()
    {
        $services  = ServicesSetting::get();

        $doctors = User::where('user_type', 'doctor')
        ->whereHas('doctorAvailabilities')
        ->get();

        $notifications = Notification::where('notify_to', auth()->user()->id)->get();

        $countapp = Appointment::where('user_id', auth()->user()->id)
        ->count();

        // Check if the user has a previous appointment for "check up services" that is not done
        $hasUncompletedCheckup = Appointment::where('user_id', auth()->user()->id)
        ->where('service', 'Check-up')
        ->where('status', '!=', 'done')
        ->exists();


        return view('portals.patients.my-appointments', compact('services', 'doctors', 'countapp', 'hasUncompletedCheckup', 'notifications'));
    }

    public function bookAppointmentFormIndex(Request $request)
    {

        $service = ServicesSetting::findOrFail($request->input('service'));
        $doctor = User::findOrFail($request->input('doctor_id'));

        $data = [
            'service' => $service,
            'doctor' => $doctor,
            'startTime' => $request->input('startTime'),
            'endTime' => $request->input('endTime'),
            'date' => $request->input('date'),
            'availability_id' => $request->input('availabilityId')
        ];

        return view('portals.patients.appointments', compact('data'));
    }

    public function bookAppointment(BookAppointmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedRequest = $request->validated();
            $duration = 60;
            //Step 1 - get the dentist's availability
            $existingAvailabilities = DoctorAvailability::findOrFail($validatedRequest['availability_id']);

            //Step 2 - Check if already booked on same date schedule
            $appointment = Appointment::where('user_id', auth()->user()->id)
            ->where('date_schedule', $validatedRequest['date_schedule'])
            ->first();

            if($appointment) {
                return response()->json([
                    'status' => false,
                    'message' =>  'You already have an appointment booked for the selected date.',
                ]);
            }

            //Step 3 - get the appointment slot
            $intervals = CarbonPeriod::since($existingAvailabilities->start_time)->minutes($duration)->until($existingAvailabilities->end_time)->toArray();
            $scheduleArr = array();

            $countApprovedAppointments = Appointment::where('availability_id', $existingAvailabilities->id)
            ->where('date_schedule', $validatedRequest['date_schedule'])
            ->where('doctor_id', $existingAvailabilities->doctor_id)
            ->where('status', 'approved')
            ->count();

            //iterate and push to array
            foreach ($intervals as $key => $interval) {

                $key += 1;
                $to = next($intervals);
                if ($to !== false) {
                    $obj = new stdClass();
                    $obj->from = Carbon::parse($interval->toTimeString())->format('H:i:s');
                    $obj->to   = Carbon::parse($to->toTimeString())->format('H:i:s');
                    $obj->is_available = ($key <= $countApprovedAppointments) ? false : true;
                    $scheduleArr[] = $obj;
                }
            }

            $nextAvailableTime = null;

            foreach ($scheduleArr as $timeSlot) {
                if ($timeSlot->is_available) {
                    $nextAvailableTime = $timeSlot;
                    break; // Stop iterating once we find the first available time
                }
            }

            if ($nextAvailableTime == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'All time slots are fully booked.',
                ]);
            }

            //Step 4 - Store to the Appointments table
            // dd($nextAvailableTime);

            //Get the auth user id
            $validatedRequest['user_id'] = auth()->user()->id;
            //PARSE THE START AND END TIME USING CARBON
            $validatedRequest['start_time'] = Carbon::parse($nextAvailableTime->from)->format('H:i:s');
            $validatedRequest['end_time'] = Carbon::parse($nextAvailableTime->to)->format('H:i:s');
            $validatedRequest['status'] = 'approved';
            $validatedRequest['slot_no'] = $countApprovedAppointments + 1;

            $appointment = new Appointment();
            $appointment->fill($validatedRequest);
            $appointment->save();

            //STEP 5 - Sent email to patient
            Mail::to($appointment->bookedUser->email)->send(new BookAppointmentEmailNotif($appointment));

            //STEP 6 - Create Notification
            $dentistName = $appointment->doctor->full_name;
            $formattedStartTime = Carbon::parse($appointment->start_time)->format('g:i A');
            $formattedEndTime = Carbon::parse($appointment->end_time)->format('g:i A');
            $appointmentSchedule = "$formattedStartTime - $formattedEndTime";

            $notification = new Notification();
            $notification->notify_to = auth()->user()->id;
            $notification->event_type = 'book_appointment';
            $notification->description = "You have successfully booked an appointment with $dentistName. Your schedule is $appointmentSchedule.";
            $notification->save();

            $notification = new Notification();
            $notification->notify_to = 1;
            $notification->event_type = 'admin_new_appointment';
            $notification->description = 'A new appointment has been booked with Dr. ' . $appointment->doctor->full_name . '.';
            $notification->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Appointment successfully booked.',
            ]);
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

    public function getPatientAppointments()
    {
        $appointments = Appointment::where('user_id', auth()->user()->id)->get();

        return response()->json([
            'status' => true,
            'appointments' => $appointments,
        ]);
    }

    public function isPreviousAppointmentDone(Request $request)
    {

        $userHasUncompletedAppointments = Appointment::where('user_id', auth()->user()->id)
        ->where('status', '!=', 'done')
        ->where('status', '!=', 'cancelled')
        ->exists();

        return response()->json([
            'status' => true,
            'uncompleted_app' => ($userHasUncompletedAppointments) ? true : false,
        ]);

    }

}
