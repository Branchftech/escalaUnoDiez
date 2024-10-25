<x-app-layout>
    <x-slot name="header">
            {{ __('Permisos') }}
    </x-slot>

    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Permisos</h4>
            </div>
            <livewire:permisos.crear-permiso/>
        </div>
        <livewire:permisos.permisos-table/>
    </div>

    <livewire:permisos.editar-permiso  />
    <livewire:permisos.eliminar-permiso  />
</x-app-layout>
