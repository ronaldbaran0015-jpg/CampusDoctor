<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;

class BookingController extends Controller
{

    public function checkPatientSession()
    {
        if (!Auth::guard('patient')->check()) {
            return redirect()->route('login')->with('error', 'Action Forbidden');
        }
    }

    private function hasDuplicateBooking($pid, $scheduleId)
    {
        return Appointment::where('pid', $pid)
            ->where('scheduleid', $scheduleId)
            ->whereIn('status', ['pending', 'confirmed', 'approved'])
            ->exists();
    }

    private function isFullyBooked($scheduleId, $maxNop)
    {
        $currentCount = Appointment::where('scheduleid', $scheduleId)
            ->whereIn('status', ['pending', 'confirmed', 'approved'])
            ->count();

        return $currentCount >= $maxNop;
    }

    private function createAppointment($pid, $docid, $schedule, $reason)
    {
        return Appointment::create([
            'pid'        => $pid,
            'docid'        => $docid,
            'apponum'    => rand(1000, 9999),
            'scheduleid' => $schedule->scheduleid,
            'appodate'   => $schedule->scheduledate,
            'start_time' => $schedule->start_time,
            'end_time'   => $schedule->end_time,
            'status'     => 'pending',
            'reason'     => $reason,
        ]);
    }

    public function booking(Request $request, $docid)
    {
        $this->checkPatientSession();

        $doctor  = Doctor::with('specialty')->findOrFail($docid);
        $patient = Auth::guard('patient')->user();

        // Handle POST — Save appointment
        if ($request->isMethod('post')) {
            $schedule = Schedule::findOrFail($request->schedule_id);
            // Validate duplicate
            if ($this->hasDuplicateBooking($patient->pid, $schedule->scheduleid)) {
                return back()->with('error', 'You already booked this schedule.');
            }

            // Validate max NOP
            if ($this->isFullyBooked($schedule->scheduleid, $schedule->nop)) {
                return back()->with('error', 'This schedule is already fully booked.');
            }

            // Create appointment
            $reason = $request->input('reason') ?? null;
            $appointment = $this->createAppointment($patient->pid, $docid ,$schedule, $reason);

            return view('client.bookingscreen.booking-success', compact('appointment', 'doctor', 'patient'));
        }

        // Handle GET — Show booking confirmation
        $schedule = $request->schedule_id ? Schedule::find($request->schedule_id) : null;
        $time     = $schedule ? "{$schedule->start_time} - {$schedule->end_time}" : null;

        return view('client.bookingscreen.booking', compact('doctor', 'patient', 'schedule', 'time'));
    }

    public function checkAvailability($scheduleId)
    {
        $schedule = Schedule::findOrFail($scheduleId);

        $bookedCount = Appointment::where('scheduleid', $schedule->scheduleid)
            ->whereIn('status', ['pending', 'confirmed', 'approved'])
            ->count();

        $isFullyBooked = $bookedCount >= $schedule->nop;

        return response()->json([
            'isFullyBooked' => $isFullyBooked
        ]);
    }
}
