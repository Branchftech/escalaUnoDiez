<div>
    <x-modal-default title="Editar Banco" name="Editar-Banco" :modal="'showModal'">
        <x-slot:body>
            <div class="p-4">
                <form wire:submit.prevent="editarBanco" class="gap-3 d-flex flex-column">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <x-input type="text" wire:model="nombre" class="form-control" />
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="gap-2 d-flex justify-content-end">
                        <x-button class="btn btn-secondary" wire:click="$emit('close-modal')">
                            Cancelar
                        </x-button>
                        <x-button type="submit" class="btn btn-primary">
                            Actualizar
                        </x-button>
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
