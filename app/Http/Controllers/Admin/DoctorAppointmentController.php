<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorAppointmentController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $doctors = User::where('user_type', 'doctor')
        ->whereHas('doctorAvailabilities')
        ->get();

        $appointments = Appointment::with('bookedUser')
        ->orderBy('date_schedule', 'asc') // Sort by date_schedule in ascending order
        ->whereHas('bookedUser', function ($query) {
            $query->whereNull('deleted_at');
        })
        ->paginate(10);

        $countunread = Notification::where('is_read_by_admin', false)->count();
        $notifications = Notification::adminNotifications()->get();

        return view('portals.admins.doctor-appointment', compact('doctors', 'appointments', 'countunread', 'notifications'));
    }

}
