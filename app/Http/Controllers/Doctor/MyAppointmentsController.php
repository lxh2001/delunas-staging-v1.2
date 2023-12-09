<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BookAppointmentRequest;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\Notification;
use App\Models\ServicesSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MyAppointmentsController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('doctor_id', auth()->user()->id)->with(['bookedUser','doctor'])->paginate(10);
        $countunread = Notification::where('is_read_by_admin', false)->count();
        $notifications = Notification::adminNotifications()->get();
        return view('portals.doctors.my-appointments', compact('appointments', 'countunread', 'notifications'));
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
            //Get the auth user id
            $validatedRequest['user_id'] = auth()->user()->id;
            //PARSE THE START AND END TIME USING CARBON
            $validatedRequest['start_time'] = Carbon::parse($validatedRequest['start_time'])->format('H:i:s');
            $validatedRequest['end_time'] = Carbon::parse($validatedRequest['end_time'])->format('H:i:s');
            $validatedRequest['covidForm'] = json_encode($validatedRequest['covidForm']);
            $validatedRequest['mqForm'] = json_encode($validatedRequest['mqForm']);
            //Perform the availability check
            $isAvailable = $this->checkAvailability($validatedRequest);

            if (!$isAvailable) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The selected time slot is not available.',
                ]);
            }

            //Insert the appointment
            $appointment = new Appointment();
            $appointment->fill($validatedRequest);
            $appointment->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Appointment created successfully.',
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
}
