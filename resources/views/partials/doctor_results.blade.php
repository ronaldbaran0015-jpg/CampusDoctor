 @forelse ($doctors as $doc)
 <div class="doc-card">
     <div class="doc-item">
         <div class="profile">
             @if (!$doc->image)
             <img src="{{ asset('assets/svg/doctor-svgrepo-com.svg') }}" class="doc-photo">
             @else
             <img src="{{ asset('uploads/doctors/' . $doc->image) }}" class="doc-photo">
             @endif
             @if ($doc->status =='active')
             <span class="doctor-status-badge active-badge"></span>
             @elseif($doc->status =='busy')
             <span class="doctor-status-badge busy-badge"></span>
             @elseif($doc->status =='offline')
             <span class="doctor-status-badge offline-badge"></span>
             @elseif($doc->status =='not available')
             <span class="doctor-status-badge not-available-badge"></span>
             @endif
         </div>
         <div class="doc-info">
             <h6>{{ $doc->name }}</h6>
             <small class="doctor-skill">{{ $doc->specialty->sname }}</small><br>
             <span class="rating"><i class="fa fa-star"></i> {{ number_format((float) ($doc->reviews_avg_rating ?? 0), 1) }} ({{ $doc->reviews_count ?? 0 }})</span>

         </div>
         <div class="text-center">
             @if ($doc->status =='active')
             <div class="status text-success">{{$doc->status}}</div>
             @elseif ($doc->status =='offline')
             <div class="status text-dark">{{$doc->status}}</div>
             @elseif ($doc->status =='busy')
             <div class="status text-warning">{{$doc->status}}</div>
             @elseif ($doc->status =='not available')
             <div class="status text-danger">{{$doc->status}}</div>
             @endif
             @if ($doc->status =='not available')
             <button class="btn btn-primary btn-sm" disabled>Book now</button>
             @else
             <a href="{{ route('docinfo', $doc->docid) }}" class="btn btn-primary btn-sm">Book now</a>
             @endif
         </div>
     </div>
 </div>
 @empty
 <div class="d-flex flex-column align-items-center justify-content-center text-center w-100" style="min-height: 50vh;">
     <img src="{{asset('assets/svg/undraw_empty_4zx0.svg')}}" width="200px" alt="Empty image">
     <p class="text mt-3">No doctors found matching your search.</p>
 </div>
 @endforelse
 <script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
 <script>
     $(document).ready(function() {

         $('#searchDoctor').on('keyup', function() {
             let query = $(this).val();

             $.ajax({
                 url: "{{ route('doctor.ajaxSearch') }}",
                 method: "GET",
                 data: {
                     search: query
                 },
                 success: function(data) {
                     $('#doctor-list').html(data);
                 }
             });
         });

     });
 </script>