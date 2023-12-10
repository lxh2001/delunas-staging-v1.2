<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;

        $appointments =  Appointment::where('doctor_id', auth()->user()->id)
        ->whereHas('bookedUser', function ($query) {
            $query->whereNull('deleted_at');
        })
        ->paginate(10);
        $countunread = Notification::where('is_read_by_admin', false)->count();
        $notifications = Notification::adminNotifications()->get();

        $appmonthly = Appointment::whereMonth('created_at', $currentMonth)
        ->where('doctor_id', auth()->user()->id)
        ->count();

        $appclientcancelled = Appointment::where('doctor_id', auth()->user()->id)
        ->where('status', 'cancelled')
        ->count();

        //total client of the doctor
        $totalClients = Appointment::where('doctor_id', auth()->user()->id)
        ->distinct('user_id')
        ->count('user_id');


        return view('portals.doctors.dashboard', compact('appointments', 'countunread', 'notifications',
        'appmonthly', 'appclientcancelled' ,'totalClients'));
    }

    //calendar
    public function getDoctorAppointments()
    {
        $doctorId = auth()->user()->id;

        $appointments = Appointment::where('doctor_id', $doctorId)->get();
        $availabilities = DoctorAvailability::where('doctor_id', $doctorId)->get();

        return response()->json(['status' => true, 'appointments' => $appointments, 'availabilities' => $availabilities]);
    }
}
