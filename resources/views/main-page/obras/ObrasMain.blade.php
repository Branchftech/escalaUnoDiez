<x-app-layout>
    <x-slot name="header">
        <h2 class=" font-weight-bold text-dark">
            {{ __('Obras') }}
        </h2>
    </x-slot>
    <div>
        <livewire:obras.crear-obra />
        <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
                <div class=" h4">
                    <h4>Lista de Obras</h4>
                </div>
            </div>
            <livewire:obras.obras-table/>
        </div>
    </div>
</x-app-layout>
