<x-app-layout>
    <x-slot name="header">
            {{ __('Menú Dinámico') }}
    </x-slot>

    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Páginas</h4>
            </div>
            <livewire:menu.crear-menu/>
        </div>
        <livewire:menu.menu-table/>
    </div>

    <livewire:menu.editar-menu  />
    <livewire:menu.eliminar-menu  />
</x-app-layout>
