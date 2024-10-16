<x-app-layout>
    <x-slot name="header">
            {{ __('Ingresos') }}
    </x-slot>

    <div>
        <livewire:ingresos.crear-ingreso />
    </div>
    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Ingresos</h4>
            </div>

        </div>
        <livewire:ingresos.ingresos-table/>
    </div>

    <livewire:ingresos.editar-ingreso  />
    <livewire:ingresos.eliminar-ingreso  />

</x-app-layout>
