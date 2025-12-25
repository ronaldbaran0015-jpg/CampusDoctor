<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
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

    public function verifyQR($id)
    {
        // Always force Manila timezone to avoid wrong date
        $now = Carbon::now('Asia/Manila')->setSeconds(0);
        $today = Carbon::today('Asia/Manila');

        $appointment = Appointment::with(['patient', 'doctor'])->find($id);

        if (!$appointment) {
            return view('appointments.error', [
                'message' => 'Appointment not found'
            ]);
        }
        // Parse appointment date & times using Manila timezone
        $appointmentDate = Carbon::parse($appointment->appodate, 'Asia/Manila');
        $startTime = Carbon::parse($appointment->appodate . ' ' . $appointment->start_time, 'Asia/Manila');
        $endTime   = Carbon::parse($appointment->appodate . ' ' . $appointment->end_time, 'Asia/Manila');

        // 🚫 Not the correct day
        if (!$appointmentDate->isSameDay($today)) {
            return view('clerk.appointments.error', [
                'message' => 'This appointment is only valid on ' . $appointmentDate->format('F d, Y'),
                'appointment' => $appointment
            ]);
        }

        // 🚫 Too early
        if ($now->lt($startTime)) {
            return view('clerk.appointments.error', [
                'message' => 'Too early! This appointment starts at ' . $startTime->format('g:i A'),
                'appointment' => $appointment
            ]);
        }

        // 🚫 Too late
        if ($now->gt($endTime)) {
            return view('clerk.appointments.error', [
                'message' => 'This appointment has already ended at ' . $endTime->format('g:i A'),
                'appointment' => $appointment
            ]);
            $this->markMissedAppointments($id);
        }

        //  Do NOT auto-finish here — show verification page first
        return view('clerk.appointments.verify', [
            'appointment' => $appointment
        ]);
    }


    public function markAsFinished($id)
    {


        $appointment = Appointment::find($id);

        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Appointment already Processed');
        }

        $appointment->status = 'finished';
        $appointment->qr_scanned = true;
        $appointment->save();

        return redirect()->route('appointments.verify', $id)
            ->with('success', 'Appointment successfully marked as finished.');
    }


    public function markMissedAppointments($appoid)
    {

        $this->checkAuthorizedPersonnel();

        $appointment = Appointment::find($appoid);

        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Appointment already marked as finished or cancelled.');
        }

        $appointment->status = 'missed';
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment successfully marked as finished.');
    }

    public function create()
    {
        $doctor = Auth::guard('doctor')->user();
        // Load all schedules of the logged-in doctor
        $schedules = Schedule::where('docid', $doctor->docid)
            ->orderBy('scheduledate')
            ->orderBy('start_time')
            ->get();

        return view('doctor.create', compact('schedules'));
    }

    private function doctorHasDuplicate($pid, $scheduleId)
    {
        return Appointment::where('pid', $pid)
            ->where('scheduleid', $scheduleId)
            ->whereIn('status', ['pending', 'confirmed', 'approved'])
            ->exists();
    }

    private function doctorIsFullyBooked($scheduleId, $maxNop)
    {
        $count = Appointment::where('scheduleid', $scheduleId)
            ->whereIn('status', ['pending', 'confirmed', 'approved'])
            ->count();

        return $count >= $maxNop;
    }



    // Add appointment — creates patient if not found
    public function add(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();

        // validate incoming data
        $data = $request->validate([
            'schedule_id' => 'required|exists:schedules,scheduleid',
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email|max:255',
            'contact'       => 'nullable|string|max:50',
            'address'     => 'nullable|string|max:500',
            'reason'     => 'nullable|string|max:1000',
        ]);

        // Load selected schedule
        $schedule = Schedule::findOrFail($data['schedule_id']);

        // Ensure the doctor owns this schedule
        if ($schedule->docid !== $doctor->docid) {
            return back()->with('error', 'Invalid schedule selected.');
        }

        // Find patient by email or contact
        $patient = Patient::where('email', $data['email'])
            ->orWhere('contact', $data['contact'])
            ->first();

        // If not found, create patient
        if (!$patient) {
            $patient = Patient::create([
                'name'     => $data['name'],
                'email'    => $data['email'] ?? null,
                'contact'  => $data['contact'] ?? null,
                'address'  => $data['address'] ?? null,
                'gender'   => $request->input('gender'),
                'password' => Hash::make('password'),
                'status'   => 'deactivated',
            ]);
        }

        // Check duplicate
        if ($this->doctorHasDuplicate($patient->pid, $schedule->scheduleid)) {
            return back()->with('error', 'This patient already has an appointment for this schedule.');
        }

        // Check if schedule is full
        if ($this->doctorIsFullyBooked($schedule->scheduleid, $schedule->nop)) {
            return back()->with('error', 'This schedule is fully booked.');
        }

        // Create appointment
        Appointment::create([
            'pid'        => $patient->pid,
            'scheduleid' => $schedule->scheduleid,
            'apponum'    => rand(1000, 9999),
            'appodate'   => $schedule->scheduledate,
            'start_time' => $schedule->start_time,
            'end_time'   => $schedule->end_time,
            'status'     => 'pending',
            'reason'     => $data['reason'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Appointment created successfully.');
    }


    public function searchPatients(Request $request)
    {
        $query = trim($request->input('search'));
        if ($query === '') return response()->json([]);

        $patients = \App\Models\Patient::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('contact', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($patients->map(fn($p) => [
            'id' => $p->pid,
            'name' => $p->name,
            'email' => $p->email,
            'contact' => $p->contact,
            'address' => $p->address,
        ]));
    }
}
