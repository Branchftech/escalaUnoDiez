{{--
<div class="overflow-y-auto navigation scroll-container">
    <ul class="gap-2 p-0 d-flex flex-column">
        <li>
                <a href="#" class="d-flex align-items-center" style="justify-content: center;">
                    <div style="width: 60px; height: 45px;">

                        <div class="overflow-hidden " style="width: 60px; height: 60px;border-radius: 0.5rem; border-radius: 50%;">
                            <img class="object-fit-cover"
                                style="width: 100%; height: 100%;"
                                src="{{ asset('assets/images/logo.png') }}" alt="" />
                        </div>
                    </div>
                    <!--<span class="title ms-2">Escala 1:10</span>-->
                </a>
        </li>

        <li data-title="" class=" {{ request()->routeIs('dashboard') ? 'activar' : '' }}">
            <a href="{{ route('dashboard') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fas fa-home"></i></span>
                <span class="title">Dashboard</span>

            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('bancos') ? 'activar' : '' }}">
            <a href="{{ route('bancos') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"> <i class="fa-solid fa-building-columns"></i></span>
                <span class="title">Bancos</span>
            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('proveedores') ? 'activar' : '' }}">
            <a href="{{ route('proveedores') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-user-tie"></i></span>
                <span class="title">Proveedores</span>
            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('clientes') ? 'activar' : '' }}">
            <a href="{{ route('clientes') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-user-plus"></i></span>
                <span class="title">Clientes</span>
            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('formasPago') ? 'activar' : '' }}">
            <a href="{{ route('formasPago') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-cash-register"></i></span>
                <span class="title">Formas Pago</span>
            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('insumos') ? 'activar' : '' }}">
            <a href="{{ route('insumos') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-person-digging"></i></span>
                <span class="title">Insumos</span>
            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('obras') ? 'activar' : '' }}">
            <a href="{{ route('obras') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-building-user"></i></span>
                <span class="title">Obras</span>
            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('egresos') ? 'activar' : '' }}">
            <a href="{{ route('egresos') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-money-bill-transfer"></i></span>
                <span class="title">Egresos</span>
            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('ingresos') ? 'activar' : '' }}">
            <a href="{{ route('ingresos') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-money-bill-trend-up"></i></span>
                <span class="title">Ingresos</span>
            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('destajos') ? 'activar' : '' }}">
            <a href="{{ route('destajos') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-handshake-simple"></i></span>
                <span class="title">Destajos</span>
            </a>
        </li>
        @can('ver-rol')
            <li data-title="" class=" {{ request()->routeIs('roles') ? 'activar' : '' }}">
                <a href="{{ route('roles') }}" wire:navigate
                    class="d-flex align-items-center">
                    <span class="icon d-flex justify-content-center align-items-center me-2"><i
                            class="fas fa-user"></i></span>
                    <span class="title">roles</span>
                </a>
            </li>
        @endcan
        @can('ver-usuario')
            <li data-title="" class=" {{ request()->routeIs('usuarios') ? 'activar' : '' }}">
                <a href="{{ route('usuarios') }}" wire:navigate
                    class="d-flex align-items-center">
                    <span class="icon d-flex justify-content-center align-items-center me-2"><i
                            class="fas fa-users"></i></span>
                    <span class="title">usuarios</span>
                </a>
            </li>
        @endcan
        <li data-title="" class=" {{ request()->routeIs('menu') ? 'activar' : '' }}">
            <a href="{{ route('menu') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-list"></i></span>
                <span class="title">Menu</span>
            </a>
        </li>
        {{-- <li data-title="" class=" {{ request()->routeIs('permisos') ? 'activar' : '' }}">
            <a href="{{ route('permisos') }}" wire:navigate
                class="d-flex align-items-center">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i
                        class="fas fa-user"></i></span>
                <span class="title">permisos</span>
            </a>
        </li>

    </ul>
</div> --}}
<div class="overflow-y-auto navigation scroll-container">
    <ul class="gap-2 p-0 d-flex flex-column">
        <li>
            <a href="#" class="d-flex align-items-center" style="justify-content: center;">
                <div style="width: 60px; height: 45px;">
                    <div class="overflow-hidden" style="width: 60px; height: 60px; border-radius: 50%;">
                        <img class="object-fit-cover" style="width: 100%; height: 100%;" src="{{ asset('assets/images/logo.png') }}" alt="Logo" />
                    </div>
                </div>
            </a>
        </li>

        @foreach (App\Services\MenuService::getMenuItemsByRole() as $menu)
            <li data-title="{{ $menu->nombre }}" class="{{ request()->routeIs($menu->url) ? 'activar' : '' }}">
                <a href="{{ route($menu->url) }}" class="d-flex align-items-center">
                    <span class="icon d-flex justify-content-center align-items-center me-2">
                        <i class="{{ $menu->icono }}"></i>
                    </span>
                    <span class="title">{{ $menu->nombre }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>


@push('scripts')
    <script type="module">

        const currentLocation = window.location.href; // Obtiene la URL actual
        const menuItems = document.querySelectorAll('.navigation a'); // Selecciona todos los enlaces del menú
        const menuTitleElement = document.querySelector('.menu-title h2'); // Selecciona el elemento del título

        menuItems.forEach(item => {
            if (currentLocation.includes(item.getAttribute('href'))) {
                item.classList.add('active'); // Añade la clase 'active' al elemento correcto
                const dataTitle = item.closest('li').getAttribute(
                'data-title'); // Obtiene el título desde el atributo 'data-title'
                if (dataTitle) {
                    menuTitleElement.textContent = dataTitle; // Establece el título
                }
            } else {
                item.classList.remove(
                'active'); // Asegura que no haya otros elementos marcados como activos incorrectamente
            }
        });

        // Código existente para alternar la visibilidad del menú y otros interactivos
        let toggle = document.querySelector(".toggle");
        let navigation = document.querySelector(".navigation");
        let main = document.querySelector(".main");

        toggle.addEventListener('click', function() {
            // localStorage.setItem("menu", "open");
            if (localStorage.sidebar === 'ocultar') {
                localStorage.sidebar = 'mostrar';
            } else {
                localStorage.sidebar = 'ocultar';
            }
            navigation.classList.toggle("active");
            main.classList.toggle("active");
        });

        // Añadir hover efectos nuevamente si es necesario aquí
        let listItems = document.querySelectorAll(".navigation li");
        listItems.forEach((item) => {
            item.addEventListener("mouseover", function() {
                listItems.forEach((itm) => itm.classList.remove("hovered"));
                item.classList.add("hovered");
            });
        });
    </script>
@endpush


