<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'dashcode') }}</title>
    <x-favicon />
    {{-- Scripts --}}
    @vite(['resources/css/app.scss', 'resources/js/custom/store.js'])

    {{--
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> --}}
    <style>
        .search-block {
            background: #FFFFFF;
            border: 1px solid #FAFAFA;
            box-shadow: 0px 12px 90px rgba(12, 12, 12, 0.06);
            border-radius: 9px;
            left: 0;
            right: 0;
            z-index: 999;
        }
    </style>

    @if(request()->input('theme') == 'white')

    <style>
        .navbar-main {
            background: #fff !important;
        }

        .navbar-main .site-menu ul li a {

            color: #333;

        }

        .navbar-main .navbar-button a {
            color: #333;
        }

        .page-header:before {

            background-color: #e08800 !important;

        }

        .page-header {
            background: url('/images/5520432.jpg');
            background-size: cover !important;
            height: 440px;
        }
    </style>
    @elseif(request()->input('theme') == 'orange')

    <style>
        .navbar-main {
            /* background: #ff9b00 !important; */
            background: linear-gradient(90deg, hsla(36, 100%, 50%, 1) 16%, hsla(0, 0%, 9%, 1) 94%);
        }

        .footer {
            /* background: #ff9b00 !important; */
            background: linear-gradient(90deg, hsla(36, 100%, 50%, 1) 16%, hsla(0, 0%, 9%, 1) 94%);
        }

        .navbar-main .site-menu ul li a {

            color: #fff;

        }

        .navbar-main .navbar-button a {
            color: #fff;
        }

        .page-header:before {

            background-color: #ff9b00 !important;
            background: linear-gradient(90deg, hsla(36, 100%, 50%, 1) 16%, hsla(0, 0%, 9%, 1) 94%);

        }

        .page-header {
            /* background: url('/images/8230799.jpg');
            background-size: cover !important;
            height: 440px; */
        }
    </style>

    @else

    <style>
        .page-header {
            background: url('/images/page-header-bg.png')
        }
    </style>

    @endif
</head>

<body>

    <div class="smooth-scroll">

        @php
        $userRoutes = ['dashboard.index', 'my-profile.index', 'customers.index'];
        $currentRoute = \Route::currentRouteName();
        @endphp

        @if(in_array($currentRoute, $userRoutes))
        @include('website.partials.navbar-user')
        @else
        @include('website.partials.navbar')
        @endif
        <div id="app" class="section-wrapper" data-scroll-section>

            {{ $slot }}

            @if(in_array($currentRoute, $userRoutes))
            @include('website.partials.footer-user')
            @else
            @include('website.partials.footer')
            @endif
        </div>
        @vite(['resources/js/app.js'])
    </div>
    <script>
        document.addEventListener("scroll", function () {
  var el = document.querySelector('.fixed-top');
  var isPositionFixed = window.getComputedStyle(el).position === 'fixed';
  var scrollY = window.scrollY;

  if (scrollY > 200 && !isPositionFixed) {
    el.style.position = 'fixed';
    el.style.top = '0px';
    el.classList.add('navbar-main-scroll');
  } else if (scrollY <= 200 && isPositionFixed) {
    el.style.position = 'static';
    el.style.top = '0px';
    el.classList.remove('navbar-main-scroll');
  }
});


    </script>
</body>

</html>