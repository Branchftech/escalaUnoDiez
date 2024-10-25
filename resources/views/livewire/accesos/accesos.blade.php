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

