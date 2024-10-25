<x-app-layout>
    <x-slot name="header">
            {{ __('Usuarios') }}
    </x-slot>

    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Usuarios</h4>
            </div>
            <livewire:usuarios.crear-usuario/>
        </div>
        <livewire:usuarios.usuarios-table/>
    </div>

     <livewire:usuarios.editar-usuario  />
    <livewire:usuarios.eliminar-usuario  />
</x-app-layout>
