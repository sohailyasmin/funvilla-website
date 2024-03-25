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
        }
    </style>
</head>

<body>
    <div class="smooth-scroll">
        @include('website.partials.navbar')
        <div id="app" class="section-wrapper" data-scroll-section>

            {{ $slot }}

            @include('website.partials.footer')
        </div>
        @vite(['resources/js/app.js'])
    </div>
</body>

</html>