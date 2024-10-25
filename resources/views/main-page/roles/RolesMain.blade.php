<x-app-layout>
    <x-slot name="header">
            {{ __('Roles') }}
    </x-slot>

    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Roles</h4>
            </div>
            <livewire:roles.crear-rol/>
        </div>
        <livewire:roles.roles-table/>
    </div>

     <livewire:roles.editar-rol  />
    <livewire:roles.eliminar-rol  />
</x-app-layout>
