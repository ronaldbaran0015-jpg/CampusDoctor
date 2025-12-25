<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot():void
    {
        Relation::morphMap([
            'doctor' => Doctor::class,
            'patient' => Patient::class,
        ]);

        View::composer('*', function ($view) {
            $user_admin = Auth::guard('admin')->user();
            $user_doctor = Auth::guard('doctor')->user();
            $user_staff = Auth::guard('staff')->user();
            $patient = Auth::guard('patient')->user();

            $view->with('user_admin', $user_admin);
            $view->with('user_doctor', $user_doctor);
            $view->with('user_staff', $user_staff);
            $view->with('user_patient', $patient);
            if (Auth::guard('patient')->check()) {
              $patientId = Auth::guard('patient')->id();
              $upcoming = Appointment::where('pid', $patientId)->where('status', 'pending')->count();
              $message_count = Message::where('receiver_id', $patientId)
                  ->where('receiver_type', 'patient')
                  ->where('read', false)
                  ->where('sender_type', 'doctor')
                  
                  ->count();
                
            }else{
                $upcoming = collect();
                $message_count = 0;
            }

            $view->with('upcoming', $upcoming);
            $view->with('message_count', $message_count);


        });
    }
}
