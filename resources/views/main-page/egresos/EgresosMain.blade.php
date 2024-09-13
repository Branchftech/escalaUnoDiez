<x-app-layout>
    <x-slot name="header">
        <h2 class=" font-weight-bold text-dark">
            {{ __('Egresos') }}
        </h2>
    </x-slot>
    <div>
        <livewire:egresos.crear-egreso />
    </div>
   <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Egresos</h4>
            </div>

        </div>
        <livewire:egresos.egresos-table/>
    </div>
    <livewire:egresos.editar-egreso  />
    <livewire:egresos.eliminar-egreso  />

</x-app-layout>
