<li class="relative flex w-full nav-link">

    <a href="#" class="flex items-center justify-between {{ $active  }} " onclick="toggleSubmenu{{ $name }}(event)">
        <div class="flex items-center">
            {{ $title ?? '' }}

        </div>
        <div class="text">
            <i class="fa-solid fa-chevron-right icon icon{{  $name }} "></i>
        </div>
    </a>

        {{ $submenu ?? '' }}
</li>
@push('scripts')
    <script>
        function toggleSubmenu{{ $name }}(event) {
            event.preventDefault();
            const icon = document.querySelector('.icon{{  $name }}');
            const submenu = event.currentTarget.nextElementSibling;
            if (submenu) {
                submenu.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            } else {
                console.error('No se encontró el submenu');
            }
        }
    </script>

@endpush
