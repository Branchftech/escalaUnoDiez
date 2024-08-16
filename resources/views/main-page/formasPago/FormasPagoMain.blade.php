<x-app-layout>
    <x-slot name="header">
        <h2 class=" font-weight-bold text-dark">
            {{ __('Formas de Pago') }}
        </h2>
    </x-slot>
    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de las Formas de Pago</h4>
            </div>
            <livewire:formas-pago.crear-formas-pago />

        </div>

        <livewire:formas-pago.formas-pago-table />
    </div>

    <livewire:formas-pago.editar-formas-pago  />
    <livewire:formas-pago.eliminar-formas-pago  />

</x-app-layout>
