<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title & Favicon -->
    <title>{{ config('app.name', 'E-Learning Sanepa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sanepa.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Scripts & Styles (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-indigo-50 via-white to-indigo-50">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        {{-- Logo (opsional / hidden) --}}
        {{--
        <div class="mb-6">
            <a href="/">
                <x-application-logo class="w-24 h-24 fill-current text-indigo-500" />
            </a>
        </div>
        --}}

        {{-- Card Form --}}
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl rounded-2xl">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <p class="mt-6 text-sm text-gray-500 text-center">
            &copy; {{ date('Y') }} <strong>{{ config('app.name') }}</strong>. Hak cipta dilindungi.
        </p>

    </div>

</body>

</html>