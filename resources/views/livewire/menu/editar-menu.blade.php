<div>
    <x-modal-default title="Editar Menu: {{ $nombre }}" name="Editar-Menu" :show="$showModal">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="actualizarMenu" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <x-input type="text" wire:model="nombre" id="nombre" class="form-control" />
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="url">URL</label>
                            <x-input type="text" wire:model="url" id="url" class="form-control" />
                            @error('url')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="icono">Icono</label>
                            <x-input type="text" wire:model="icono" id="icono" class="form-control" />
                            @error('icono')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="idRol">Rol</label>
                            <select id="idRol" wire:model="idRol" class="form-control">
                                <option value="">Seleccione un Rol</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('idRol')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
