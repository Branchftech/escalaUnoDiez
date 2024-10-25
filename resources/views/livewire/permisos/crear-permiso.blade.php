<div>
    <div>
        <x-button class="btn btn-warning" style="background-color: #50a803; border-color: #50a803; color:white" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-Permiso'})">
            Agregar
        </x-button>
    </div>

    <x-modal-default title="Crear Permiso" name="Crear-Permiso" :modal="'showModal'" positionTop="top:0px;" maxWidth="max-width:40vw;">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="crearPermiso" class="gap-3 d-flex flex-column">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <x-input type="text" wire:model="name" class="form-control" />
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="gap-2 d-flex justify-content-end">
                        <x-button class="btn btn-secondary" wire:click="limpiar">
                            Limpiar
                        </x-button>

                        <x-button type="submit" class="btn btn-primary">
                            Guardar
                        </x-button>
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
