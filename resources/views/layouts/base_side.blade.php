 @php
 $dash_pages = [
 'myhome' => ['label' => 'Home', 'icon' => 'bx bx-home'],
 'mydoctor' => ['label' => 'Doctors', 'icon' => 'bx bx-user'],
 ];

 $edit_pages = [
 'myschedule' => ['label' => 'Appointments', 'icon' => 'bx bx-calendar'],
 'myhistory' => ['label' => 'History', 'icon' => 'bx bx-history'],
 ];
 $setting_pages = [
 'myaccount' => ['label' => 'Account', 'icon' => 'bx bx-grid-alt'],

 ];
 @endphp
 <nav class="sidebar" id="sidebar">
     <ul class="logo_items flex p-0">
         <span class="nav_image">
             <img src="{{ asset('assets/img/Logo.png') }}" alt="logo_img" />
         </span>
         <span class="logo_name">CampusDoctor</span>
     </ul>

     <ul class="menu_container p-0">
         <!-- Dashboard Section -->  
             @if (!Auth::guard('staff')->check())
             <div class="menu_title flex m-0">
                 <span class="title">Dashboard</span>
                 <span class="line"></span>
             </div>
             @foreach ($dash_pages as $route => $data)
             @if (Auth::guard('staff')->check() && in_array($route, ['dashboard','doctors','staffs', 'patients']))
             @continue
             @endif
             <li class="item">
                 <a href="{{ route($route) }}"
                     class="link flex {{ Route::currentRouteName() === $route ? 'active' : '' }}">
                     <i class="{{ $data['icon'] }}"></i>
                     <span>{{ $data['label'] }}</span>
                 </a>
             </li>
             @endforeach
             @endif
             <!-- Editor Section -->
             <div class="menu_title flex">
                 <span class="title">Schedule</span>
                 <span class="line"></span>
             </div>
             @foreach ($edit_pages as $route => $data)
             {{-- QR Scan visible only to Staff  --}}
             @if ($route === 'appointments.scan' && !Auth::guard('staff')->check())
             @continue
             @endif
             <li class="item">
                 <a href="{{ route($route) }}"
                     class="link 0 flex {{ Route::currentRouteName() === $route ? 'active' : '' }}">
                     <i class="{{ $data['icon'] }}"></i>
                     <span>{{ $data['label'] }}</span>
                 </a>
             </li>
             @endforeach
             <!-- Settings Section -->
             <div class="menu_title flex">
                 <span class="title">Account</span>
                 <span class="line"></span>
             </div>
             @foreach ($setting_pages as $route => $data)

             @if (Auth::guard('staff')->check() && $route === 'settings' )
             @continue
             @endif
             <li class="item">
                 <a href="{{ route($route) }}"
                     class="link flex {{ Route::currentRouteName() === $route ? 'active' : '' }}">
                     <i class="{{ $data['icon'] }}"></i>
                     <span>{{ $data['label'] }}</span>
                 </a>
             </li>
             @endforeach
     </ul>
 </nav>