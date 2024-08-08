<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ Request::route()->getName() == 'usuarios' ? 'Usuarios' : '' }}
        </h2>
    </x-slot>

    <!-- Contenido de tu página aquí -->
    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="margin: 0 auto; max-width: 1000px;">
            <div> Usuarios</div>
        </div>
    </div>
</x-app-layout>
