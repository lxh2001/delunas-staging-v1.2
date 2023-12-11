<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DoctorAppointmentController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\PatientAppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//INDEX
Route::get('/', [IndexController::class, 'index'])->name('index');

Route::post('/contact-us', [IndexController::class, 'contactUs'])->name('index.contact_us');

//AUTH
Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/create-account',[AuthController::class, 'register'])->name('auth.register');
Route::get('/verify-email/{verification_code}', [AuthController::class,'verifyEmail'])->name('verify_email');
Route::get('/reset-password/{token}/{email}', [AuthController::class,'resetPasswordPage'])->name('reset_password');
Route::post('/reset-password', [AuthController::class,'resetPassword'])->name('submit_reset_password');
Route::post('/forgot-password', [AuthController::class,'forgotPassword'])->name('forgot_password');

Route::middleware(['auth:sanctum', 'userType:admin'])->group(function () {
    //DASHBOARD
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    //DASHBOARD APPOINTMENT
    Route::post('/admin/approve-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'approveAppointment']);
    Route::post('/admin/reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'rescheduleAppointment']);
    Route::post('/admin/cancel-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'cancelAppointment']);
    Route::post('/admin/approve-reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'approveRescheduleAppointment']);
    Route::post('/admin/decline-reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'declineRescheduleAppointment']);
    Route::post('/admin/mark-as-done-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'doneAppointment']);

    //GLOBAL ROUTES FOR PATIENT
    // Route::post('/admin/update-notification', [\App\Http\Controllers\Admin\DashboardController::class, 'updateNotifications']);

    //ACCOUNT
    Route::get('/admin/accounts', [AccountController::class, 'index'])->name('admin.accounts');
    Route::delete('/admin/accounts/{user}', [AccountController::class, 'deleteUser'])->name('admin.delete.user');
    Route::post('/admin/create-doctor', [AccountController::class, 'createUser'])->name('admin.create.user');


    //DOCTOR AVAILABILITIES
    Route::post('/admin/doctor/add-availability', [AccountController::class, 'addDoctorAvailabilities']);
    Route::put('/admin/doctor/edit-availability/{availability}', [AccountController::class, 'editDoctorAvailabilities']);
    Route::get('/admin/doctor/get-availabilities/{doctor_id}/{filter_date}', [AccountController::class, 'getDoctorAppointments']);

    Route::get('/admin/doctor/logs', [DoctorAppointmentController::class, 'index'])->name('admin.doctor.appointment');

    //HOME PAGE SETTINGS
    Route::get('/admin/homepage/settings', [HomepageController::class, 'index'])->name('admin.homepage');
    Route::post('/admin/homepage/settings/home-banner', [HomepageController::class, 'createAndUpdateHomeBanner'])->name('admin.homepage.home.save');

    Route::post('/admin/homepage/settings/services', [HomepageController::class, 'createService']);
    Route::post('/admin/homepage/settings/services/{service}', [HomepageController::class, 'updateService']);

    Route::get('/admin/patient/logs', [PatientAppointmentController::class, 'index'])->name('admin.patient.appointment');

    Route::post('/admin/homepage/settings/upload-mission-vision-image', [HomepageController::class, 'createAndUpdateUploadImageMissionVision'])->name('admin.homepage.mv.upload');
    Route::post('/admin/homepage/settings/mission', [HomepageController::class, 'createAndUpdateMission'])->name('admin.homepage.mission');
    Route::post('/admin/homepage/settings/vision', [HomepageController::class, 'createAndUpdateVision'])->name('admin.homepage.vision');

    Route::post('/admin/homepage/settings/about-us', [HomepageController::class, 'createAndUpdateAboutUs'])->name('admin.homepage.about-us');
});

Route::middleware(['auth:sanctum', 'userType:user'])->group(function () {
     //PATIENT PORTAL
     Route::get('/patient/dashboard', [\App\Http\Controllers\Patient\DashboardController::class, 'index'])->name('patient.dashboard');
     Route::get('/patient/doctor/get-availabilities/{doctor_id}/{filter_date}', [AccountController::class, 'getDoctorAppointments']);
     //DASHBOARD - APPOINTMENTS
     Route::POST('/patient/reschedule-appointment', [\App\Http\Controllers\Patient\DashboardController::class, 'rescheduleAppointment']);
     Route::POST('/patient/cancel-appointment', [\App\Http\Controllers\Patient\DashboardController::class, 'cancelAppointment']);
     Route::post('/patient/approve-reschedule-appointment', [\App\Http\Controllers\Patient\DashboardController::class, 'approveRescheduleAppointment']);
     Route::post('/patient/decline-reschedule-appointment', [\App\Http\Controllers\Patient\DashboardController::class, 'declineRescheduleAppointment']);
     Route::post('/patient/send-feedback', [\App\Http\Controllers\Patient\DashboardController::class, 'sendFeedback']);

     //GLOBAL ROUTES FOR PATIENT
     Route::post('/patient/update-notification', [\App\Http\Controllers\Patient\DashboardController::class, 'updateNotifications']);

     //PATIENT MY APPOINTMENTS
     Route::get('/patient/my-appointments', [\App\Http\Controllers\Patient\MyAppointmentsController::class, 'index'])->name('patient.appointment');
     Route::get('/patient/doctor/get-availabilities/{doctor_id}/{filter_date}', [AccountController::class, 'getDoctorAppointments']);
     Route::get('/calendar/my-appointments',[\App\Http\Controllers\Patient\MyAppointmentsController::class, 'getPatientAppointments']);
     Route::get('/patient/check-uncompleted-appointment', [\App\Http\Controllers\Patient\MyAppointmentsController::class, 'isPreviousAppointmentDone']);


     //PATIENT MY PROFILE
     Route::get('/patient/my-profile', [\App\Http\Controllers\Patient\ProfileController::class, 'index'])->name('patient.my-profile');
     Route::post('/patient/upload-photo', [\App\Http\Controllers\Patient\ProfileController::class, 'uploadPhoto'])->name('patient.upload.photo');
     Route::post('/patient/update-personal-information', [\App\Http\Controllers\Patient\ProfileController::class, 'updatePersonalInfo'])->name('patient.update.info');
     Route::post('/patient/update-account', [\App\Http\Controllers\Patient\ProfileController::class, 'updateAccount'])->name('patient.update.account');

     // patient booking next step
     Route::get('/patient/book-appointment-forms', [\App\Http\Controllers\Patient\MyAppointmentsController::class, 'bookAppointmentFormIndex'])->name('patient.book-appointments');
     Route::post('/patient/book-appointment-forms', [\App\Http\Controllers\Patient\MyAppointmentsController::class, 'bookAppointment']);
});

Route::middleware(['auth:sanctum', 'userType:doctor'])->group(function () {
    //DOCTOR PORTAL

    //DASHBOARD
    Route::get('/doctor/dashboard', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('doctor.dashboard');
    Route::get('/doctor/calendar/my-appointments', [\App\Http\Controllers\Doctor\DashboardController::class, 'getDoctorAppointments']);


    Route::get('/doctor/my-appointments', [\App\Http\Controllers\Doctor\MyAppointmentsController::class, 'index'])->name('doctor.appointment');
    Route::post('/doctor/approve-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'approveAppointment']);
    Route::post('/doctor/reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'rescheduleAppointment']);
    Route::post('/doctor/cancel-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'cancelAppointment']);
    Route::post('/doctor/approve-reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'approveRescheduleAppointment']);
    Route::post('/doctor/decline-reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'declineRescheduleAppointment']);
    Route::post('/doctor/mark-as-done-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'doneAppointment']);

    Route::get('/doctor/get-availabilities/{doctor_id}/{filter_date}', [AccountController::class, 'getDoctorAppointments']);

    Route::get('/doctor/my-profile', (function() {
        return view('portals.doctors.my-profile');
    }))->name('doctor.my-profile');

});

Route::middleware(['auth:sanctum'])->group(function () {
    // //ADMIN PORTAL

    // //DASHBOARD
    // Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // //DASHBOARD APPOINTMENT
    // Route::post('/admin/approve-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'approveAppointment']);
    // Route::post('/admin/reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'rescheduleAppointment']);
    // Route::post('/admin/cancel-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'cancelAppointment']);
    // Route::post('/admin/approve-reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'approveRescheduleAppointment']);
    // Route::post('/admin/decline-reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'declineRescheduleAppointment']);
    // Route::post('/admin/mark-as-done-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'doneAppointment']);

    // //GLOBAL ROUTES FOR PATIENT
    Route::post('/admin/update-notification', [\App\Http\Controllers\Admin\DashboardController::class, 'updateNotifications']);

    // //ACCOUNT
    // Route::get('/admin/accounts', [AccountController::class, 'index'])->name('admin.accounts');
    // Route::delete('/admin/accounts/{user}', [AccountController::class, 'deleteUser'])->name('admin.delete.user');
    // Route::post('/admin/create-doctor', [AccountController::class, 'createUser'])->name('admin.create.user');


    // //DOCTOR AVAILABILITIES
    // Route::post('/admin/doctor/add-availability', [AccountController::class, 'addDoctorAvailabilities']);
    // Route::put('/admin/doctor/edit-availability/{availability}', [AccountController::class, 'editDoctorAvailabilities']);
    // Route::get('/admin/doctor/get-availabilities/{doctor_id}/{filter_date}', [AccountController::class, 'getDoctorAppointments']);

    // Route::get('/admin/doctor/logs', [DoctorAppointmentController::class, 'index'])->name('admin.doctor.appointment');

    // //HOME PAGE SETTINGS
    // Route::get('/admin/homepage/settings', [HomepageController::class, 'index'])->name('admin.homepage');
    // Route::post('/admin/homepage/settings/home-banner', [HomepageController::class, 'createAndUpdateHomeBanner'])->name('admin.homepage.home.save');

    // Route::post('/admin/homepage/settings/services', [HomepageController::class, 'createService']);
    // Route::post('/admin/homepage/settings/services/{service}', [HomepageController::class, 'updateService']);

    // Route::get('/admin/patient/logs', [PatientAppointmentController::class, 'index'])->name('admin.patient.appointment');

    // Route::post('/admin/homepage/settings/upload-mission-vision-image', [HomepageController::class, 'createAndUpdateUploadImageMissionVision'])->name('admin.homepage.mv.upload');
    // Route::post('/admin/homepage/settings/mission', [HomepageController::class, 'createAndUpdateMission'])->name('admin.homepage.mission');
    // Route::post('/admin/homepage/settings/vision', [HomepageController::class, 'createAndUpdateVision'])->name('admin.homepage.vision');

    // Route::post('/admin/homepage/settings/about-us', [HomepageController::class, 'createAndUpdateAboutUs'])->name('admin.homepage.about-us');

    // //PATIENT PORTAL
    // Route::get('/patient/dashboard', [\App\Http\Controllers\Patient\DashboardController::class, 'index'])->name('patient.dashboard');
    // Route::get('/patient/doctor/get-availabilities/{doctor_id}/{filter_date}', [AccountController::class, 'getDoctorAppointments']);
    // //DASHBOARD - APPOINTMENTS
    // Route::POST('/patient/reschedule-appointment', [\App\Http\Controllers\Patient\DashboardController::class, 'rescheduleAppointment']);
    // Route::POST('/patient/cancel-appointment', [\App\Http\Controllers\Patient\DashboardController::class, 'cancelAppointment']);
    // Route::post('/patient/approve-reschedule-appointment', [\App\Http\Controllers\Patient\DashboardController::class, 'approveRescheduleAppointment']);
    // Route::post('/patient/decline-reschedule-appointment', [\App\Http\Controllers\Patient\DashboardController::class, 'declineRescheduleAppointment']);
    // Route::post('/patient/send-feedback', [\App\Http\Controllers\Patient\DashboardController::class, 'sendFeedback']);

    // //GLOBAL ROUTES FOR PATIENT
    Route::post('/patient/update-notification', [\App\Http\Controllers\Patient\DashboardController::class, 'updateNotifications']);

    // //PATIENT MY APPOINTMENTS
    // Route::get('/patient/my-appointments', [\App\Http\Controllers\Patient\MyAppointmentsController::class, 'index'])->name('patient.appointment');
    // Route::get('/patient/doctor/get-availabilities/{doctor_id}/{filter_date}', [AccountController::class, 'getDoctorAppointments']);
    // Route::get('/calendar/my-appointments',[\App\Http\Controllers\Patient\MyAppointmentsController::class, 'getPatientAppointments']);
    // Route::get('/patient/check-uncompleted-appointment', [\App\Http\Controllers\Patient\MyAppointmentsController::class, 'isPreviousAppointmentDone']);


    // //PATIENT MY PROFILE
    // Route::get('/patient/my-profile', [\App\Http\Controllers\Patient\ProfileController::class, 'index'])->name('patient.my-profile');
    // Route::post('/patient/upload-photo', [\App\Http\Controllers\Patient\ProfileController::class, 'uploadPhoto'])->name('patient.upload.photo');
    // Route::post('/patient/update-personal-information', [\App\Http\Controllers\Patient\ProfileController::class, 'updatePersonalInfo'])->name('patient.update.info');
    // Route::post('/patient/update-account', [\App\Http\Controllers\Patient\ProfileController::class, 'updateAccount'])->name('patient.update.account');

    // // patient booking next step
    // Route::get('/patient/book-appointment-forms', [\App\Http\Controllers\Patient\MyAppointmentsController::class, 'bookAppointmentFormIndex'])->name('patient.book-appointments');
    // Route::post('/patient/book-appointment-forms', [\App\Http\Controllers\Patient\MyAppointmentsController::class, 'bookAppointment']);

    // //DOCTOR PORTAL

    // //DASHBOARD
    // Route::get('/doctor/dashboard', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('doctor.dashboard');
    // Route::get('/doctor/calendar/my-appointments', [\App\Http\Controllers\Doctor\DashboardController::class, 'getDoctorAppointments']);


    // Route::get('/doctor/my-appointments', [\App\Http\Controllers\Doctor\MyAppointmentsController::class, 'index'])->name('doctor.appointment');
    // Route::post('/doctor/approve-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'approveAppointment']);
    // Route::post('/doctor/reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'rescheduleAppointment']);
    // Route::post('/doctor/cancel-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'cancelAppointment']);
    // Route::post('/doctor/approve-reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'approveRescheduleAppointment']);
    // Route::post('/doctor/decline-reschedule-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'declineRescheduleAppointment']);
    // Route::post('/doctor/mark-as-done-appointment', [\App\Http\Controllers\Admin\DashboardController::class, 'doneAppointment']);

    // Route::get('/doctor/get-availabilities/{doctor_id}/{filter_date}', [AccountController::class, 'getDoctorAppointments']);

    // Route::get('/doctor/my-profile', (function() {
    //     return view('portals.doctors.my-profile');
    // }))->name('doctor.my-profile');

    //LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


