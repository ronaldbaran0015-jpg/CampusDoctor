<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends BaseController
{



    public function getStats()
    {
        return response()->json([
            'scanned'   => Appointment::where('status', 'finished')->count(),
            'pending'   => Appointment::where('status', 'pending')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ]);
    }
    public function staffHome()
    {
    
        $appointments = Appointment::all();
        $scanned = Appointment::where('status', 'finished')->count();
        $pending = Appointment::where('status', 'pending')->get();
        $cancelled = Appointment::where('status', 'cancelled')->count();
        return view('clerk.home', compact('appointments', 'scanned', 'pending', 'cancelled'));
    }

    public function scanqr()
    {
        return view('clerk.scanqr');
    }
    public function showStaff()
    {
        $staffs = Staff::all();
        $staffCount = Staff::count();
        return view('admin.staffs', compact('staffs', 'staffCount'));
    }
}
