<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    public function index()
    {
        $countunread = Notification::where('is_read_by_admin', false)->count();
        $notifications = Notification::adminNotifications()->get();

        return view('portals.admins.patient-appointment', 'countunread', 'notifications');
    }
}
