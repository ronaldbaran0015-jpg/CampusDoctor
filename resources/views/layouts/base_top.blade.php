 <nav class="top-road">
     <div class="mobile-search p-2">
         <div class="field-2 field">
             <input type="text" class="searchInput" name="search" placeholder="Search something...." autocomplete="off">
             <i class="bx bx-search"></i>
         </div>
     </div>
     <div class="top-bar" id="top-bar">
         <button class="btn btn-outline-primary  m-3" id="toggleSidebar">
             <i class="fas fa-bars"></i>
         </button>
         <div class="top-logo_items flex">
             <span class="nav_image">
                 <!-- <img src="../assets/images/LS20250524121007.png" alt="logo_img" /> -->
             </span>
             <!-- <span class="logo_name">E-Resolve</span> -->
         </div>
         <form action="{{ route('doctor.searchdoctor') }}" method="GET" class="field">
             <input type="text" class="searchInput" name="search" placeholder="Search Doctor..." autocomplete="off">
             <i class="bx bx-search"></i>
         </form>

         <div class="profile-details d-flex align-items-center justify-content-end gap-3">
             <a href="{{route('message.show')}}" class="trail"> <i class='bx bx-envelope icon icon'></i>@if (!empty($message_count))<span>{{$message_count}}</span>@endif</a>
             @if (!$upcoming)
             <a href="{{route('notif.show')}}" class="trail"> <i class='bx bx-bell icon icon'></i></a>
             @else
             <a href="{{route('notif.show')}}" class="trail"> <i class='bx bx-bell icon icon'></i><span>{{$upcoming}}</span></a>

             @endif
             @if (!$patient->image)
             <img src="{{asset('assets/svg/man-svgrepo-com.svg')}}" class="avatar small-user-img toggler">
             @else
             <img src="{{ asset('uploads/patients/' . $patient->image) }}" class="avatar toggler" alt="">

             @endif

         </div>
     </div>
     <div class="profile-card">
         <header class="d-flex justify-content-start align-items-center gap-4 px-4">
             @if (!$patient->image)
             <img src="{{asset('assets/svg/man-svgrepo-com.svg')}}" class="small-user-img">
             @else
             <img src="{{ asset('uploads/patients/' . $patient->image) }}" class="avatar" alt="">

             @endif
             <div class="info">
                 <h5 id="name">{{$patient->name}}</h5>
                 <small id="email">{{$patient->email}}</small>
             </div>
         </header>
         <div class="mt-4 px-3 details">
             <div class="card inner rounded-0 p-3 ">
                 <p class="text">
                     {{$patient->bio->biography ?? 'I am a dedicated and passionate student developer with a strong interest in creating
                practical technology solutions that address real-world problems'}}
                 </p>
                 <a href="{{route('myprofile')}}" class="mt-3 fw-bold">View Profile</a>
             </div>
         </div>
         <div class="menu mt-3">
             <li><i class="fa fa-bolt"></i><a href="" class="ms-2">My Subscription</a></li>
             <li><i class="fa fa-credit-card"></i><a href="" class="ms-2">Gift Card</a></li>
             <li><i class="fa fa-sign-out"></i><a href="" class="ms-2">Logout</a></li>

         </div>
     </div>
 </nav>