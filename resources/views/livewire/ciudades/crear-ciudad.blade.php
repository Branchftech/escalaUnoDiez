<div>
    <x-button class="btn btn-info" style="background-color: #50a803; border-color: #50a803; color:white"
        x-on:click="$dispatch('open-modal', {name: 'Crear-Ciudad'})">
        Agregar
    </x-button>

    <x-modal-default name="Crear-Ciudad" :modal="'showModal'">
        <x-slot:title>
            <h5 class="mb-0">Crear Ciudad</h5>
        </x-slot:title>

        <x-slot:body>
            <div class="p-4">
                <form wire:submit.prevent="crearCiudad" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <!-- Campo Nombre -->
                        <div class="form-group">
                            <label for="nombre">Nombre de la Ciudad</label>
                            <x-input type="text" wire:model="nombre" class="form-control" />
                            @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Select para Estado -->
                        <div class="form-group">
                            <label for="idEstado">Estado</label>
                            <select wire:model="idEstado" class="form-control">
                                <option value="" selected hidden>Seleccione un estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                            @error('idEstado') <span class="text-danger">{{ $message }}</span> @enderror
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
