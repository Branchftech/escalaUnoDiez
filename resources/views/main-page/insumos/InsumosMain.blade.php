<x-app-layout>
    <x-slot name="header">
        <h2 class=" font-weight-bold text-dark">
            {{ __('Insumos y Materiales') }}
        </h2>
    </x-slot>
<div>
    <div wire:key='materiales'>

                <livewire:insumos.crear-insumo />
                {{-- <livewire:materiales.crear-material /> --}}

           </div>
            {{--  <livewire:materiales.materiales-table /> --}}
        </div>
        {{-- <livewire:materiales.editar-material  />
        <livewire:materiales.eliminar-material  /> --}}
    </div>

    {{-- <div wire:key='prove'>
        <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
                <div class=" h4">
                    <h4>Lista de Insumos </h4>
                </div>
                <livewire:proveedores.crear-proveedor />

            </div>
            <livewire:proveedores.proveedores-table />
        </div>
        <livewire:proveedores.editar-proveedor  />
        <livewire:proveedores.eliminar-proveedor  />
    </div> --}}

    <div wire:key='tabla'>
        <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <div class="h4">
                <h4>Insumos Creados</h4>
            </div>
            <hr>
            <livewire:insumos.insumos-table />
        </div>
    </div>
    <livewire:insumos.editar-insumo  />
    <livewire:insumos.eliminar-insumo  />
</div>
</x-app-layout>
