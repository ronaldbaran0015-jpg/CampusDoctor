<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Bio;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Specialties;
use Carbon\Carbon;

class ClientController extends Controller
{

    /*===========================
            Homescreen 
    =============================*/
    public function myhome()
    {
        $patient = Auth::guard('patient')->user();
        $patientId = auth()->guard('patient')->user()->pid;
        $doctors = Doctor::with('specialty')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->take(6)
            ->get();
        $appointments = Appointment::where('pid', $patientId)
            ->whereIn('status', ['cancelled', 'finished', 'pending'])
            ->with('schedule.mydoctor')->get();

        $specialties = Specialties::take(5)->get();

        $upcomingCount = $appointments->where('status', 'pending')->count();

        return view('client.homescreen.home', compact('doctors', 'patient', 'upcomingCount', 'appointments', 'specialties'));
    }

    public function mydoctor(Request $request)
    {
        $patient = Auth::guard('patient')->user();

        $doctors = Doctor::with('specialty')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')

            // Specialty filter (multiple)
            ->when($request->specialties, function ($query) use ($request) {
                $query->whereIn('specialties', $request->specialties);
            })

            // Rating filter
            ->when($request->rating, function ($query) use ($request) {
                $query->having('reviews_avg_rating', '>=', $request->rating);
            })

            // Availability filter (basic example)
            ->when($request->availability, function ($query) use ($request) {

                if ($request->availability === 'today') {
                    $query->whereHas('hasSchedule', function ($q) {
                        $q->whereDate('scheduledate', now()->toDateString());
                    });
                }

                if ($request->availability === 'week') {
                    $query->whereHas('hasSchedule', function ($q) {
                        $q->whereBetween('scheduledate', [
                            now()->startOfWeek(),
                            now()->endOfWeek()
                        ]);
                    });
                }

                if ($request->availability === 'morning') {
                    $query->whereHas('hasSchedule', function ($q) {
                        $q->whereTime('start_time', '<=', '12:00:00');
                    });
                }

                if ($request->availability === 'afternoon') {
                    $query->whereHas('hasSchedule', function ($q) {
                        $q->whereTime('start_time', '>=', '12:00:00');
                    });
                }
            })

            ->get();

        $specialties = Specialties::all();

        return view('client.homescreen.doctors', compact(
            'doctors',
            'patient',
            'specialties'
        ));
    }
    public function myschedule()
    {
        $patientId = auth()->guard('patient')->user()->pid;

        $patient = Auth::guard('patient')->user();
        $appointments = Appointment::where('pid', $patientId)
            ->with('schedule.mydoctor')->get();
        return view('client.homescreen.appointments', compact('appointments', 'patient'));
    }

    public function myhistory()
    {

        $patient = Auth::guard('patient')->user();
        $patientId = auth()->guard('patient')->user()->pid;
        $appointments = Appointment::where('pid', $patientId)
            ->whereIn('status', ['cancelled', 'finished', 'pending'])
            ->with('schedule.mydoctor')->get();
        return view('client.homescreen.history', compact('appointments', 'patient'));
    }


    public function myaccount()
    {

        $patient = Auth::guard('patient')->user();
        return view('client.homescreen.account', compact('patient'));
    }


    /*===========================
            Miscellaneous 
    =============================*/

