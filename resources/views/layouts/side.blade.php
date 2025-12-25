@php
$dash_pages = [
'dashboard' => ['label' => 'Dashboard', 'icon' => 'bx bx-grid-alt'],
'doctors.show' => ['label' => 'Doctors', 'icon' => 'bx bx-folder-plus'],
'patients.show' => ['label' => 'Patients', 'icon' => 'bx bx-group'],
'staffs.show' => ['label' => 'Staff', 'icon' => 'bx bx-user'],
'doctor_home' => ['label' => 'Dashboard', 'icon' => 'bx bx-grid-alt'],
'staff_home' => ['label' => 'Dashboard', 'icon' => 'bx bx-grid-alt'],
];

$edit_pages = [
'schedule.show' => ['label' => 'Schedules', 'icon' => 'bx bx-calendar'],
'appointments.show' => ['label' => 'Appointments', 'icon' => 'bx bx-bookmark'],
'specialty.show' => ['label' => 'Specialty', 'icon' => 'bx bx-glasses'],
'appointments.scan' => ['label' => 'Scan QR', 'icon' => 'bx bx-qr-scan'],
'appointments.create' => ['label' => 'New Appointment', 'icon' => 'bx bx-plus-circle'],
'appointment.list' => ['label' => 'Appointment List', 'icon' => 'bx bx-bookmark'],
'schedule.list' => ['label' => 'Schedule List', 'icon' => 'bx bx-calendar'],
];

$setting_pages = [
'settings' => ['label' => 'Settings', 'icon' => 'bx bx-cog'],
'personnel.changePassword' => ['label' => 'Change Password', 'icon' => 'bx bx-lock'],
];

/* Combine all route_labels so <title> works for every page */
    $all_pages = $dash_pages + $edit_pages + $setting_pages;
    $current = Route::currentRouteName();
    @endphp

    <html lang="en">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $all_pages[$current]['label'] ?? 'New Tab' }}</title>
    </head>

    <body>
        <div class="overlay" id="overlay"></div>
        <nav class="sidebar" id="sidebar">
            <div class="logo_items flex">
                <span class="nav_image">
                    <img src="{{ asset('assets/img/Logo.png') }}" alt="logo_img" />
                </span>
                <span class="logo_name">CampusDoctor</span>
            </div>

            <div class="menu_container">
                <!-- Dashboard Section -->
                <ul class="menu_items">
                    @foreach ($dash_pages as $route => $data)

                    @if (Auth::guard('staff')->check() && $route === 'staff_home')
                    <li class="item">
                        <a href="{{ route($route) }}" class="link flex {{ $current === $route ? 'active' : '' }}">
                            <i class="{{ $data['icon'] }}"></i>
                            <span>{{ $data['label'] }}</span>
                        </a>
                    </li>

                    @elseif (Auth::guard('doctor')->check() && $route === 'doctor_home')
                    <li class="item">
                        <a href="{{ route($route) }}" class="link flex {{ $current === $route ? 'active' : '' }}">
                            <i class="{{ $data['icon'] }}"></i>
                            <span>{{ $data['label'] }}</span>
                        </a>
                    </li>

                    @elseif (!Auth::guard('staff')->check() && !Auth::guard('doctor')->check() &&
                    in_array($route, ['dashboard','doctors.show','staffs.show','patients.show']))
                    <li class="item">
                        <a href="{{ route($route) }}" class="link flex {{ $current === $route ? 'active' : '' }}">
                            <i class="{{ $data['icon'] }}"></i>
                            <span>{{ $data['label'] }}</span>
                        </a>
                    </li>
                    @endif

                    @endforeach

                    <!-- Editor Section -->
                    <div class="menu_title flex">
                        <span class="title">Editor</span>
                        <span class="line"></span>
                    </div>

                    @foreach ($edit_pages as $route => $data)

                    {{-- Admin restriction --}}
                    @if (Auth::guard('admin')->check() && in_array($route, ['appointment.list','schedule.list', 'appointments.create']))
                    @continue
                    @endif

                    {{-- Doctors CANNOT see doctor-only blocked pages --}}
                    @if (Auth::guard('doctor')->check() && in_array($route, ['appointments.show', 'schedule.show', 'specialty.show' ]))
                    @continue
                    @endif

                    {{-- Staff restrictions --}}
                    @if (Auth::guard('staff')->check() && in_array($route, [
                    'appointments.show','schedule.show','appointment.list','schedule.list', 'specialty.show','appointments.create'
                    ]))
                    @continue
                    @endif

                    {{-- QR Scan only for staff --}}
                    @if ($route === 'appointments.scan' && !Auth::guard('staff')->check())
                    @continue
                    @endif

                    <li class="item">
                        <a href="{{ route($route) }}" class="link flex {{ $current === $route ? 'active' : '' }}">
                            <i class="{{ $data['icon'] }}"></i>
                            <span>{{ $data['label'] }}</span>
                        </a>
                    </li>

                    @endforeach

                    <!-- Settings Section -->
                    <div class="menu_title flex">
                        <span class="title">Setting</span>
                        <span class="line"></span>
                    </div>

                    @foreach ($setting_pages as $route => $data)

                    {{-- Doctors & staff cannot see settings --}}
                    @if ((Auth::guard('doctor')->check() || Auth::guard('staff')->check()) && $route === 'settings')
                    @continue
                    @endif

                    {{-- Admin  cannot see change password in the side bar but in the settings page --}}
                    @if ((Auth::guard('admin')->check()) && $route === 'personnel.changePassword')
                    @continue
                    @endif

                    <li class="item">
                        <a href="{{ route($route) }}" class="link flex {{ $current === $route ? 'active' : '' }}">
                            <i class="{{ $data['icon'] }}"></i>
                            <span>{{ $data['label'] }}</span>
                        </a>
                    </li>

                    @endforeach

                    <!-- Static Items -->
                    <li class="item" id="darkSwitch">
                        <div class="link flex">
                            <i class="bx bx-moon" id="theme-icon"></i>
                            <span id="theme-txt">Dark Mode</span>
                        </div>
                    </li>

                    <li class="item">
                        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Do you want to logout?')">
                            @csrf
                            <button class="link flex border-0 w-100" style="background: none;">
                                <i class="bx bx-log-out"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </nav>
    </body>

    </html>