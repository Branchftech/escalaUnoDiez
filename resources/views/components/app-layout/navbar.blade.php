@props(['header'])
<div class="topbar">
    <div class="toggle">
        <i class="fas fa-bars"></i> <!-- Icono de menú (FontAwesome) -->
    </div>
    <div class="menu-title">
        <h2>{{ $header }}</h2> <!-- Título de la página -->
    </div>
    <div class="search">
        <label class="search-container">
            <input type="text" placeholder="Buscar elemento">
            <i class="fas fa-search search-icon"></i> <!-- Icono de búsqueda (FontAwesome) -->
        </label>
    </div>
    <div class="notification">
        <i class="fas fa-bell"></i> <!-- Icono de campana (FontAwesome) -->
        <span class="notification-dot"></span> <!-- Punto de notificación -->
    </div>
    {{-- <div class="user d-flex align-items-center">
        <img src="{{ asset('assets/images/customer01.jpg') }}" alt="" class="rounded-circle" width="40"
            height="40">
        <span class="ms-2 username">Usuario</span> <!-- Nombre del usuario -->
        <a href="#" class="dropdown-toggle ms-2" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-chevron-down"></i> <!-- Icono de desplegable -->
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Ver perfil</a></li>
            <!-- Link al perfil del usuario -->
        </ul>
    </div> --}}

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav">
        <!-- Authentication Links -->
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
        /* Ajusta el padding derecho para evitar que el texto sobreescriba el icono */
        width: 100%;
        /* O ajusta según la anchura deseada */
    }

    .search-icon {
        position: absolute;
        right: 10px;
        /* Ajusta según necesidad para posicionar correctamente el icono dentro del campo */
    }

    /* Estilos de la campana de notificacion*/
    .notification {
        position: relative;
        display: inline-block;
        margin: 0 20px;
        /* Espacio alrededor del ícono de notificación */
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
        /* Ocultar por defecto, mostrar cuando hay notificaciones */
    }

    .notification i {
        color: black;
        /* Establece el color del ícono de la campana */
        font-size: 24px;
        /* Tamaño del ícono */
    }

    /* Mostrar el punto rojo cuando haya notificaciones */
    .notification.has-notifications .notification-dot {
        display: block;
    }

    /*Estilos para el titulo de la pagina*/
    .menu-title {
        flex-grow: 1;
        /* Permite que el título ocupe el espacio disponible */
        display: flex;
        /* Centra el título verticalmente */
        justify-content: left;
        /* Centra el título horizontalmente */
        margin: 0 20px;
        /* Margen horizontal para separación */
        color: black;
        /* Color del texto */
        font-size: 20px;
        /* Tamaño del texto */
    }

    .topbar {
        display: flex;
        /* Asegura que todos los elementos de la topbar estén en línea */
        justify-content: space-between;
        /* Distribuye el espacio entre elementos de manera uniforme */
        align-items: center;
        /* Alinea todos los elementos verticalmente */
        padding: 0 10px;
        /* Padding horizontal de la barra completa */
        height: 60px;
        /* Altura fija para la topbar */
        background: #fff;
        /* Fondo blanco o el que prefieras */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Sombra sutil para el navbar */
    }
</style>
<script></script>
