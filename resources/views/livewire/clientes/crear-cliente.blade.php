<div>
    <div>
        <x-button class="btn btn-warning" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-Cliente'})">
            Agregar
        </x-button>
    </div>

    <x-modal-default title="Crear Cliente" name="Crear-Cliente" :modal="'showModal'">
        <x-slot:body>
            <div class="p-4 ">
                <form wire:submit.prevent="crearCliente" class="gap-3 d-flex flex-column">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <x-input type="text" wire:model="nombre" class="form-control" />
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <x-input type="text" wire:model="apellido" class="form-control" />
                        @error('apellido') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono</label>
                        <x-input type="tel" wire:model="telefono" class="form-control" />
                        @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <x-input type="email" wire:model="email" class="form-control" />
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="cedula">Cedula</label>
                        <x-input type="text" wire:model="cedula" class="form-control" />
                        @error('cedula') <span class="text-danger">{{ $message }}</span> @enderror
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
