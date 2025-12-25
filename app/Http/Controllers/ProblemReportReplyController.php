<?php

namespace App\Http\Controllers;

use App\Models\ProblemReport;
use App\Models\ProblemReportReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProblemReportReplyController extends Controller
{
    public function store(Request $request, ProblemReport $problemReport)
    {
        $validatedData = $request->validate([
            'reply' => 'required',
        ]);

        $reply = new ProblemReportReply();
        $reply->problem_report_id = $problemReport->id;
        $reply->admin_id = Auth::guard('admin')->user()->adminid;
        $reply->reply = $validatedData['reply'];
        $reply->save();

        return back()->with('success', 'Reply added successfully!');
    }
}
