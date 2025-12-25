<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Specialties;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class DoctorController extends Controller
{

    public function doctor_home()
    {
        $doctor = Auth::guard('doctor')->user();
        $schedules = Schedule::where('docid', $doctor->docid)->get();
        $scheduleCount = $schedules->count();
        $pid = 11;
        $patient = Patient::find($pid);
        $appointmentCount = Appointment::WhereHas('schedule',
         function($query) use($doctor){
            $query->where('docid', $doctor->docid);
         })->count();
         
        $appointments = Appointment::WhereHas('schedule',
         function($query) use($doctor){
            $query->where('docid', $doctor->docid);
         })->with('schedule', 'patient')
         ->where('status', 'pending')
         ->get();

        $today = Carbon::today();
        $current = Appointment::WhereHas('schedule',
         function($query) use($doctor){
            $query->where('docid', $doctor->docid);
         })->whereDate('appodate', $today)
         ->with('schedule', 'patient')->count();
         
        return view('doctor.home', compact('doctor', 'appointments',  'appointmentCount', 'schedules', 'scheduleCount', 'current', 'patient'));
    }
    public function updateStatus(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();
        $doctor->status = $request->input('status');
        $doctor->save();
        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function appointment_list(){
        $doctor = Auth::guard('doctor')->user();
        $appointments = Appointment::WhereHas(
            'schedule',
            function ($query) use ($doctor) {
                $query->where('docid', $doctor->docid);
            }
        )->where('status', 'pending')
        ->with('schedule', 'patient')->get();

        return view('doctor.appointment',compact('appointments'));
    }
    public function schedule_list(){
        $doctor = Auth::guard('doctor')->user();

        $schedules = Schedule::where('docid', $doctor->docid)->get();

        return view('doctor.schedule', compact('doctor', 'schedules'));
    }

}
