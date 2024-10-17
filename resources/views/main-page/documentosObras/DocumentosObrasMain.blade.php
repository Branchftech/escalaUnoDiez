<x-app-layout>
    <x-slot name="header">
            {{ __('Documentos') }}
    </x-slot>

    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
            <div class=" h4">
                <h4>Lista de Bancos</h4>
            </div>
            <livewire:documentos-obras.crear-documento-obra />

        </div>

        <livewire:documentos-obras.documentos-obras-table/>
    </div>

    <livewire:documentos-obras.eliminar-documento-obra  />


</x-app-layout>
