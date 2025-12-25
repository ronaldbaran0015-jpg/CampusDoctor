<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProblemReportController;
use App\Http\Controllers\ProblemReportReplyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\NavigationSearchController;

//===================================================
//==================PUBLIC Routes====================
//===================================================

Route::get('/', function () {
    if (Auth::guard('patient')->check()) {
        return redirect()->route('myhome');
    }
    if (Auth::guard('staff')->check()) {
        return redirect()->route('staff_home');
    }
    if (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor_home');
    }
    if (Auth::guard('admin')->check()) {
        return redirect()->route('dashboard');
    }
    return view('splash');
});

Route::get('/about-us', function () {
    if (Auth::guard('patient')->check()) {
        return redirect()->route('myhome');
    }
    if (Auth::guard('staff')->check()) {
        return redirect()->route('staff_home');
    }
    if (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor_home');
    }
    if (Auth::guard('admin')->check()) {
        return redirect()->route('dashboard');
    }
    return view('about_us');
});
Route::get('/campusdoctor.com', function () {

    if (Auth::guard('patient')->check()) {
        return redirect()->route('myhome');
    }
    if (Auth::guard('staff')->check()) {
        return redirect()->route('staff_home');
    }
    if (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor_home');
    }
    if (Auth::guard('admin')->check()) {
        return redirect()->route('dashboard');
    }
    return view('index');
});


//Activate Account
Route::get('/activate-account', [AccountController::class, 'showActivateAccountForm'])->name('activate');
Route::post('/activate-account', [AccountController::class, 'activateAccount'])->name('activate-account.post');

//===================================================
//==============Personnel Authentication=============
//===================================================
Route::get('/personnels', function () {
    if (Auth::guard('patient')->check()) {
        return redirect()->route('myhome');
    }
    if (Auth::guard('staff')->check()) {
        return redirect()->route('staff_home');
    }
    if (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor_home');
    }
    if (Auth::guard('admin')->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.authoption');
});



//=====================================================
//=============Patient Authentication==================
//=====================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Socialite Routes
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);



