<x-app-layout>
    <x-slot name="header">
        <h2 class=" font-weight-bold text-dark">
            {{ __('Destajos') }}
        </h2>
    </x-slot>
    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Destajos</h4>
            </div>
            <livewire:destajos.crear-destajo />

        </div>

        <livewire:destajos.destajos-table/>
    </div>
    <livewire:destajos.editar-destajo  />
    <livewire:destajos.eliminar-destajo  />

</x-app-layout>
