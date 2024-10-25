<div>
    <div >
        <x-button class="btn btn-warning" style="background-color: #50a803; border-color: #50a803; color:white"  x-data x-on:click="$dispatch('open-modal', {name: 'Crear-Usuario'})">
            Agregar
        </x-button>
    </div>

    <x-modal-default title="Crear Usuario" name="Crear-Usuario" :modal="'showModal'" positionTop="top:0px;" maxWidth="max-width:40vw;">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="crearUsuario" class="gap-3 d-flex flex-column">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Nombre</label>
                        <x-input type="text" wire:model="name" class="form-control" />
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <x-input type="text" wire:model="email" class="form-control"  autocomplete="off" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <x-input type="password" wire:model="password" class="form-control"  autocomplete="off" />
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                        <x-input type="password" wire:model="password_confirmation" class="form-control"  autocomplete="off" />
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="gap-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" wire:click="limpiar">
                            Limpiar
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
