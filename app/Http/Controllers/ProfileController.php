<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Specialties;
use App\Models\Staff;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function profile()
    {
        $guard = $this->detectProfileGuard();
        if (!$guard) {
            abort(403);
        }

        $user = Auth::guard($guard)->user();
        $profile = $this->profileConfigForGuard($guard);

        $specialties = Specialties::all();

        return view('partials.profile', [
            'guard' => $guard,
            'user' => $user,
            'profile' => $profile,
            'specialties' =>$specialties
        ]);
    }

    public function updateCurrentProfile(Request $request)
    {
        $guard = $this->detectProfileGuard();
        if (!$guard) {
            abort(403);
        }

        return $this->updateProfileForGuard($request, $guard);
    }

    public function adminUpdateProfile(Request $request)
    {
        return $this->updateProfileForGuard($request, 'admin');
    }

    public function staffUpdateProfile(Request $request)
    {
        return $this->updateProfileForGuard($request, 'staff');
    }

    public function doctorUpdateProfile(Request $request)
    {
        return $this->updateProfileForGuard($request, 'doctor');
    }

    private function updateProfileForGuard(Request $request, string $guard)
    {


        $allowedGuards = ['admin', 'staff', 'doctor'];
        if (!in_array($guard, $allowedGuards, true)) {
            abort(403);
        }

        $user = Auth::guard($guard)->user();
        if (!$user) {
            abort(403);
        }

        $config = $this->profileConfigForGuard($guard);

        $rules = [
            $config['request_name_key'] => ['required'],
            $config['request_contact_key'] => ['nullable'],
            $config['request_email_key'] => ['nullable'],
           
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
        ];

        $validated = $request->validate($rules);

        // Basic fields
        $user->{$config['model_name_field']} = $validated[$config['request_name_key']];
        
        if (array_key_exists($config['request_contact_key'], $validated)) {
            $user->{$config['model_contact_field']} = $validated[$config['request_contact_key']];
        }
        if (array_key_exists($config['request_email_key'], $validated)) {
            $user->{$config['model_email_field']} = $validated[$config['request_email_key']];
        }
        // Image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            File::ensureDirectoryExists(public_path($config['upload_dir']));

            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path($config['upload_dir']), $imageName);
            $user->{$config['model_image_field']} = $imageName;
        }

        // 🔐 Verify current password
        if (!$request->filled('current_password')) {
            return back()->withErrors([
                'current_password' => 'Password confirmation is required.',
            ]);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Incorrect password.',
            ]);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    private function profileConfigForGuard(string $guard): array
    {
        if ($guard === 'admin') {
            return [
                'model' => Admin::class,
                'request_name_key' => 'adminname',
                'request_contact_key' => 'contact',
                'model_name_field' => 'adminname',
                'model_contact_field' => 'admincontact',
                'model_image_field' => 'adminimage',
                'upload_dir' => 'uploads/admins',
            ];
        }

        if ($guard === 'staff') {
            return [
                'model' => Staff::class,
                'request_name_key' => 'staffname',
                'request_contact_key' => 'staffcontact',
                'model_name_field' => 'staffname',
                'model_contact_field' => 'staffcontact',
                'model_email_field' => 'staffemail',
                'model_image_field' => 'staffimage',
                'upload_dir' => 'uploads/staffs',
            ];
        }

        return [
            'model' => Doctor::class,
            'request_name_key' => 'name',
            'request_contact_key' => 'contact',
            'request_email_key' => 'email',
            
            'model_name_field' => 'name',
            'model_contact_field' => 'contact',
            'model_email_field' => 'email',
            'model_specialties_field' => 'specialties',
            'model_image_field' => 'image',
            'upload_dir' => 'uploads/doctors',
            
            
        ];
    }

    private function detectProfileGuard(): ?string
    {
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }

        if (Auth::guard('staff')->check()) {
            return 'staff';
        }

        if (Auth::guard('doctor')->check()) {
            return 'doctor';
        }

        return null;
    }
}
