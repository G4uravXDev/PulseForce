<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PulseForce — Personnel Training Management System built on Laravel">
    <title>@yield('title', 'PulseForce — Personnel Training Management')</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Epilogue:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    @stack('styles')
</head>
<body>
    @include('partials.loader')
    @yield('content')
    @stack('scripts')
</body>
</html>
