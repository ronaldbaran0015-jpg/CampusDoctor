<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('patient')->check()) {
            return redirect()->route('myhome');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'contact'    => ['required'],
            'password' => ['required'],
        ]);

        // Unique key per user + IP
        $key = Str::lower($credentials['contact']) . '|' . $request->ip();

        // Check if already locked out
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'contact' => "Too many login attempts. Please try again in {$seconds} seconds."
            ]);
        }

        // Account existence
        $patient = Patient::where('contact', $credentials['contact'])->first();

        if (!$patient) {
            RateLimiter::hit($key, 60); // increment failed attempt
            return back()->withErrors(['contact' => 'Invalid credentials.']);
        }

        // Account state checks
        if ($patient->status === 'deactivated') {
            return back()->withErrors(['contact' => 'Your account is deactivated.']);
        }



        // Attempt login
        if (!Auth::guard('patient')->attempt($credentials)) {
            RateLimiter::hit($key, 60); // increment failed attempt
            return back()->withErrors(['password' => 'Invalid credentials.']);
        }

        // Clear attempts on success
        RateLimiter::clear($key);

        // Regenerate session
        $request->session()->regenerate();

        return redirect()->intended('/myhome')->with('success', 'Logged in successfully!');
    }

    // Show the signup form
    public function showSignupForm()
    {
        if (Auth::guard('patient')->check()) {
            return redirect()->route('myhome');
        }
        return view('auth.signup');
    }

    // Handle signup request
    public function signup(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'name' => ['required'],
            'contact' => ['required', 'unique:patients'],
            'email' => ['required', 'email', 'unique:patients'],
            'address' => ['required'],
            'dob_day' => ['required', 'integer', 'between:1,31'],
            'dob_month' => ['required', 'integer', 'between:1,12'],
            'dob_year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],


        ]);

        // Combine DOB fields into a single date
        try {
            $dob = \Carbon\Carbon::createFromDate($data['dob_year'], $data['dob_month'], $data['dob_day'])->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withErrors(['dob' => 'Invalid date of birth.']);
        }

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/patients'), $imageName);
        }

        // Create new patient
        $patient = Patient::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'dob' => $dob,
            'contact' => $data['contact'],
            'image' => $imageName,

        ]);

        // Log the patient in
        Auth::guard('patient')->login($patient);

        return redirect('/myhome')->with('success', 'Registered Success');
    }


    public function showDoctorLogin()
    {

        if (Auth::guard('doctor')->check()) {
            return redirect()->route('doctor_home');
        }

        return view('auth.doctor_login');
    }

    public function doctorLogin(Request $request)
    {
        // validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],   // use 'username' if you want login by username
            'password' => ['required'],
        ]);

        if (Auth::guard('doctor')->attempt(
            ['email' => $credentials['email'], 'password' => $credentials['password']]
        )) {
            $request->session()->regenerate();
            return redirect()->intended('/doctor_home');
        }
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
    public function showStaffLogin()
    {
        if (Auth::guard('staff')->check()) {
            return redirect()->route('staff_home');
        }
        return view('auth.staff_login');
    }

    public function staffLogin(Request $request)
    {
        // validate input
        $credentials = $request->validate([
            'staffemail' => ['required', 'email'],   // use 'username' if you want login by username
            'staffpassword' => ['required'],
        ]);

        if (Auth::guard('staff')->attempt(
            ['staffemail' => $credentials['staffemail'], 'password' => $credentials['staffpassword']]
        )) {
            $request->session()->regenerate();
            return redirect()->intended('/staff_home');
        }

        return back()->withErrors([
            'staffemail' => 'Invalid credentials.',
        ]);
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return redirect('/login')->with('success', 'Logged out success');
    }
}
