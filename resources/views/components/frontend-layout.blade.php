<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nanglo Pasal</title>
    <!-- Tailwind CSS CDN -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">

</head>

<body class="antialiased">
    @include('sweetalert::alert')
    <x-frontend-header />
    <main>
        {{ $slot }}
    </main>
    <x-frontend-footer />

</body>

</html>
