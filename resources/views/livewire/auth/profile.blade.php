<div class="d-flex flex-column gap-4">
    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.5); border-radius: 5px; background-color: #f7f7f7;"">
        <div style="margin: 0 auto;">
            <form method="POST" wire:submit.prevent="updateProfileInformation">

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control"   name="name" wire:model="name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" class="form-control"   name="email" wire:model="email">

                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.5); border-radius: 5px; background-color: #f7f7f7;">
        <div style="margin: 0 auto;">
            <form method="POST" wire:submit.prevent="updateProfilePassword">

                <div class="mb-3">
                    <label for="current_password" class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control"   name="current_password" wire:model="current_password">
                    @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva contraseña</label>
                    <input type="password" class="form-control"   name="password" wire:model="password">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                    <input type="password" class="form-control"   name="password_confirmation" wire:model="password_confirmation">
                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</div>