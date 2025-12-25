<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('assets/css/calendar.css')}}" />
</head>
<body>
    <section class="date"
        id="calendar"
        data-available-dates='{{ json_encode($schedulesByDate->keys()->values()) }}'>
        <aside class="wrapper">
            <header>
                <p class="current-date"></p>
                <div class="icons">
                    <i id="prev" class="fa fa-arrow-left"></i>
                    <i id="next" class="fa fa-arrow-right"></i>
                </div>
            </header>
            <div class="calendar">
                <ul class="weeks">
                    <li>Sun</li>
                    <li>Mon</li>
                    <li>Tue</li>
                    <li>Wed</li>
                    <li>Thu</li>
                    <li>Fri</li>
                    <li>Sat</li>
                </ul>
                <ul class="days"></ul>
            </div>
        </aside>
    </section>
    
    <script src="{{asset('assets/js/calendar.js')}}"></script>
</body>
</html>