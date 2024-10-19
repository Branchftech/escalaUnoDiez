<div>
    <x-modal-default title="Editar Cliente: {{ $model->nombre }}" name="Editar-Cliente">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarCliente({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 40vh;">
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
                        {{-- <div class="form-group">
                            <label for="cedula">Cedula</label>
                            <x-input type="text" wire:model="cedula" class="form-control" />
                            @error('cedula') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}
                    </div>
                    <div class="gap-3 d-flex justify-content-end">
                        <x-button type="submit" class="btn btn-primary">
                            Guardar
                        </x-button>
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
