<div>
    <div>
        <x-button class="btn btn-warning" style="background-color: #50a803; border-color: #50a803; color:white" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-Acceso'})">
            Agregar
        </x-button>
    </div>

    <x-modal-default title="Crear Acceso" name="Crear-Acceso" :modal="'showModal'" positionTop="top:0px;" maxWidth="max-width:40vw;">
        <x-slot:body>
            <div class="p-1 ">
                <form wire:submit.prevent="crearAcceso" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <x-input type="text" wire:model="nombre" class="form-control" />
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label>
                            <x-input type="text" wire:model="url" class="form-control" />
                            @error('url')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
