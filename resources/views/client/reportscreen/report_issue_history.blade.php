 @extends('layouts.include.dark')
 @section('title','Report History')
 @section('content')
 @include('layouts.base_side')

 <main class="main-content shadow-sm">
     <section class="container-content" id="report-issue-history-section">
         <div class="viewport p-3">
             <header class="header mb-3">
                 <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
                 <span class="mx-auto">Report History</span>
             </header>
             @forelse ($reports as $report )
             <a href="#" class=" menu-items border mt-2  p-3 d-flex justify-content-between align-items-center">
                 <i class="fa fa-warning fs-5"></i>
                 <label class="ms-3" style="flex-grow: 1;">{{$report->category}}</label>
                 <div class="px-1">
                     <i class=" fa fa-chevron-right"></i>
                 </div>
             </a>
             @empty
             <div class="text-center">
                 <img src="{{asset('assets/svg/undraw_empty_4zx0.svg')}}" width="50%" alt="">
                 <p class="text">Nothing to show</p>
                 <a href="{{route('report_issue')}}" class="btn btn-primary link">File Report</a>
             </div>
             @endforelse
             @if (session()->has('success'))
             <script>
                 window.onload = () => {
                     Swal.fire({
                         position: "top",
                         toast: true,
                         showConfirmButton: false,
                         timer: 2000,
                         timerProgressBar: true,
                         icon: "success",
                         title: "{{session()->get('success')}}"
                     });
                 }
             </script>
             @endif
             @if ($errors->any())
             <div class="text-center mt-5">
                 @foreach ($errors->all() as $error)
                 <p class="alert alert-danger">{{ $error }}</p>
                 @endforeach
             </div>
             @endif
         </div>
     </section>
 </main>
 @endsection