    public function docinfo($docid)
    {
        $doctor = Doctor::with(['specialty', 'hasSchedule', 'reviews'])->findOrFail($docid);

        $average = $doctor->reviews->avg('rating');

        // Group schedules by date
        $schedulesByDate = $doctor->hasSchedule->groupBy(function ($item) {
            return Carbon::parse($item->scheduledate)->toDateString();
        });

        // Group schedules by month
        $schedulesByMonth = $doctor->hasSchedule->groupBy(function ($item) {
            return Carbon::parse($item->scheduledate)->format('F Y');
        });

        // Prepare schedule slots
        $scheduleSlots = $doctor->hasSchedule->map(function ($schedule) {

            $scheduleDate = Carbon::parse($schedule->scheduledate);
            $startTime = Carbon::parse($schedule->start_time);
            $endTime = Carbon::parse($schedule->end_time);

            // Session period
            $hour = $startTime->hour;
            if ($hour >= 5 && $hour < 12) {
                $session = 'Morning';
            } elseif ($hour >= 12 && $hour < 17) {
                $session = 'Afternoon';
            } else {
                $session = 'Evening';
            }

            // Booking status
            $bookedCount = Appointment::where('scheduleid', $schedule->scheduleid)
                ->whereIn('status', ['pending', 'confirmed', 'approved'])
                ->count();

            $isFullyBooked = $bookedCount >= $schedule->nop;
            $isDisabled = $scheduleDate->isToday() && $endTime->isPast();

            return [
                'id' => $schedule->scheduleid,
                'date' => $schedule->scheduledate,
                'month' => $scheduleDate->format('F Y'),
                'session' => $session,
                'start' => $startTime->format('h:i A'),
                'end' => $endTime->format('h:i A'),
                'raw_start' => $schedule->start_time,
                'raw_end' => $schedule->end_time,
                'booked' => $bookedCount,
                'capacity' => $schedule->nop,
                'available' => "{$bookedCount}/{$schedule->nop}",
                'isFullyBooked' => $isFullyBooked,
                'isDisabled' => $isDisabled,
            ];
        });

        return view('client.doctorinfo', compact(
            'doctor',
            'average',
            'schedulesByDate',
            'schedulesByMonth',
            'scheduleSlots'
        ));
    }
    public function doctorCategory()
    {
        $specialties = Specialties::all();
        return view('client.doctorcategory', compact('specialties'));
    }


    public function searchdoctor(Request $request)
    {

        $patient = Auth::guard('patient')->user();
        $query = Doctor::with('specialty');
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('specialty', function ($q) use ($search) {
                        $q->where('sname', 'like', "%{$search}%");
                    });
            });
        }
        $specialties = Specialties::all();
        $doctors = $query->get(); // or paginate()
        return view('client.homescreen.doctors', compact('doctors', 'patient', 'specialties'));
    }

    public function ajaxSearch(Request $request)
    {
        $search = $request->search;

        $doctors = Doctor::where('name', 'LIKE', "%$search%")
            ->orWhereHas('specialty', function ($query) use ($search) {
                $query->where('sname', 'LIKE', "%$search%");
            })
            ->get();

        return view('partials.doctor_results', compact('doctors'))->render();
    }

    public function appointmentdetail($id)
    {
        $appointment = Appointment::with('schedule.mydoctor')
            ->findOrFail($id);
        $patient = $appointment->schedule->mypatient ?? auth()->guard('patient')->user();
        return view('client.bookingscreen.appointmentdetail', compact('appointment', 'patient'));
    }

    public function cancelledAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->status === "pending") {
            $appointment->status = 'cancelled';
            $appointment->save();
        }
        return redirect('myhome')->with('success', 'Appointment cancelled successfully.');
    }

    public function destroyAppointment($appoid)
    {
        try {
            $appointment = Appointment::findOrFail($appoid);
            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Appointment deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete appointment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function myprofile()
    {
        $patient = Auth::guard('patient')->user();
        return view('client.myprofile', compact('patient'));
    }

    public function editProfile()
    {

        $patient = Auth::guard('patient')->user();
        return view('client.edit_profile', compact('patient'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'biography' => 'required',
            'gender' => 'required',
            'relationship' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $imageName = null;
        $patientId = Auth::guard('patient')->id();
        $patient = Patient::find($patientId);

        // If a file was uploaded, process it
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/patients'), $imageName);
            $patient->image = $imageName;
        }

        $patient->gender = $request->input('gender');
        $patient->relationship = $request->input('relationship');
        $patient->save();

        $bio = Bio::where('patient_id', $patientId)->first();
        if ($bio) {
            $bio->biography = $request->input('biography');
            $bio->save();
        } else {
            Bio::create([
                'patient_id' => $patientId,
                'biography' => $request->input('biography'),
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
