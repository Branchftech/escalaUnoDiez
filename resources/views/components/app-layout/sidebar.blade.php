
<div class="navigation ">
    <ul class="d-flex  flex-column gap-2 p-0">
        <li style="padding-top: 1rem;">
            <a href="#" class="d-flex align-items-center  ">
                <img class="rounded-circle bg-white me-2" width="48" height="48" style="border-radius: 50%;"
                    src="{{ asset('assets/images/logo.png') }}" alt="" />
                <span class="title">Escala 1:10</span>
            </a>

        </li>
        <li data-title="Dashboard" class=" {{ request()->routeIs('dashboard') ? 'activar' : '' }}">
            <a href="{{ route('dashboard') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i
                        class="fas fa-home"></i></span>
                <span class="title">Dashboard</span>

            </a>
        </li>
        <li data-title="" class=" {{ request()->routeIs('bancos') ? 'activar' : '' }}">
            <a href="{{ route('bancos') }}" wire:navigate
                class="d-flex align-items-center ">
                <span class="icon d-flex justify-content-center align-items-center me-2"> <i class="fa-solid fa-flag"></i></span>
                <span class="title">Bancos</span>
            </a>
        </li>
        <li data-title="item4" class="{{ request()->routeIs('item4') ? 'activar' : '' }}">
            <a onclick="return false;" class="d-flex align-items-center">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-chart-pie"></i></span>
                <span class="title">Estadisticas</span>
            </a>
        </li>
        <li data-title="Notas" class="{{ request()->routeIs('notas') ? 'activar' : '' }}">
            <a onclick="return false;" class="d-flex align-items-center">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-envelope"></i></span>
                <span class="title">Obras</span>
            </a>
        </li>
        <li data-title="item3" class="{{ request()->routeIs('item3') ? 'activar' : '' }}">
            <a onclick="return false;" class="d-flex align-items-center">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-image"></i></span>
                <span class="title">Datos</span>
            </a>
        </li>
        <li data-title="item2" class="{{ request()->routeIs('item2') ? 'activar' : '' }}">
            <a onclick="return false;" class="d-flex align-items-center">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-users"></i></span>
                <span class="title">Usuarios</span>
            </a>
        </li>
        <li data-title="item6" class="{{ request()->routeIs('item6') ? 'activar' : '' }}">
            <a onclick="return false;" class="d-flex align-items-center">
                <span class="icon d-flex justify-content-center align-items-center me-2"><i class="fa-solid fa-gear"></i></span>
                <span class="title">Configuración</span>
            </a>
        </li>
    </ul>
</div>



@push('scripts')
    <script type="module">

{

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
        });}
    </script>
@endpush


