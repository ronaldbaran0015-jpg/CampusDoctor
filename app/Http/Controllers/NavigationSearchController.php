<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavigationSearchController extends Controller
{
    public function search(Request $request)
    {
        $q = strtolower($request->query('q', ''));

        if (!$q) {
            return response()->json([]);
        }

        // 🔐 Detect who is logged in
        $role = match (true) {
            Auth::guard('admin')->check()  => 'admin',
            Auth::guard('doctor')->check() => 'doctor',
            Auth::guard('staff')->check()  => 'staff',
            default => null,
        };

        if (!$role) {
            return response()->json([]);
        }

        /**
         * THIS is your JS object converted to backend rules
         * Comments -> guards
         */
        $navigationItems = [
            // For Admin
            ['name' => 'Dashboard', 'url' => '/dashboard', 'roles' => ['admin']],
            ['name' => 'Doctors', 'url' => '/doctors', 'roles' => ['admin']],
            ['name' => 'Patients', 'url' => '/patients', 'roles' => ['admin']],
            ['name' => 'Staffs', 'url' => '/staffs', 'roles' => ['admin']],
            ['name' => 'Schedule', 'url' => '/showSchedule', 'roles' => ['admin']],
            ['name' => 'Appointments', 'url' => '/appointments', 'roles' => ['admin']],
            ['name' => 'Specialty', 'url' => '/specialty', 'roles' => ['admin']],
            ['name' => 'Settings', 'url' => '/settings', 'roles' => ['admin']],
            ['name' => 'Reported Issues', 'url' => '/user_issue', 'roles' => ['admin']],
            ['name' => 'User Accounts ', 'url' => '/accounts/manage', 'roles' => ['admin']],

            // For Doctor
            ['name' => 'New Appointment', 'url' => '/doctor/appointment/create/', 'roles' => ['doctor']],
            ['name' => 'Appointment list', 'url' => '/doctor/appointment/list', 'roles' => ['doctor']],
            ['name' => 'Schedule List', 'url' => '/doctor/schedule/list', 'roles' => ['doctor']],
            ['name' => 'Messages', 'url' => '/doctor/messages', 'roles' => ['doctor']],

            // For All
            ['name' => 'Change Password', 'url' => '/changePersonnelPassword', 'roles' => ['admin', 'doctor', 'staff']],
            ['name' => 'Profile', 'url' => '/profile', 'roles' => ['admin', 'doctor', 'staff']],
        ];

        // 🔍 Filter by ROLE + SEARCH TERM
        $results = collect($navigationItems)
            ->filter(
                fn($item) =>
                in_array($role, $item['roles']) &&
                    str_contains(strtolower($item['name']), $q)
            )
            ->values();

        return response()->json($results);
    }
}
