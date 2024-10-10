<x-app-layout>
    <x-slot name="header">
            {{ __('Bancos') }}
    </x-slot>

    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Bancos</h4>
            </div>
            <livewire:bancos.crear-banco />

        </div>

        <livewire:bancos.bancos-table/>
    </div>

    <livewire:bancos.editar-banco  />
    <livewire:bancos.eliminar-banco  />


</x-app-layout>
