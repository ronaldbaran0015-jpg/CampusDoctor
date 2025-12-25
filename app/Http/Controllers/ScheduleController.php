<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends BaseController
{
     protected function checkAuthorizedPersonnel()
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
    public function scheduleDetails($docid)
    {
        $this->checkAuthorizedPersonnel();
        $schedules = Schedule::where('docid', $docid)->get();
        $doctor = Doctor::find($docid);
        abort_if(!$schedules || !$doctor, 404);
        return view('admin.schedule_details', compact('schedules', 'doctor'));
    }



    public function addschedule(Request $request)
    {
        $this->checkAuthorizedPersonnel();
        $request->validate([
            'docid' => 'required|exists:doctors,docid',
            'title' => 'required|string|max:255',
            'scheduledate' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'nop' => 'required|integer|min:1',
        ]);

        Schedule::create([
            'docid' => $request->docid,
            'title' => $request->title,
            'scheduledate' => $request->scheduledate,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'nop' => $request->nop,
        ]);

        return redirect()->back()->with('success', 'Schedule created successfully!');
    }

    public function autoGenerate(Request $request)
    {
        $this->checkAuthorizedPersonnel();
        $request->validate([
            'docid' => 'required|exists:doctors,docid',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2024',
            'time_slots' => 'required|array|min:1',
            'time_slots.*.start' => 'required|date_format:H:i',
            'time_slots.*.end' => 'required|date_format:H:i|after:time_slots.*.start',
            'nop' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
        ]);

        $doctorId = $request->docid;
        $month = $request->month;
        $year = $request->year;
        $timeSlots = $request->time_slots;
        $nop = $request->nop;
        $title = $request->title;
        $startDate = \Carbon\Carbon::createFromDate($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $today = \Carbon\Carbon::today();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Skip weekends
            if ($date->isWeekend()) continue;
            // Skip past days
            if ($date->lt($today)) continue;

            foreach ($timeSlots as $slot) {
                $existingSchedule = Schedule::where('docid', $doctorId)
                    ->where('scheduledate', $date->format('Y-m-d'))
                    ->where('start_time', $slot['start'])
                    ->where('end_time', $slot['end'])
                    ->first();

                if ($existingSchedule) {
                    return redirect()->back()->withErrors('errors', 'Duplicate Entry!');
                }

                Schedule::create([
                    'docid' => $doctorId,
                    'title' => $title,
                    'scheduledate' => $date->format('Y-m-d'),
                    'start_time' => $slot['start'],
                    'end_time' => $slot['end'],
                    'nop' => $nop,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Schedules auto-generated successfully for upcoming dates!');
    }


    public function editSchedule($scheduleid){

        $this->checkAuthorizedPersonnel();
        $schedule = Schedule::find($scheduleid);
        if (!$schedule) {
           abort(404);
        }
        return view('admin.schedule_edit', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorizedPersonnel();
        $sched = Schedule::findOrFail($id);
        $sched->title = $request->title;
        $sched->scheduledate = $request->scheduledate;
        $sched->start_time = $request->start_time;
        $sched->end_time = $request->end_time;
        $sched->nop = $request->nop;
        $sched->save();
        if (Auth::guard('doctor')->check()) {
            return redirect()->route('schedule.list')->with('success', 'Schedule updated successfully');;
        }

        return redirect()->back()->with('success', 'Schedule updated successfully');;
    }
    public function delete($id)
    {
        $this->checkAuthorizedPersonnel();
        $sched = Schedule::findOrFail($id);
        if (!$sched) {
            abort(404);
        }
        $sched->delete();
        if (Auth::guard('doctor')->check()) {
            return redirect()->back()->with('success', 'Schedule Delete successfully');;
        }
        return redirect()->route('schedule_details', $sched->mydoctor->docid)->with('success', 'Schedule deleted successfully');;
    }




    // public function autoGenerate(Request $request)
    // {
   
    //     $request->validate([
    //         'docid' => 'required|exists:doctors,docid',
    //         'month' => 'required|integer|min:1|max:12',
    //         'year' => 'required|integer|min:2024',
    //         'time_slots' => 'required|array|min:1',
    //         'time_slots.*.start' => 'required|date_format:H:i',
    //         'time_slots.*.end' => 'required|date_format:H:i|after:time_slots.*.start',
    //         'nop' => 'required|integer|min:1',
    //         'title' => 'required|string|max:255',
    //     ]);

    //     $doctorId = $request->docid;
    //     $month = $request->month;
    //     $year = $request->year;
    //     $timeSlots = $request->time_slots;
    //     $nop = $request->nop;
    //     $title = $request->title;

    //     $startDate = \Carbon\Carbon::createFromDate($year, $month, 1);
    //     $endDate = $startDate->copy()->endOfMonth();
    //     $today = \Carbon\Carbon::today();

    //     for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
    //         // Skip weekends
    //         if ($date->isWeekend()) continue;

    //         // Skip past days
    //         if ($date->lt($today)) continue;

    //         foreach ($timeSlots as $slot) {

    //             $isExisting = Schedule::where('docid', $doctorId)
    //                 ->where('scheduledate', $date->format('Y-m-d'))
    //                 ->where('start_time', $slot['start'])
    //                 ->where('end_time', $slot['end'])->first();

    //             if ($isExisting) {
    //                 return back()->with(
    //                     'error',
    //                     'This schedule already exists.'
    //                 );
    //             }
    //             Schedule::create([
    //                 'docid' => $doctorId,
    //                 'title' => $title,
    //                 'scheduledate' => $date->format('Y-m-d'),
    //                 'start_time' => $slot['start'],
    //                 'end_time' => $slot['end'],
    //                 'nop' => $nop,
    //             ]);
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Schedules auto-generated successfully for upcoming dates!');
    // }
}
