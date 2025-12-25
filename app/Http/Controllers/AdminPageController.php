<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Bio;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialties;
use App\Models\ProblemReport;
use App\Models\Schedule;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class AdminPageController extends BaseController
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
    public function showLogin()
    {
        return view('auth.admin_login');
    }
    public function login(Request $request)
    {
        // validate input
        $credentials = $request->validate([
            'adminusername' => ['required'],
            'adminpassword' => ['required'],
        ]);
        if (Auth::guard('admin')->attempt(
            ['adminusername' => $credentials['adminusername'], 'password' => $credentials['adminpassword']]
        )) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'adminusername' => 'Invalid credentials.',
        ]);
    }

    public function showSignup()
    {
        return view('admin.signup');
    }

    public function signup(Request $request)
    {
        // Validate input
        $request->validate([
            'adminname' => ['required'],
            'adminusername' => ['required'],
            'admincontact' => ['required'],
            'adminpassword' => ['required', 'confirmed'],
            'adminpassword_confirmation' => ['required'],
            'adminimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);

        $imageName = null;

        // If a file was uploaded, process it
        if ($request->hasFile('adminimage') && $request->file('adminimage')->isValid()) {
            $imageName = time() . '.' . $request->adminimage->extension();
            $request->adminimage->move(public_path('uploads/admin'), $imageName);
        }

        // Create new patient
        $admin = Admin::create([
            'adminname' => $request->input('adminname'),
            'adminusername' => $request->input('adminusername'),
            'admincontact' => $request->input('admincontact'),
            'adminpassword' => Hash::make($request->input('adminpassword')),
            'adminimage' => $imageName, // Store the filename in DB
        ]);

        // Log the patient in
        Auth::guard('admin')->login($admin);
        // Redirect to the patient's home page
        return redirect('/dashboard');
    }

    public function getStats()
    {
        return response()->json([
            'doctorCount'   => Doctor::count(),
            'patientCount'  => Patient::count(),
            'staffCount' => Staff::count(),
            'appointmentCount' => Appointment::count(),
            'reportCount' => ProblemReport::count(),
        ]);
    }


    public function chartData(Request $request)
    {
        // selected year for monthly chart (default: current year)
        $year = (int) $request->query('year', now()->year);

        // --- YEARLY (group by year using date) ---
        $yearly = Appointment::selectRaw('YEAR(appodate) as year, COUNT(*) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // --- MONTHLY: ensure we always return Jan..Dec order for the requested year ---
        $months = collect([
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ]);
        $monthlyRaw = Appointment::selectRaw('MONTH(appodate) as month_number, MONTHNAME(appodate) as month_name, COUNT(*) as total')
            ->whereYear('appodate', $year)
            ->groupBy('month_number', 'month_name')
            ->get()
            ->keyBy('month_number'); // key by 1..12
        $monthlyLabels = $months; // full names
        $monthlyData = $months->map(function ($m, $index) use ($monthlyRaw) {
            $monthNum = $index + 1; // 1..12
            return (int) ($monthlyRaw->has($monthNum) ? $monthlyRaw->get($monthNum)->total : 0);
        });

        // --- DAILY (for the current month by default) ---
        // Use the selected year and current month (you can change policy to always show current month)
        $currentMonth = now()->month;
        $dailyRaw = Appointment::selectRaw('DATE(appodate) as date, COUNT(*) as total')
            ->whereYear('appodate', $year)
            ->whereMonth('appodate', $currentMonth)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy(function ($row) {
                return Carbon::parse($row->date)->format('M d');
            });

        // Prepare daily labels for the current month: generate labels for each day (1..lastDay)
        $daysInMonth = Carbon::create($year, $currentMonth, 1)->daysInMonth;
        $dailyLabels = collect(range(1, $daysInMonth))->map(fn($d) => Carbon::create($year, $currentMonth, $d)->format('M d'));
        $dailyData = $dailyLabels->map(fn($label) => (int) ($dailyRaw->has($label) ? $dailyRaw->get($label)->total : 0));

        // Build response
        return response()->json([
            'daily' => [
                'labels' => $dailyLabels->values()->all(),
                'data' => $dailyData->values()->all(),
            ],
            'monthly' => [
                'labels' => $monthlyLabels->values()->all(),
                'data' => $monthlyData->values()->all(),
            ],
            'yearly' => [
                'labels' => $yearly->pluck('year')->all(),
                'data' => $yearly->pluck('total')->all(),
            ],
        ]);
    }
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        $doctorCount = Doctor::count();
        $patientCount = Patient::count();
        $staffCount = Staff::count();
        $appointmentCount = Appointment::count();
        $appointments = Appointment::where('status', 'finished')->get();
        $reportCount = ProblemReport::count();
        return view('admin.dashboard', compact('admin', 'patientCount', 'doctorCount', 'staffCount', 'appointmentCount', 'appointments', 'reportCount'));
    }
    public function showDoctors()
    {

        $doctorCount = Doctor::count();
        $doctors = Doctor::all();
        $special = Specialties::all();
        return view('admin.doctors', compact('doctorCount', 'doctors', 'special'));
    }

    public function addDoctor(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:doctors'],
            'contact' => ['required'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'specialties' => 'required',
            'bio' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/doctors'), $imageName);
        }
        // Create new doctor
        Doctor::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'password' => Hash::make($request->input('password')),
            'specialties' => $request->input('specialties'),
            'bio' => $request->input('bio'),
            'image' => $imageName, // save filename in DB
        ]);

        return redirect()->route('doctors.show')->with('success', 'Doctor added successfully!');
    }

    //Show doc info
    public function doctor_info($docid)
    {

        $doctor_info = Doctor::with('specialty')->find($docid);

        $appointments = Appointment::WhereHas(
            'schedule',
            function ($query) use ($doctor_info) {
                $query->where('docid', $doctor_info->docid);
            }
        )->with('schedule', 'patient')
            ->where('status', 'pending')
            ->get();

        return view('admin.doctor_info', compact('doctor_info', 'appointments'));
    }

    // Controller
    public function show_edit_form($docid)
    {
        $doctor_info = Doctor::with('specialty')->find($docid);
        $specialties = Specialties::all();

        return view('admin.doctor_edit', compact('doctor_info', 'specialties'));
    }

    public function update_doctor(Request $request, $docid)
    {
        $request->validate([
            'name'    => ['required'],
            'email'   => ['required', 'email', 'unique:doctors,email,' . $docid . ',docid'],
            'contact' => ['required'],
            'specialties' => ['required'],
            'biography'  => ['required'],
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $doctor = Doctor::findOrFail($docid);


        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/doctors'), $imageName);
            $doctor->image = $imageName;
        }

        // Update other fields
        $doctor->name    = $request->input('name');
        $doctor->email   = $request->input('email');
        $doctor->contact = $request->input('contact');
        $doctor->specialties = $request->input('specialties');
        $doctor->save();

        $bio = Bio::where('doctor_id', $docid)->first();

        if ($bio) {
            $bio->biography = $request->input('biography');
            $bio->save();
        } else {
            Bio::create([
                'doctor_id' => $doctor->docid,
                'biography' => $request->input('biography'),
            ]);
        }
        return redirect()->route('doctors.show')->with('success', 'Profile updated successfully');
    }

    public function delete_doctor($docid)
    {

        $doctor =  Doctor::findOrFail($docid);
        $doctor->delete();

        return redirect()->back()->with('success', 'Doctor deleted successfully');
    }
    public function showStaff()
    {
        $staffs = Staff::all();
        $staffCount = Staff::count();
        return view('admin.staffs', compact('staffs', 'staffCount'));
    }

    public function addstaff(Request $request)
    {
        // Validate input
        $request->validate([
            'staffname' => ['required'],
            'staffemail' => ['required', 'email', 'unique:staff'],
            'staffcontact' => ['required'],
            'staffpassword' => ['required', 'confirmed'],
            'staffpassword_confirmation' => ['required'],
            'staffrole' => 'required',
            'staffimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'

        ]);

        $imageName = null;
        // If a file was uploaded, process it
        if ($request->hasFile('staffimage') && $request->file('staffimage')->isValid()) {
            $imageName = time() . '.' . $request->staffimage->extension();
            $request->staffimage->move(public_path('uploads/staff'), $imageName);
        }

        // Create new staff
        Staff::create([
            'staffname' => $request->input('staffname'),
            'staffemail' => $request->input('staffemail'),
            'staffcontact' => $request->input('staffcontact'),
            'staffpassword' => Hash::make($request->input('staffpassword')),
            'staffrole' => $request->input('staffrole'),
            'staffimage' => $imageName
        ]);

        // Redirect after signup
        return redirect()->route('staffs.show');
    }

    public function staff_edit_form($staffid)
    {
        $staff = Staff::find($staffid);
        return view('admin.staff_edit', compact('staff'));
    }

    public function staff_update(Request $request, $staffid)
    {
        $request->validate([
            'staffname'    => ['required'],
            'staffemail'   => ['required', 'email', 'unique:staff,staffemail,' . $staffid . ',staffid'],
            'staffcontact' => ['required'],
            'staffimage'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $staff = Staff::findOrFail($staffid);

        // Handle image upload
        if ($request->hasFile('staffimage') && $request->file('staffimage')->isValid()) {
            $imageName = time() . '.' . $request->staffimage->extension();
            $request->staffimage->move(public_path('uploads/staff'), $imageName);
            $staff->staffimage = $imageName;
        }
        // Update other fields
        $staff->staffname    = $request->input('staffname');
        $staff->staffemail   = $request->input('staffemail');
        $staff->staffcontact = $request->input('staffcontact');
        $staff->save();

        return redirect()->route('staffs.show')->with('success', 'Profile updated successfully');
    }

    public function staff_delete($staffid)
    {
        $staff = Staff::findOrFail($staffid);
        $staff->delete();
        return redirect()->back()->with('success', 'Staff has been deleted successfully');
    }


    public function showPatients()
    {
        $patients = Patient::all();
        $patientCount = Patient::count();
        return view('admin.patients', compact('patients', 'patientCount'));
    }


    public function patient_info($pid)
    {
        $patient = Patient::find($pid);
        return view('admin.patient_info', compact('patient'));
    }

    public function patient_edit($pid)
    {
        $patient = Patient::find($pid);
        return view('admin.patient_edit', compact('patient'));
    }

    public function patient_update(Request $request, $pid)
    {
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:patients,email,' . $pid . ',pid',
            'contact' => 'required|unique:patients,contact,' . $pid . ',pid',
            'address' => 'required',
            'dob' => 'required|date',
            'biography' => 'required',
        ]);

        $patient = Patient::findOrFail($pid);
        $patient->name = $request->input('name');
        $patient->gender = $request->input('gender');
        $patient->email = $request->input('email');
        $patient->contact = $request->input('contact');
        $patient->address = $request->input('address');
        $patient->dob = $request->input('dob');

        $patient->save(); // You can use save() instead of update() here

        $bio = Bio::where('patient_id', $pid)->first();

        if ($bio) {
            $bio->biography = $request->input('biography');
            $bio->save();
        } else {
            Bio::create([
                'patient_id' => $patient->pid,
                'biography' => $request->input('biography'),
            ]);
        }

        return redirect()->route('patients.show')->with('success', 'Profile updated successfully');
    }

    public function patient_delete($pid)
    {
        $patient = Patient::findOrFail($pid);
        $patient->delete();
        return redirect()->back()->with('success', 'Patient has been deleted successfully');
    }



    public function showSchedule()
    {

        $doctors = Doctor::all();
        abort_if(!$doctors, 404);
        return view('admin.schedule', compact('doctors'));
    }

    public function showAppointments()
    {
        $appointments = Appointment::all();
        return view('admin.appointments', compact('appointments'));
    }

    public function showSettings()
    {
        $this->checkAuthorizedPersonnel();
        return view('admin.settings');
    }



    public function showUserIssue()
    {
        $issues = ProblemReport::all();
        return view('admin.user_issue', compact('issues'));
    }

    public function showSpecialty()
    {
        $specialties = Specialties::all();
        return view('admin.specialty', ['specialties' => $specialties]);
    }
    public function addSpecialty(Request $request)
    {

        $request->validate(
            [
                'sname' => ['required'],
                'icon' => ['required'],
            ]
        );

        Specialties::create([
            'sname' => $request->input('sname'),
            'icon' => $request->input('icon'),

        ]);

        return redirect()->back()->with('success', 'Successfully added');
    }
    public function editSpecialty($id)
    {


        $specialty = Specialties::find($id);

        return view('admin.specialty_edit', ['specialty' => $specialty]);
    }

    public function updateSpecialty(Request $request, $id)
    {
        $specialty = Specialties::find($id);
        $specialty->sname = $request->input('sname');
        $specialty->icon = $request->input('icon');
        $specialty->save();

        return redirect()->route('specialty.show')->with('success', 'Updated Successfully ');
    }
    public function deleteSpecialty($id)
    {
        $specialty = Specialties::find($id);
        $specialty->delete();
        return redirect()->route('specialty.show')->with('success', 'Deleted Successfully ');
    }


    public function manageAccount(){
        $doctorCount = Doctor::count();
        $staffCount = Staff::count();
        $patientCount = Patient::count();

        $doctors = Doctor::with('specialty')->get();
        $staffs = Staff::all();
        $patients = Patient::all();
        $special = Specialties::all();

        return view('admin.accounts', compact(
            'doctorCount',
            'staffCount',
            'patientCount',
            'doctors',
            'staffs',
            'patients',
            'special'
        ));
    }

    public function updateAccountStatus(Request $request)
    {
        $request->validate([
            'user_type' => ['required', 'in:patient,doctor,staff'],
            'user_id' => ['required', 'integer'],
            'opt' => ['required', 'in:toggle,delete'],
        ]);

        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            abort(403);
        }

        if ($request->user_type === 'patient') {
            $user = Patient::findOrFail($request->user_id);
        } elseif ($request->user_type === 'doctor') {
            $user = Doctor::findOrFail($request->user_id);
        } else {
            $user = Staff::findOrFail($request->user_id);
        }

        if ($request->opt === 'toggle') {
            if (!array_key_exists('status', $user->getAttributes())) {
                return back()->withErrors(['opt' => 'Activation/deactivation is not available for this account type.']);
            }

            $user->status = ($user->status === 'deactivated') ? 'active' : 'deactivated';
            $user->save();

            return redirect()->back()->with('success', 'Account status updated successfully');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Account deleted successfully');
    }
}
