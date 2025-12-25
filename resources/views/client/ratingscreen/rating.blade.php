@extends('layouts.include.dark')
@section('title','Rating')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/rating.css')}}">
<script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

@include('layouts.base_side')
<main class="main-content shadow-sm">
    <section class="container-content doctor-info-section">
        <div class="viewport p-3">
            <header class="header">
                <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
                <span class="mx-auto">Rating</span>
            </header>
            <form action="{{ route('review.store') }}" id="review-form" method="post">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->docid }}">
                <fieldset class="form-group py-3">

                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label for="star5">&#9733;</label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4">&#9733;</label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3">&#9733;</label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2">&#9733;</label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1">&#9733;</label>
                    </div>
                </fieldset>
                <!-- COMMENT INPUT BAR -->
                <fieldset class="comment-input">
                    <i class="fa fa-smile fs-4" id="emoji-picker-toggle"></i>
                    <input type="text" name="review" id="review" class="form-control" placeholder="Write a review">
                    <button type="submit" class="border-0 " style="background: none ;"><i class="fa fa-paper-plane fs-4 text-primary"></i></button>
                    <div id="emoji-picker" style="display: none; position: absolute; z-index: 1;"></div>
                </fieldset>
            </form>
            <h5 class="fw-bold mb-3 sub-heading">Comments</h5>
            @forelse($doctor->reviews as $review )
            <!-- COMMENT  -->
            <div class="comment-box border-bottom">
                <div class="comment-header">
                    <div class="d-flex align-items-center gap-2">
                        @if (!$review->patient->image)
                        <img src="{{asset('assets/svg/man-svgrepo-com.svg')}}" class="profile">

                        @else
                        <img src="{{asset('uploads/patients/'. $review->patient->image)}}" class="profile">

                        @endif
                        <div>
                            <div class="username">{{$review->patient->name}}</div>
                            <div class="date">{{$review->created_at->format('M d Y')}}</div>
                        </div>
                    </div>

                    <div class="like">
                        <!-- <i class="fa fa-thumbs-up"></i> 142 -->
                        <!-- ⭐ EDIT BUTTON (Only show to the owner of the review) -->
                        @if (Auth::guard('patient')->check() && Auth::guard('patient')->user()->pid == $review->patient_id)
                        <button type="button" class="btn btn-sm btn-link text-success p-0 edit-review-btn"
                            data-id="{{ $review->id }}"
                            data-rating="{{ $review->rating }}"
                            data-review="{{ $review->review }}">
                            <i class="fa fa-edit fs-5"></i>
                        </button>
                        <form id="deleteReviewForm" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-link text-danger p-0 delete-review-btn"
                                onclick="return confirm('Do you want to delete this review')"
                                data-id="{{ $review->id }}">
                                <i class="fa fa-trash fs-5"></i>
                            </button>

                        </form>
                        @endif
                    </div>
                </div>
                @for($i = 1; $i <=5; $i++)
                    @if ($i <=$review->rating)
                    <span class="text-warning">&#9733;</span>
                    @else
                    <span class="text-warning">&#9734;</span>
                    @endif
                    @endfor
                    <p class="mt-2 mb-2 text">{{$review->review}}</p>
                    <!-- <article class="reply-box">
                        wi***gmail.com: this have potential YEAH TOP COMMENT!!! (๑•̀ㅂ•́)و✧
                    </article> -->
            </div>
            @empty
            <div class="text-center">
                <img src="{{asset('assets/svg/undraw_empty_4zx0.svg')}}" width="50%" alt="">
                <p class="text">Nothing to show</p>
            </div>

            @endforelse
            <br><br>
            <div id="editReviewModal" class="edit-modal">
                <div class="edit-modal-content">
                    <h4>Edit Review</h4>
                    <form id="editReviewForm" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editReviewId">

                        <label class="mt-2 fw-bold">Rating</label>
                        <div class="rating mt-1">
                            <input type="radio" id="editStar5" name="rating" value="5" />
                            <label for="editStar5">&#9733;</label>

                            <input type="radio" id="editStar4" name="rating" value="4" />
                            <label for="editStar4">&#9733;</label>

                            <input type="radio" id="editStar3" name="rating" value="3" />
                            <label for="editStar3">&#9733;</label>

                            <input type="radio" id="editStar2" name="rating" value="2" />
                            <label for="editStar2">&#9733;</label>

                            <input type="radio" id="editStar1" name="rating" value="1" />
                            <label for="editStar1">&#9733;</label>
                        </div>

                        <label class="mt-3 fw-bold">Review</label>
                        <textarea id="editReviewText" name="review" class="form-control" rows="3"></textarea>

                        <button class="btn btn-success w-100 mt-3">Update Review</button>
                    </form>

                    <button class="close-edit-modal">&times;</button>
                </div>
            </div>

        </div>
    </section>
</main>
<script>
    const form = document.getElementById('review-form');
    const ratinginputs = document.querySelectorAll('input[name="rating"]');

    form.addEventListener('submit', (e) => {
        let ratingSelected = false;
        ratinginputs.forEach((input) => {
            if (input.checked) {
                ratingSelected = true;
            }
        });

        if (!ratingSelected) {
            e.preventDefault();
            Swal.fire({
                position: "top",
                toast: true,
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                icon: "warning",
                title: "Please select a star rating"
            });
            return;
        }
    });
</script>

<script>
    document.querySelectorAll('.edit-review-btn').forEach(btn => {
        btn.addEventListener('click', function() {

            const id = this.dataset.id;
            const rating = this.dataset.rating;
            const review = this.dataset.review;

            // Set values in modal
            document.getElementById('editReviewId').value = id;
            document.getElementById('editReviewText').value = review;

            // Select correct star
            const star = document.querySelector(`#editStar${rating}`);
            if (star) star.checked = true;

            // Set form action
            document.getElementById('editReviewForm').action = `/review/update/${id}`;

            // Show modal
            document.getElementById('editReviewModal').style.display = 'flex';
        });
    });
    document.querySelectorAll('.delete-review-btn').forEach(btn => {
        btn.addEventListener('click', function() {

            const id = this.dataset.id;
            // Set form action
            document.getElementById('deleteReviewForm').action = `/review/delete/${id}`;

        });
    });
    // Close modal
    document.querySelector('.close-edit-modal').addEventListener('click', () => {
        document.getElementById('editReviewModal').style.display = 'none';
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

<script>
    const picker = new EmojiMart.Picker({
        theme: "light",
        skinTonePosition: "none",
        previewPosition: "none",
        onEmojiSelect: (emoji) => {
            const messageInput = document.getElementById('review');
            const {
                selectionStart: start,
                selectionEnd: end
            } = messageInput;
            messageInput.setRangeText(emoji.native, start, end, "end");
            messageInput.focus();
        },
    });

    document.getElementById('emoji-picker-toggle').addEventListener('click', () => {
        const emojiPicker = document.getElementById('emoji-picker');
        if (emojiPicker.style.display === 'none') {
            emojiPicker.style.display = 'block';
            emojiPicker.appendChild(picker);
        } else {
            emojiPicker.style.display = 'none';
        }
    });

    document.addEventListener('click', (e) => {
        const emojiPicker = document.getElementById('emoji-picker');
        if (e.target.id !== 'emoji-picker-toggle' && e.target.id !== 'emoji-picker') {
            emojiPicker.style.display = 'none';
        }
    });
</script>

@endsection