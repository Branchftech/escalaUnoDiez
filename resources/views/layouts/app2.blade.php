<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"></noscript>

    <!-- Estilos principales -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    <link href="{{ asset('web/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    @stack('styles')
    <!-- Estilos iniciales para ocultar el contenido del dashboard -->
    <style>
        /* Oculta el contenido mientras carga */
        #app {
            display: none;
        }

        /* Estilo para el contenedor de carga */
        #loading-screen {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <!-- Contenedor de carga -->
    <div id="loading-screen">
        <x-animation />
    </div>
    <div id="app">
        <main>
            @livewire('accesos.accesos')
            <div class="main">
                @include('components.app-layout.navbar', ['header' => $header ?? ''])
                <div class="main-content">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
    <!-- Scripts -->
    <script>
        {
            let navigation = document.querySelector(".navigation");
            let main = document.querySelector(".main");

            if (localStorage.sidebar === 'ocultar') {
                navigation.classList.remove("active");
                main.classList.remove("active");
            } else {
                navigation.classList.add("active");
                main.classList.add("active");
            }
        }

        // Fuerza la carga de los estilos en el navbar
        document.addEventListener("DOMContentLoaded", function() {
            const navbar = document.querySelector(".topbar");
            navbar.classList.add("style-applied");
        });
    </script>
    @livewireScripts
    @include('sweetalert::alert')

    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <script type="module" src="{{ asset('web/js/select2.min.js') }}"></script>

    @stack('scripts')
    <script>
       function showLoadingScreen() {
            document.getElementById('loading-screen').style.display = 'block';
            document.getElementById('app').style.display = 'none';
        }

        function hideLoadingScreen() {
            setTimeout(function() {
                document.getElementById('loading-screen').style.display = 'none';
                document.getElementById('app').style.display = 'block';
            }, 1000);
        }

        // Muestra el loading screen en cada navegación o actualización de Livewire
        document.addEventListener("DOMContentLoaded", function() {
            hideLoadingScreen();
        });

        document.addEventListener("livewire:load", function() {
            hideLoadingScreen();
        });

        // Se activa cuando Livewire comienza la navegación
        document.addEventListener("livewire:navigate", function() {
            showLoadingScreen();
        });

        // Se activa cuando Livewire completa la navegación
        document.addEventListener("livewire:navigated", function() {
            hideLoadingScreen();
        });
    </script>
</body>
</html>
