 <div class="container py-3">
     <div class="modal fade" id="filterModal" tabindex="-1">
         <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered modal-dialog-scrollable">
             <div class="modal-content">

                 <div class="modal-header">
                     <h5 class="modal-title fw-bold">Filter Doctors</h5>
                     <button class="btn-close" data-bs-dismiss="modal"></button>
                 </div>

                 <div class="modal-body">

                     <!-- Specialty -->
                     <div class="mb-3">
                         <label class="fw-semibold mb-2">Specialty</label>
                         <div class="d-flex flex-wrap gap-2">
                             <input type="checkbox" class="btn-check" id="neurology">
                             <label class="btn btn-outline-primary btn-sm rounded-pill" for="neurology">Neurology</label>

                             <input type="checkbox" class="btn-check" id="cardiology">
                             <label class="btn btn-outline-primary btn-sm rounded-pill" for="cardiology">Cardiology</label>

                             <input type="checkbox" class="btn-check" id="pediatrics">
                             <label class="btn btn-outline-primary btn-sm rounded-pill" for="pediatrics">Pediatrics</label>

                             <input type="checkbox" class="btn-check" id="general">
                             <label class="btn btn-outline-primary btn-sm rounded-pill" for="general">General</label>
                         </div>
                     </div>

                     <!-- Availability -->
                     <div class="mb-3">
                         <label class="fw-semibold mb-2">Availability</label>
                         <select class="form-select">
                             <option>Any</option>
                             <option>Today</option>
                             <option>This Week</option>
                             <option>Morning</option>
                             <option>Afternoon</option>
                         </select>
                     </div>

                     <!-- Rating -->
                     <div class="mb-3">
                         <label class="fw-semibold mb-2">Rating</label>
                         <select class="form-select">
                             <option>Any</option>
                             <option>⭐ 4.5+</option>
                             <option>⭐ 4.0+</option>
                             <option>⭐ 3.5+</option>
                         </select>
                     </div>
                     <!-- Consultation -->
                     <div class="mb-3">
                         <label class="fw-semibold mb-2">Consultation Type</label>
                         <div class="d-flex gap-2">
                             <input type="radio" class="btn-check" name="consult" id="inperson">
                             <label class="btn btn-outline-primary btn-sm rounded-pill" for="inperson">In-person</label>

                             <input type="radio" class="btn-check" name="consult" id="video">
                             <label class="btn btn-outline-primary btn-sm rounded-pill" for="video">Video</label>

                             <input type="radio" class="btn-check" name="consult" id="chat">
                             <label class="btn btn-outline-primary btn-sm rounded-pill" for="chat">Chat</label>
                         </div>
                     </div>

                 </div>

                 <div class="modal-footer d-flex justify-content-between">
                     <button class="btn btn-outline-secondary w-50">Reset</button>
                     <button class="btn btn-primary w-50">Apply</button>
                 </div>

             </div>
         </div>
     </div>
 </div>