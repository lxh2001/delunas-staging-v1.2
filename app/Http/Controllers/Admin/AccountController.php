<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvailabilityRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use stdClass;

class AccountController extends Controller
{
    public function index()
    {
        $doctors = User::where('user_type', 'doctor')->paginate(2);
        $users = User::where('user_type', 'user')->paginate(2);
        $countunread = Notification::where('is_read_by_admin', false)->count();
        $notifications = Notification::adminNotifications()->get();

        return view('portals.admins.accounts', compact('doctors', 'users', 'countunread', 'notifications'));
    }

    public function createUser(CreateUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedRequest = $request->validated();

            $validatedRequest['middlename'] = $request['middlename'];

            //Hash the password
            $validatedRequest['password'] = Hash::make($validatedRequest['password']);

            //Automatically verified the user's email
            $validatedRequest['email_verified_at'] = Carbon::now();

            //Address
            $validatedRequest['address'] = $request['address'];

            //Add user_type as a doctor
            $validatedRequest['user_type'] = 'doctor';

            //Verified OTP
            $validatedRequest['verified_otp'] = true;

            //Check if has image
            if($request->has('image')) {

                // //Create file name
                // $fileName = time() . '.' . $request->image->extension();

                // //Move the image to uploads folder
                // $filePath = $request->image->move('img/uploads/', $fileName);

                // //Add the filePath
                // $validatedRequest['image_url'] = $filePath;

                $imageName = time() . '_' . $request->image->getClientOriginalName();
                $request->image->storeAs('public', $imageName);
                $validatedRequest['image_url'] = $imageName;
            }

            //Create the user
            User::create($validatedRequest);
            DB::commit();
            return redirect()->route('admin.accounts');
        }  catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function addDoctorAvailabilities(AvailabilityRequest $request)
    {
        try {
            DB::beginTransaction();
            // Get the current date (without the time)
            $currentDate = Carbon::today();

            // The request has been validated, and you can access the validated data here
            $validatedData = $request->validated();
            $validatedData['recurring_days'] = json_encode($validatedData['recurring_days']);
            $validatedData['date'] = $currentDate->format('Y-m-d');

            //Conflict Detection
            $existingAvailabilities = DoctorAvailability::where('doctor_id', $validatedData['doctor_id'])->get();
            if($this->isConflict($validatedData, $existingAvailabilities)) {
                return response()->json(['status' => false, 'message' => 'Successfully Created']);
            } else {
                DoctorAvailability::create($validatedData);
                DB::commit();
                return response()->json(['status' => true, 'message' => 'Successfully Created']);
            }

        }  catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function editDoctorAvailabilities(AvailabilityRequest $request, DoctorAvailability $availability)
    {
        try {
            DB::beginTransaction();
            // Get the current date (without the time)
            $currentDate = Carbon::today();

            // The request has been validated, and you can access the validated data here
            $validatedData = $request->validated();
            $validatedData['recurring_days'] = json_encode($validatedData['recurring_days']);
            $validatedData['date'] = $currentDate->format('Y-m-d');

            //Conflict Detection
            // $existingAvailabilities = DoctorAvailability::where('doctor_id', $validatedData['doctor_id'])->get();
            // if($this->isConflict($validatedData, $existingAvailabilities)) {
            //     return response()->json(['status' => false, 'message' => 'Successfully Created']);
            // } else {
                $availability->fill($validatedData);
                $availability->save();
                DB::commit();
                return response()->json(['status' => true, 'message' => 'Successfully Created']);
            // }

        }  catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    protected function isConflict($newAvailability, $existingAvailabilities)
    {
        foreach ($existingAvailabilities as $existingAvailability) {
            $existingStartDate = strtotime($existingAvailability['start_date']);
            $existingEndDate = strtotime($existingAvailability['end_date']);
            $newStartDate = strtotime($newAvailability['start_date']);
            $newEndDate = strtotime($newAvailability['end_date']);

            $existingRecurringDays = array_map('intval', json_decode($existingAvailability['recurring_days'], true));
            $newRecurringDays = array_map('intval', json_decode($newAvailability['recurring_days']));

            // Check for overlap in date ranges and recurring days
            if (
                $newStartDate <= $existingEndDate &&
                $newEndDate >= $existingStartDate &&
                count(array_intersect($newRecurringDays, $existingRecurringDays)) > 0
            ) {
                return true; // Conflict found
            }
        }

        return false; // No conflict
    }

    public function getDoctorAppointments($doctor_id, $filter_date = null)
    {
        // Get the current date (without the time)
        $currentDate = Carbon::today();
        $doctorId = $doctor_id;
        $filterDate = ($filter_date == "null") ? $currentDate->format('Y-m-d') : $filter_date;

        // Retrieve existing availabilities for the doctor for the specific day of the week
        $dayOfWeek = Carbon::parse($filterDate)->dayOfWeek;

        $existingAvailabilities = DoctorAvailability::where('doctor_id', $doctorId)
        ->whereJsonContains('recurring_days', (string) $dayOfWeek)
        ->where('start_date', '<=', $filterDate)
        ->where('end_date', '>=', $filterDate)
        ->get();

        $availableSlots = [];

        foreach ($existingAvailabilities as $availability) {
            // Check if the selected date is within the start and end dates of the availability
            if (Carbon::parse($filterDate)->between(
                $availability->start_date,
                $availability->end_date
            )) {
                // Check if the selected day of the week is in the recurring days
                if (in_array($dayOfWeek, json_decode($availability->recurring_days))) {

                    $countApprovedAppointments = Appointment::where('availability_id', $availability->id)
                    ->whereDate('date_schedule', $filterDate)
                    ->where('status', 'approved')
                    ->where('status', '!=', 'cancelled')
                    ->where('status', '!=', 'done')
                    ->count();

                    // Add the availability details to the available slots array
                    $availableSlots[] = [
                        'id' => $availability->id,
                        'start_date' => $availability->start_date,
                        'end_date' => $availability->end_date,
                        'start_time' => $availability->start_time,
                        'end_time' => $availability->end_time,
                        'recurring_days' => $availability->recurring_days,
                        'patients_queue' => $countApprovedAppointments
                    ];
                }
            }
        }

        return response()->json([ 'status' => true, 'date' => $filterDate ,'available_slots' => $availableSlots]);
    }

    public function deleteUser(User $user)
    {
        if(!$user) return response()->json([ 'status' => false, 'message' => 'User not found!']);

        if(auth()->user()->id === $user->id) return response()->json([ 'status' => true,'message' => 'Forbidden']);

        $user->delete();

        return response()->json([ 'status' => true, 'message' => 'Doctor deleted Successfully']);
    }
}