Route::get('/auth/google', [SocialAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [SocialAuthController::class, 'callback']);

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('client.signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

//=====================================================
//================Password Reset ======================
//=====================================================
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('patient.password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('patient.password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('patient.password.update');

//=====================================================
//=================Global Logout=======================
//=====================================================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// For Updating Password
Route::put('/updatePassword', [ChangePasswordController::class, 'updatePassword'])->name('password.updatePassword');
Route::get('/myhome', [ClientController::class, 'myhome'])
    ->middleware('auth:patient')
    ->name('myhome');

//===========Patient Module route=====================
Route::middleware('auth:patient')->group(function () {
    Route::get('/mydoctor', [ClientController::class, 'mydoctor'])->name('mydoctor');
    Route::get('/doctinfo/{docid}', [ClientController::class, 'docinfo'])->name('docinfo');
    Route::get('/search', [ClientController::class, 'searchdoctor'])->name('doctor.searchdoctor');
    Route::get('/search-doctor-ajax', [ClientController::class, 'ajaxSearch'])->name('doctor.ajaxSearch');
    Route::match(['get', 'post'], '/booking/{docid}', [BookingController::class, 'booking'])->name('booking');
    Route::get('/myhistory', [ClientController::class, 'myhistory'])->name('myhistory');
    Route::delete('/delete_appointments/{appoid}', [ClientController::class, 'destroyAppointment'])->name('appointments.destroy');
    Route::get('/myschedule', [ClientController::class, 'myschedule'])->name('myschedule');
    Route::post('/appointment/{id}/cancelled', [ClientController::class, 'cancelledAppointment'])->name('appointment.cancelled');
    Route::get('/myaccount', [ClientController::class, 'myaccount'])->name('myaccount');
    Route::get('/myprofile', [ClientController::class, 'myprofile'])->name('myprofile');
    Route::get('/edit-profile', [ClientController::class, 'editProfile'])->name('edit-profile');
    Route::put('/update-profile', [ClientController::class, 'updateProfile'])->name('update-profile');

    // Route::match(['get', 'post'], '/booking/{docid}', [ClientController::class, 'booking'])->name('booking');

    Route::get('/appointments/{id}', [ClientController::class, 'appointmentdetail'])->name('appointments.detail');
    Route::get('/doctorCategory', [ClientController::class, 'doctorCategory'])->name('doctor.category');
    //Service support page
    Route::get('/help', [SupportController::class, 'showHelpPage'])->name('help');
    //Submiting an issue
    Route::get('/report_issue', [ProblemReportController::class, 'showReportProblemPage'])->name('report_issue');
    Route::post('/report-problem', [ProblemReportController::class, 'reportProblem'])->name('report.problem');
    //Displaying report history
    Route::get('/report-problem-history', [ProblemReportController::class, 'showreportHistory'])->name('report.history');

    Route::get('/policy', [SupportController::class, 'showPolicy'])->name('policy');
    Route::get('/mysetting', [SupportController::class, 'showSetting'])->name('showSetting');
    Route::get('/account_center', [AccountController::class, 'account_center'])->name('account_center');
    Route::get('/personnalDetails', [AccountController::class, 'showPersonalDetailsPage'])->name('showPersonalDetailsPage');
    Route::get('/about', [SupportController::class, 'showabout'])->name('about');
    //Change Password
    Route::get('/changePassword', [ChangePasswordController::class, 'changePassword'])->name('changepassword');
    // Route::put('/update-password', [ChangePasswordController::class, 'updatePassword'])->name('update-password');
    //Account controll for deactivation or deletetion
    Route::get('/accountControl', [AccountController::class, 'showAccControlPage'])->name('showAccControlPage');
    Route::post('/account/update-status', [AccountController::class, 'updateAccountStatus'])->name('account.update-status');
    // Update Contact and Email
    Route::get('/editContactInfo', [AccountController::class, 'editContactInfo'])->name('editContactInfo');
    Route::patch('/updateContactInfo', [AccountController::class, 'updateContactInfo'])->name('updateContactInfo');
    //Update Name & Birthday
    Route::get('/editDob', [AccountController::class, 'editDob'])->name('editDob');
    Route::patch('/updateDob', [AccountController::class, 'updateDob'])->name('updateDob');
    Route::get('/editName', [AccountController::class, 'editName'])->name('editName');
    Route::patch('/updateName', [AccountController::class, 'updateName'])->name('updateName');

    //Update Address
    Route::get('/editAdress', [AccountController::class, 'editAddress'])->name('editAddress');
    Route::patch('/updateAdress', [AccountController::class, 'updateAdress'])->name('updateAddress');

    //Chat 
    Route::get('/showNotif', [ChatController::class, 'showNotification'])->name('notif.show');
    Route::get('/showMessage', [ChatController::class, 'showMessage'])->name('message.show');
    Route::post('/messages/{message}/read', [ChatController::class, 'markAsRead'])->name('message.read');

    // Rate & Review Doctor
    Route::get('/showRateForm/{docid}', [RateController::class, 'showRateForm'])->name('rate.show');
    Route::post('/review', [RateController::class, 'storeReview'])->name('review.store');
    Route::put('/review/update/{id}', [RateController::class, 'updateReview'])->name('review.update');
    Route::delete('/review/delete/{id}', [RateController::class, 'deleteReview'])->name('review.delete');
    Route::get('/schedule/check-availability/{scheduleId}', [BookingController::class, 'checkAvailability']);
});

//=====================================================
//=================Admin Authentication================
//=====================================================
Route::get('/admin_login', [AdminPageController::class, 'showLogin'])->name('admin_login');
Route::post('/admin_login', [AdminPageController::class, 'login']);

//=========Admin Module route==========
Route::middleware('auth:admin')->group(
    function () {
        Route::get('/dashboard', [AdminPageController::class, 'dashboard'])->name('dashboard');
        Route::get('/chart-data', [AdminPageController::class, 'chartData'])->name('chart.data');

        Route::get('/admin/stats', [AdminPageController::class, 'getStats'])->name('admin.stats');
        Route::get('/doctors', [AdminPageController::class, 'showDoctors'])->name('doctors.show');
        Route::get('/staffs', [AdminPageController::class, 'showStaff'])->name('staffs.show');
        Route::get('/patients', [AdminPageController::class, 'showPatients'])->name('patients.show');
        Route::get('/showSchedule', [AdminPageController::class, 'showSchedule'])->name('schedule.show');
        Route::get('/appointments', [AdminPageController::class, 'showAppointments'])->name('appointments.show');

        Route::get('/specialty', [AdminPageController::class, 'showSpecialty'])->name('specialty.show');
        Route::post('/specialty/add', [AdminPageController::class, 'addSpecialty'])->name('specialty.add');
        Route::get('/specialty/edit/{id}', [AdminPageController::class, 'editSpecialty'])->name('specialty.edit');
        Route::patch('/specialty/update/{id}', [AdminPageController::class, 'updateSpecialty'])->name('specialty.update');
        Route::delete('/specialty/delete/{id}', [AdminPageController::class, 'deleteSpecialty'])->name('specialty.delete');
        //=====CRUD doctor
        Route::post('/addDoctor', [AdminPageController::class, 'addDoctor'])->name('doctor.add');

        //=====CRUD staff
        Route::post('/addstaff', [AdminPageController::class, 'addStaff'])->name('staffs.add');
        Route::get('/staff_edit_form/{staffid}', [AdminPageController::class, 'staff_edit_form'])->name('staffs.edit');
        Route::post('/staff_update/{staffid}', [AdminPageController::class, 'staff_update'])->name('staffs.update');
        Route::post('/delete_staff/{staffid}', [AdminPageController::class, 'staff_delete'])->name('staffs.delete');

        //=====Adding doctor schedule
        // Route::post('/addschedule', [ScheduleController::class, 'addschedule'])->name('schedule.add');

        //=====DOCTOR CRUD 
        Route::get('/doctor_info/{docid}', [AdminPageController::class, 'doctor_info'])->name('doctor_info');
        Route::get('/show_edit_form/{docid}', [AdminPageController::class, 'show_edit_form'])->name('show_edit_form');
        Route::post('/update_doctor/{docid}', [AdminPageController::class, 'update_doctor'])->name('update_doctor');
        Route::post('/delete_doctor/{docid}', [AdminPageController::class, 'delete_doctor'])->name('delete_doctor');

        //====PATIENT CRUD 
        Route::get('/patient_info/{pid}', [AdminPageController::class, 'patient_info'])->name('patient_info');
        Route::get('/patient_edit/{pid}', [AdminPageController::class, 'patient_edit'])->name('patient_edit');
        Route::post('/patient_update/{pid}', [AdminPageController::class, 'patient_update'])->name('patient_update');
        Route::post('/patient_delete/{pid}', [AdminPageController::class, 'patient_delete'])->name('patient_delete');

        Route::get('/user_issue', [ProblemReportController::class, 'index'])->name('user_issue.show');
        Route::get('/admin/problem-reports/{problemReport}', [ProblemReportController::class, 'show'])->name('admin.problem-reports.show');

        Route::post('/admin/problem-report/{problemReport}/reply', [ProblemReportReplyController::class, 'store'])->name('admin.problem-report-reply.store');


        //=====SCHEDULE CRUD
        Route::get('/schedule_details/{scheduleid}', [ScheduleController::class, 'scheduleDetails'])->name('schedule_details');

        Route::get('/accounts/manage', [AdminPageController::class, 'manageAccount'])->name('account.manage');

        Route::post('/accounts/update-status', [AdminPageController::class, 'updateAccountStatus'])->name('account.updateStatus');
        Route::get('/settings', [AdminPageController::class, 'showsettings'])->name('settings');
    }
);


//=============================================================
//==================Doctor Authentication======================
//=============================================================
Route::get('/doctor_login', [AuthController::class, 'showDoctorLogin'])->name('doctor_login');
Route::post('/doctor_login', [AuthController::class, 'doctorLogin']);
//================Doctor Module route================
Route::middleware('auth:doctor')->group(function () {
    Route::get('/doctor_home', [DoctorController::class, 'doctor_home'])->name('doctor_home');
    Route::post('/doctor/update-status', [DoctorController::class, 'updateStatus'])->name('doctor.update-status');
    Route::get('/doctor/appointment/list', [DoctorController::class, 'appointment_list'])->name('appointment.list');
    Route::get('/doctor/appointment/create/', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::get('/doctor/schedule/list', [DoctorController::class, 'schedule_list'])->name('schedule.list');
    Route::get('/doctor/messages', [ChatController::class, 'showDoctorMessages'])->name('doctor.message.show');
    Route::post('/doctor/messages/{message}/read', [ChatController::class, 'markAsReadDoctor'])->name('message.read.doctor');
});

//==== OPEN TESTING
Route::get('/doctor/schedule/edit/{scheduleid}', [ScheduleController::class, 'editSchedule'])->name('schedule.edit');
Route::post('/doctor/schedule/update/{id}', [ScheduleController::class, 'update'])->name('schedule.update');
Route::post('/addschedule/auto', [ScheduleController::class, 'autoGenerate'])->name('schedule.auto');
Route::delete('/doctor/schedule/delete/{id}', [ScheduleController::class, 'delete'])->name('schedule.delete');

Route::get('/search/navigation', [NavigationSearchController::class, 'search'])
    ->name('navigation.search');

//=====APPOINTMENT CRUD
// Route::get('/mark-missed-appointments/{appoid}', [AppointmentController::class, 'markMissedAppointments'])->name('appointments.missed');
Route::post('/appointments/markMissed/{appoid}', [AppointmentController::class, 'markMissedAppointments'])->name('markMissed');
Route::post('/doctor/appointment/add/', [AppointmentController::class, 'add'])->name('appointments.add');
Route::post('/patients/search', [AppointmentController::class, 'searchPatients'])->name('patients.search');


//=====CHAT DOCTOR PATIENT
Route::get('/showChat/{receiver_id}', [ChatController::class, 'showChat'])->name('chat.show');
Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('message.send');
Route::get('/get-messages/{receiver_id}', [ChatController::class, 'getMessages'])->name('message.receive');
Route::get('/showChatDoctor/{receiver_id}', [ChatController::class, 'showChatDoctor'])->name('chat.doctor');
Route::put('/messages/{message}', [ChatController::class, 'update'])->name('messages.update');
Route::delete('/messages/{message}', [ChatController::class, 'destroy'])->name('messages.destroy');

//=====================================================
//=============Clerk/Staff Login=======================
//=====================================================
Route::get('/staff_login', [AuthController::class, 'showStaffLogin'])->name('staff_login');
Route::post('/staff_login', [AuthController::class, 'staffLogin']);
//==========Staff Module route=========
Route::middleware('auth:staff')->group(
    function () {
        Route::get('/staff_home', [StaffController::class, 'staffHome'])->name('staff_home');
        Route::get('/staff/stats', [StaffController::class, 'getStats'])->name('staff.stats');
        Route::get('/scanqr', [StaffController::class, 'scanqr'])->name('appointments.scan');
        Route::get('/appointment/verify/{id}', [AppointmentController::class, 'verifyQR'])->name('appointments.verify');
        Route::put('/appointment/finish/{id}', [AppointmentController::class, 'markAsFinished'])->name('appointments.finish');
    }

);

Route::middleware('auth:admin,staff,doctor')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'updateCurrentProfile'])->name('profile.update.current');
    Route::get('/changePersonnelPassword', [ChangePasswordController::class, 'changePersonnelPassword'])->name('personnel.changePassword');
});


