<div>
    <div style="display: flex; justify-content: end; align-items: end; padding-bottom: 1rem;">
        <x-button class="btn btn-warning" style="background-color: #50a803; border-color: #50a803; color:white" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-BitacoraObra'})">
            Agregar Bitacora
        </x-button>
    </div>

    <x-modal-default title="Crear Bitacora" name="Crear-BitacoraObra" :modal="'showModal'">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="crearBitacoraObra" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <textarea wire:model="descripcion" class="form-control" rows="5"></textarea>
                            @error('descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="gap-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" wire:click="limpiar">
                            Limpiar
                        </button>

                        <x-button type="submit" class="btn btn-primary">
                            Guardar
                        </x-button>
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
