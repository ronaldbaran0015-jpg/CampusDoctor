<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProblemReport;
use Illuminate\Support\Facades\Auth;

class ProblemReportController extends Controller
{
    public function checkPatientSession()
    {
        if (!Auth::guard('patient')->check()) {
            return redirect()->route('login')->with('error', 'Action Forbidden');
        }
    }

    public function showReportProblemPage()
    {
        $this->checkPatientSession();

        return view('client.reportscreen.report_issue');
    }

    public function reportProblem(Request $request)
    {
        $this->checkPatientSession();

        // Validate the input
        $validatedData = $request->validate([
            'category' => 'required',
            'description' => 'required',
            'screenshot' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        // Store the report
        $report = new ProblemReport();
        $report->patient_id = Auth::guard('patient')->id();
        $report->category = $validatedData['category'];
        $report->description = $validatedData['description'];

        if ($request->hasFile('screenshot')) {
            $report->screenshot = $request->file('screenshot')->store('screenshots', 'public');
        }

        $report->save();

        // Return a success message
        return redirect()->route('help')->with('success', 'Problem reported successfully!');
    }

    public function showreportHistory()
    {
        $this->checkPatientSession();
        $patientId = auth()->guard('patient')->user()->pid;
        $patient = Auth::guard('patient')->user();
        $reports = ProblemReport::where('patient_id', $patientId)->get();
        return view('client.reportscreen.report_issue_history', compact('reports'));
    }


    public function index()
    {
        $problemReports = ProblemReport::with('patient')->get();
        return view('admin.user_issue', compact('problemReports'));
    }

    public function show(ProblemReport $problemReport)
    {
        return view('admin.user_show_issue', compact('problemReport'));
    }
}
