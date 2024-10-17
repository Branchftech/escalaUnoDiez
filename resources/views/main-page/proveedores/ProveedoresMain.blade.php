<x-app-layout>
    <x-slot name="header">
        {{ __('Proveedores y Servicios') }}
    </x-slot>
<div>
    <div wire:key='prove'>
        <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
                <div class=" h4">
                    <h4>Lista de Proveedores </h4>
                </div>
                <livewire:proveedores.crear-proveedor />

            </div>
            <livewire:proveedores.proveedores-table />
        </div>
        <livewire:proveedores.editar-proveedor  />
        <livewire:proveedores.eliminar-proveedor  />
    </div>
    <div wire:key='servis'>
        <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
                <div class=" h4">
                    <h4>Lista de Servicios</h4>
                </div>
                <livewire:servicios.crear-servicio />

            </div>
            <livewire:servicios.servicios-table />
        </div>
        <livewire:servicios.editar-servicio  />
        <livewire:servicios.eliminar-servicio  />
    </div>


</div>
</x-app-layout>
