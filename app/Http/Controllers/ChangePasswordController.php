<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ChangePasswordController extends Controller
{

    public function checkAuthorizedPersonnel()
    {
        if (Auth::guard('doctor')->check()) {
            return 'doctor';
        }
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }
        if (Auth::guard('staff')->check()) {
            return 'staff';
        }

        redirect()->route('login')->send();
        exit;
    }
    // For Patient
    public function changePassword()
    {
        return view('client.changepassword');
    }
   
    // For Personel

    public function changePersonnelPassword()
    {
        $this->checkAuthorizedPersonnel();
        return view('admin.change_password');
    }

    // For All
    public function updatePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        // Automatically detect which guard is logged in
        $guards = ['admin', 'doctor', 'staff', 'patient'];

        $user = null;
        $activeGuard = null;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $activeGuard = $guard;
                break;
            }
        }

        if (!$user) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Determine password column depending on guard model 
        $passwordField = match ($activeGuard) {
            'admin'  => 'adminpassword',
            'doctor' => 'password',
            'staff'  => 'staffpassword',
            'patient' => 'password', // default Laravel field
            default  => 'password'
        };

        // Validate current password
        if (!Hash::check($request->current_password, $user->{$passwordField})) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        // Update password
        $user->{$passwordField} = bcrypt($request->new_password);
        $user->save();
        // Redirect based on user type
        return match ($activeGuard) {
            'admin'   => redirect()->back()->with('success', 'Password updated successfully'),
            'doctor'  => redirect()->back()->with('success', 'Password updated successfully'),
            'staff'   => redirect()->back()->with('success', 'Password updated successfully'),
            'patient' => redirect()->route('account_center')->with('success', 'Password updated successfully'),
             default  => redirect()->back()->with('success', 'Password updated')
        };
    }
}