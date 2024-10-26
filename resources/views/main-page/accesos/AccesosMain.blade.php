<x-app-layout>
    <x-slot name="header">
            {{ __('Accesos') }}
    </x-slot>
    <div>
        <div wire:key='accesos'>
            <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
                    <div class=" h4">
                        <h4>Lista de Accesos</h4>
                    </div>
                </div>

                <livewire:accesos.accesos-table/>
            </div>

            <livewire:accesos.editar-acceso  />
        </div>
        <div wire:key='usuarios'>
            <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
                    <div class=" h4">
                        <h4>Lista de Usuario</h4>
                    </div>


                </div>
                <livewire:usuarios.usuarios-table />
            </div>
            <livewire:usuarios.editar-usuario  />
            <livewire:usuarios.eliminar-usuario  />
        </div>
    </div>
</x-app-layout>
