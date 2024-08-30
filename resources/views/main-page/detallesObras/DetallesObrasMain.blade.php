<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold text-dark">
            {{ __('Detalle Obra') }}
        </h2>
    </x-slot>
    <div>
        <div wire:key='detalleObra'>
            <livewire:detalles-obras.editar-detalle-obra :id="$id" />
            <livewire:detalles-obras.detalles-obras-table :id="$id"/>
        </div>
    </div>
</x-app-layout>
