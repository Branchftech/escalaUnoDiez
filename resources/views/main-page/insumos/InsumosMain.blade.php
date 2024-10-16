<x-app-layout>
    <x-slot name="header">
        {{ __('Insumos y Materiales') }}
    </x-slot>
    <div>
        <div>
            <div wire:key='materiales'>

               <livewire:insumos.crear-insumo />

            </div>

        </div>


        <div wire:key='tabla'>
            <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <div class="h4">
                    <h4>Insumos Creados</h4>
                </div>
                <hr>
                <livewire:insumos.insumos-table />
            </div>
        </div>
      <livewire:insumos.editar-insumo  />
      <livewire:insumos.eliminar-insumo  />
    </div>
</x-app-layout>
