 <aside class="col appointment-table">
     <h5 class="heading mt-3"> Upcoming Appointments</h5>

     <div class="dashboard-table-container" style="background-color: var(--outgoing-bg); color:var(--txt-color);">
         <div class="dashboard-table-header">
             <h3 class="dashboard-table-title" style="color:var(--txt-color);">Appointment table</h3>
             <a href="#" class="btn btn-secondary">View All</a>
         </div>
         <div class="table-responsive">

             <table id="usersTable" class="dashboard-table table align-middle table-hover border">
                 <thead>
                     <tr>
                         <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Patient</th>
                         <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Session Title</th>
                         <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Date</th>
                         <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Time</th>
                         <th style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">Actions</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($appointments as $appointment)
                     <tr class="text-start">
                         <td style="background-color: var(--outgoing-bg); color:var(--txt-color);">
                             <div class="table-title-cell">
                                 <div class="table-icon">
                                     <span class="material-symbols-rounded">{{ $loop->iteration }}</span>
                                 </div>

                                 <div class="table-info">
                                     <div class="table-title-text">{{ $appointment->patient->name }}</div>

                                 </div>
                             </div>
                         </td>
                         <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge success">{{$appointment->schedule->title}}</span></td>
                         <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center"><span class="status-badge primary">{{ \Carbon\Carbon::parse($appointment->appodate)->format('F d, Y')}}</span></td>
                         <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                             <span class="status-badge warning">
                                 {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                                 -
                                 {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                             </span>
                         </td>
                            
                         <td style="background-color: var(--outgoing-bg); color:var(--txt-color);" class="text-center">
                             <a href="{{route('chat.doctor', $appointment->pid)}}" class="trailing">
                                 <i class="fa fa-message icon bg-primary border-0 text-light p-3" style="border-radius: 50%;"></i>
                             </a>                                        
                         </td>

                     </tr>

                     @endforeach
                 </tbody>
             </table>
         </div>
     </div>
 </aside>