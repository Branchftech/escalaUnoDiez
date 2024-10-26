<!-- D:\Branch\escalaUnoDiez\resources\views\livewire\accesos\accesos.blade.php -->
<div class="overflow-y-auto navigation scroll-container">
    <ul class="gap-2 p-0 d-flex flex-column">
        <li>
            <a href="#" class="d-flex align-items-center" style="justify-content: center;">
                <div style="width: 60px; height: 45px;">
                    <div class="overflow-hidden" style="width: 60px; height: 60px; border-radius: 50%;">
                        <img class="object-fit-cover" style="width: 100%; height: 100%;" src="{{ asset('assets/images/logo.png') }}" alt="" />
                    </div>
                </div>
            </a>
        </li>
        @foreach($accesos as $acceso)
            <li data-title="" class="{{ request()->routeIs($acceso->url) ? 'activar' : '' }}">
                <a href="{{ route($acceso->url) }}" wire:navigate class="d-flex align-items-center">
                    <span class="icon d-flex justify-content-center align-items-center me-2">
                        <i class="{{ $acceso->icono }}"></i>
                    </span>
                    <span class="title">{{ $acceso->nombre }}</span>
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
