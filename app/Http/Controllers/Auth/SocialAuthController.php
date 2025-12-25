<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Request;

class SocialAuthController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->scopes(['email'])->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {


        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $patient = Patient::where('facebook_id', $facebookUser->getId())
                ->orWhere('email', $facebookUser->getEmail())
                ->first();

            if (!$patient) {
                $patient = Patient::create([
                    'name'        => $facebookUser->getName(),
                    'email'       => $facebookUser->getEmail(),
                    'facebook_id' => $facebookUser->getId(),
                    'password'    => bcrypt(Str::random(24)),
                    'contact'     => '00000000000', // or 'N/A'
                    'address'     => 'Not provided',
                    'status'      => 'active',
                ]);
            } elseif (!$patient->facebook_id) {
                $patient->update([
                    'facebook_id' => $facebookUser->getId()
                ]);
            }

            Auth::guard('patient')->login($patient);
            // $request->session()->regenerate();

            return redirect()->intended('/myhome')->with('success', 'Logged in successfully!');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Facebook login failed.');
        }
    }


    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if patient already exists
            $patient = Patient::where('email', $googleUser->getEmail())->first();

            if (!$patient) {
                // Create patient account automatically
                $patient = Patient::create([
                    'name'       => $googleUser->getName(),
                    'email'      => $googleUser->getEmail(),
                    'google_id'  => $googleUser->getId(),
                    'password'    => bcrypt(Str::random(24)),
                    'contact'     => '00000000000', // or 'N/A'
                    'address'     => 'Not provided',
                    'status'      => 'active',
                ]);
            }

            // Login patient using guard
            Auth::guard('patient')->login($patient);

            return redirect()->intended('/myhome')->with('success', 'Logged in successfully!');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Facebook login failed.');
        }
    }
}
