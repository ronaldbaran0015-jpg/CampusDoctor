@php
$left_pages = [
'myhome' => ['label' => 'Home', 'icon' => 'bx bx-home'],
'mydoctor' => ['label' => 'Doctors', 'icon' => 'bx bx-user'],

];

$center_pages = [
'myschedule' => ['label' => '', 'icon' => 'bx bx-calendar'],
];
$right_pages = [
'myhistory' => ['label' => 'History', 'icon' => 'bx bx-history'],
'myaccount' => ['label' => 'Account', 'icon' => 'bx bx-grid-alt'],

];



@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            /* Dark-Mode Colors */
            --txt-color: #343541;
            --icon-color: #343434;
            --icon-hover-bg: #f1f1f3;
            --placeholder-color: #6c6c6c;
            --outgoing-bg: #FFFFFF;
            --incoming-bg: #F7F7F8;
            --outgoing-border: #ccc;
            --incoming-border: #D9D9E3;
        }

        /* Lignt-Mode Colors */
        .light-mode {
            --txt-color: #FFF;

            --icon-color: #fff;

            --icon-hover-bg: #5b5e71;

            --placeholder-color: #dcdcdc;

            --outgoing-bg: #343541;

            --incoming-bg: #2c2c2c;

            --outgoing-border: #fff;

            --incoming-border: #444654;
        }


        @media(max-width:768px) {

            .bottom-nav {
                position: fixed;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 100%;
                display: flex;
                background: var(--outgoing-bg);

                border-top: 1px solid #ddd;
                justify-content: space-around;
                align-items: center
            }
        }
    </style>
</head>

<body>
    <div class="bottom">
        <div class="bottom-nav py-2">
            @foreach($left_pages as $route => $data)
            <a href="{{ route($route) }}" class="{{ Route::currentRouteName() === $route ? 'active' : '' }}"><i class="{{ $data['icon'] }}"></i><br>{{ $data['label'] }}</a>
            @endforeach

            @foreach($center_pages as $route => $data)
            <a href="{{ route($route) }}" style="transform: translateY(-20px)" class="middle {{ Route::currentRouteName() === $route ? '' : '' }}"><i class="bx bx-calendar"></i></a>
            @endforeach
            @foreach($right_pages as $route => $data)
            <a href="{{ route($route) }}" class="{{ Route::currentRouteName() === $route ? 'active' : '' }}"><i class="{{ $data['icon'] }}"></i><br>{{ $data['label'] }}</a>
            @endforeach
        </div>
    </div>
    <button id="theme-btn" class="extend" style="display: none;"></button>
</body>

</html>