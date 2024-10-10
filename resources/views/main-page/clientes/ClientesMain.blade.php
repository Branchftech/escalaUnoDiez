<x-app-layout>
    <x-slot name="header">
            {{ __('Clientes') }}
    </x-slot>

   <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Clientes</h4>
            </div>
            <livewire:clientes.crear-cliente />
        </div>
        <livewire:clientes.clientes-table/>
    </div>
    <livewire:clientes.editar-cliente  />
    <livewire:clientes.eliminar-cliente  />

</x-app-layout>
