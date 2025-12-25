<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\ProblemReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AccountController extends Controller
{
    
    public function account_center()
    {
        $patient = Auth::guard('patient')->user();
        $patientId = auth()->guard('patient')->user()->pid;
        return view('client.accountscreen.accountcenter', compact('patient'));
    }

    public function showPersonalDetailsPage()
    {
        $patient = Auth::guard('patient')->user();
        $patientId = auth()->guard('patient')->user()->pid;
        return view('client.personal_details', compact('patient'));
    }

    public function showAccControlPage()
    {
        return view('client.accountscreen.account_control');
    }
    public function updateAccountStatus(Request $request)
    {
        $request->validate([
            'opt' => 'required|in:deactivate,delete',
            'current_password' => 'required',
        ]);
        $patient = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $patient->password)) {
            return back()->withErrors('Current password is incorrect.');
        }

        // Password correct – proceed with action
        if ($request->opt === 'deactivate') {
            $patient->status = 'deactivated';
            $patient->save();
            Auth::logout();
            return redirect('login')->with('success', 'Account deactivated successfully');
        }
        if ($request->opt === 'delete') {
            $patient->delete();
            Auth::logout();
            return redirect('/')->with('success', 'Account deleted successfully');
        }
    }

    public function editContactInfo()
    {
        $patient = Auth::guard('patient')->user();
        $contact = $patient->contact;
        $email = $patient->email;
        return view('client.accountscreen.account_contact', compact('contact', 'email'));
    }
    public function updateContactInfo(Request $request)
    {
        $request->validate([
            'contact' => 'required',
            'email' => 'required|email',
        ]);
        $patientId = Auth::guard('patient')->id();
        $patient = Patient::find($patientId);

        $patient->contact = $request->input('contact');
        $patient->email = $request->input('email');

        $patient->save();
        return redirect()->route('account_center')->with('success', 'Successfully updated contacts');
    }

    public function editDob()
    {
        $patient = Auth::guard('patient')->user();
        $dob = $patient->dob;
        return view('client.accountscreen.account_dob', compact('dob'));
    }

    public function updateDob(Request $request)
    {
        $data = $request->validate([
            'dob_day' => ['required', 'integer', 'between:1,31'],
            'dob_month' => ['required', 'integer', 'between:1,12'],
            'dob_year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        ]);

        try {
            $dob = \Carbon\Carbon::createFromDate($data['dob_year'], $data['dob_month'], $data['dob_day'])->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withErrors(['dob' => 'Invalid date of birth.']);
        }
        $patientId = Auth::guard('patient')->id();
        $patient = Patient::find($patientId);

        $patient->dob = $dob;
        $patient->save();

        return redirect()->route('showPersonalDetailsPage')->with('success', 'Birthday updated successfully');
    }

    public function editName()
    {
        $patient = Auth::guard('patient')->user();
        $name = $patient->name;
        return view('client.accountscreen.account_name', compact('name'));
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $patientId = Auth::guard('patient')->id();
        $patient = Patient::find($patientId);
        $patient->name = $request->input('name'); // You forgot to update the name
        $patient->save();
        return redirect()->route('account_center')->with('success', 'Name updated successfully');
    }

    public function editAddress()
    {
        $patient = Auth::guard('patient')->user();
        $address = $patient->address;

        return view('client.accountscreen.account_address', compact('address'));
    }

    public function updateAdress(Request $request)
    {
        $request->validate([
            'address' => 'required'
        ]);
        $patientId = Auth::guard('patient')->id();
        $patient = Patient::find($patientId);
        $patient->address = $request->input('address'); // You forgot to update the name
        $patient->save();
        return redirect()->route('account_center')->with('success', 'Address updated successfully');
    }


    public function showActivateAccountForm()
    {
        return view('auth.activate');
    }
    public function activateAccount(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $patient = Patient::where('email', $request->email)->first();
        if (!$patient) {
            return back()->with('error', 'Invalid phone number');
        }
        if ($patient->status == 'active') {
            return back()->withErrors([
                'email' => 'Your account is already activated',
            ]);
        }
        if ($patient->status !== 'deactivated') {
            return back()->with('error', 'Your account is not deactivated');
        }
        if (!Hash::check($request->password, $patient->password)) {
            return back()->withErrors([
                'email' => 'Invalid Password',
            ]);
        }
        $patient->status = 'active';
        $patient->save();
        return redirect()->route('login')->with('success', 'Account activated successfully');
    }
}
