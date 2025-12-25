<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProblemReport;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{

    public function checkPatientSession()
    {
        if (!Auth::guard('patient')->check()) {
            return redirect()->route('login')->with('error', 'Action Forbidden');
        }
    }
    public function showSetting()
    {
        $this->checkPatientSession();
        return view('client.setting');
    }

    public function showPolicy()
    {
        $this->checkPatientSession();

        return view('client.policy');
    }

    public function showAbout()
    {
        $this->checkPatientSession();

        return view('client.about');
    }
    public function showHelpPage()
    {
        $this->checkPatientSession();
        return view('client.help');
    }
       
}
