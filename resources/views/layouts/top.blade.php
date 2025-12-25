<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/font/css/all.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/boxicons-master/css/boxicons.min.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/img/Logo.png')}}" type="image/x-icon">
    <style>
        .trail {
            position: relative;
            margin: 0;
            transform: translateY(5px);
        }

        .trail span {
            position: absolute;
            top: 0;
            display: grid;
            place-items: center;
            right: -10px;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            color: white;
            font-size: 10px;
            background: red;
        }

        .search-box {
            position: relative;
        }

        .search-results {
            position: absolute;
            z-index: 10;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            display: none;
        }

        .search-results ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .search-results li {
            padding: 5px;
            border-bottom: 1px solid #ccc;
        }

        .search-results li:last-child {
            border-bottom: none;
        }

        .search-results a {
            text-decoration: none;
            color: #337ab7;
        }

        .search-results a:hover {
            color: #23527c;
        }
    </style>
</head>

<body>
    <div class="mobile-search p-2">
        <div class="field-2 field">
            <input type="text" class="searchInput" name="search" placeholder="Search something...." autocomplete="off">
            <i class="bx bx-search"></i>
        </div>
    </div>
    <nav class="top-bar d-flex align-items-center justify-content-between">
        <button class="btn btn-outline-primary  m-3" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="top-logo_items flex">
            <span class="nav_image">
            </span>
        </div>
        <div class="field-1 field search-box">
            <input type="text" id="dashboardSearch" class="searchInput" name="search" placeholder="Search something..." autocomplete="off">
            <i class="bx bx-search"></i>
            <div class="search-results">
                <ul id="search-results-list"></ul>
            </div>
        </div>
        <div class="profile-details d-flex align-items-center justify-content-end gap-3">
            <a href="{{route('doctor.message.show')}}" class="trail"> <i class='bx bx-envelope icon icon'></i></a>
            <a href="#" class="trail"> <i class='bx bx-bell icon icon'></i></a>
            @if (Auth::guard('doctor')->check())
            @if (!optional($user_doctor)->image )
            <img class="toggler" src="{{asset('assets/svg/doctor-svgrepo-com.svg')}}">
            @else
            <img class="toggler" src="{{asset('uploads/doctors/'.optional($user_doctor)->image )}}">
            @endif
            @elseif (Auth::guard('staff')->check())
            @if (!optional($user_staff)->staffimage )
            <img src="{{asset('assets/svg/clerk-with-tie-svgrepo-com.svg')}}">
            @else
            <img class="toggler" src="{{asset('uploads/staffs/'.optional($user_staff)->staffimage )}}">
            @endif
            @else
            @if (!optional($user_admin)->adminimage)
            <img class="toggler" src="{{asset('assets/img/Jimmy_McGill_BCS_S3.png')}}">
            @else
            <img class="toggler" src="{{asset('uploads/admins/'.optional($user_admin)->adminimage )}}">
            @endif
            @endif

        </div>
    </nav>
    <section class="profile-card">
        <header class="d-flex justify-content-start align-items-center gap-4 px-4">
            @if (Auth::guard('doctor')->check())
            @if (!optional($user_doctor)->image )
            <img src="{{asset('assets/svg/doctor-svgrepo-com.svg')}}">
            @else
            <img src="{{asset('uploads/doctors/'.optional($user_doctor)->image )}}">
            @endif
            @elseif (Auth::guard('staff')->check())
            @if (!optional($user_staff)->staffimage )
            <img src="{{asset('assets/svg/clerk-with-tie-svgrepo-com.svg')}}">
            @else
            <img src="{{asset('uploads/staffs/'.optional($user_staff)->staffimage )}}">
            @endif
            @else
            @if (!optional($user_admin)->adminimage)
            <img src="{{asset('assets/img/Jimmy_McGill_BCS_S3.png')}}">
            @else
            <img src="{{asset('uploads/admins/'.optional($user_admin)->adminimage )}}">
            @endif
            @endif
            <div class="info">
                @if (Auth::guard('doctor')->check())
                <h5>{{ optional($user_doctor)->name }}</h5>
                @elseif (Auth::guard('staff')->check())
                <h5>{{ optional($user_staff)->staffname }}</h5>
                @else
                <h5>{{ optional($user_admin)->adminname }}</h5>
                @endif
                <a href="{{ route('profile.edit') }}" class="nav-link">View more</a>
            </div>
        </header>
        <div class="mt-4 px-3  details">
            <div class="border inner rounded-0 p-3">
                <b>Al Spell Check on par</b>
                <li>Al-powered one-stop office solutions</li>
                <li>Al-powered WPS Photos</li>
                <li>Unlimited Al Parallel Translate</li>
            </div>

        </div>
        <div class="menu mt-3">
            <li><i class="fa fa-bolt"></i><a href="" class="ms-2">My Subscription</a></li>
            <li><i class="fa fa-credit-card"></i><a href="" class="ms-2">Gift Card</a></li>
            <li><i class="fa fa-sign-out"></i><a href="" class="ms-2">Logout</a></li>

        </div>
    </section>
    <script src="{{asset('assets/js/profilecard.js')}}"></script>
    <script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
    <script>
        let timeoutId = null;

        const searchInput = document.getElementById('dashboardSearch');
        const searchBox = document.querySelector('.search-box');
        const resultsWrap = document.querySelector('.search-results');
        const resultsList = document.getElementById('search-results-list');

        $('#dashboardSearch').on('input', function() {
            clearTimeout(timeoutId);
            const query = $(this).val().trim();

            timeoutId = setTimeout(() => {
                if (!query) {
                    $('#search-results-list').empty().parent().hide();
                    return;
                }

                fetch(`/search/navigation?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(renderResults);
            }, 300);
        });

        function renderResults(items) {
            const list = $('#search-results-list');
            list.empty();

            if (items.length === 0) {
                list.append('<li class="text-muted px-2">No results</li>');
            } else {
                items.forEach(item => {
                    list.append(`<li><a href="${item.url}">${item.name}</a></li>`);
                });
            }

            list.parent().show();
        }

        $('.search-results').hide();

        // ------------------------
        // CLOSE HANDLERS
        // ------------------------
        function closeSearchResults() {
            resultsWrap.style.display = 'none';
            resultsList.innerHTML = '';
        }

        // ESC key → close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSearchResults();
                searchInput.blur();
            }
        });
    </script>




</body>

</html>