<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    <link href="{{ asset('web/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    @stack('styles')
</head>
<body>
    <div id="app">


        <main >

            @include('components.app-layout.sidebar')
            <div class="main">
                    @include('components.app-layout.navbar', ['header' => $header??''])
                <div class="main-content">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
    <script>
       { let navigation = document.querySelector(".navigation");
        let main = document.querySelector(".main");

        if (localStorage.sidebar === 'ocultar') {
            navigation.classList.remove("active");
            main.classList.remove("active");

        } else {
            navigation.classList.add("active");
            main.classList.add("active");
        }}
    </script>
    @livewireScripts
    @include('sweetalert::alert')

    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <script type="module" src="{{ asset('web/js/select2.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
