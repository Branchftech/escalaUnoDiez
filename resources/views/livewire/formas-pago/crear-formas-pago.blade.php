<div>
    <div>
        <x-button class="btn btn-warning" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-Formas-Pago'})">
            Agregar
        </x-button>
    </div>

    <x-modal-default title="Crear Forma de Pago" name="Crear-Formas-Pago" :modal="'showModal'">
        <x-slot:body>
            <div class="p-4 ">
                <form wire:submit.prevent="crearFormasPago" class="gap-3 d-flex flex-column">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <x-input type="text" wire:model="nombre" class="form-control" />
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
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
