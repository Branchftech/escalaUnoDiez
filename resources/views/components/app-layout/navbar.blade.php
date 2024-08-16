@props(['header'])
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="topbar">
    <div class="toggle">
        <i class="fas fa-bars"></i> <!-- Icono de menú (FontAwesome) -->
    </div>
    <div class="menu-title">
        <h2>{{ $header }}</h2> <!-- Título de la página -->
    </div>

    <div class="notification">
        <i class="fas fa-bell"></i> <!-- Icono de campana (FontAwesome) -->
        <span class="notification-dot"></span> <!-- Punto de notificación -->
    </div>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav" style="padding-right: 3%;">
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('profile') }}" wire:navigate="profile">
                        {{ __('Perfil') }}
                    </a>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</div>

<style>
    /* Estilos para la barra de búsqueda */
    .search-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-container input[type="text"] {
        padding-right: 30px;
        width: 100%;
    }

    .search-icon {
        position: absolute;
        right: 10px;
    }

    /* Estilos de la campana de notificacion*/
    .notification {
        position: relative;
        display: inline-block;
        margin: 0 20px;
    }

    .notification-dot {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%;
        display: none;
    }

    .notification i {
        color: black;
        font-size: 24px;
    }

    /* Mostrar el punto rojo cuando haya notificaciones */
    .notification.has-notifications .notification-dot {
        display: block;
    }

    /*Estilos para el titulo de la pagina*/
    .menu-title {
        flex-grow: 1;
        display: flex;
        justify-content: left;
        margin: 0 20px;
        color: black;
        font-size: 20px;
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 10px;
        height: 60px;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
</style>

<script></script>
