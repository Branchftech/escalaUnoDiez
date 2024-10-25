<div>
    <x-modal-default title="Eliminar Rol" name="Eliminar-Rol">
        <x-slot:body>
            <div class="p-5 rounded-lg">
                <div>
                    <h2 class="mb-4 text-lg font-semibold">¿Estás seguro de que deseas eliminar el rol
                        "{{ $model->name }}" ?</h2>
                    <div class="flex justify-end space-x-4">
                        <x-secondary-button x-on:click="$dispatch('close-modal')">Cancelar</x-secondary-button>
                        <x-danger-button x-on:click="$wire.eliminarRol(); showModal = false">
                            Confirmar
                        </x-danger-button>
                    </div>
                </div>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
