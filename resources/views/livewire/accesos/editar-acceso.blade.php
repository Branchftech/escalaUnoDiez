<div>
    <x-modal-default title="Editar Acceso: {{ $model->nombre }}" name="Editar-Acceso">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarAcceso({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <x-input type="text" wire:model="nombre" id="nombre" class="form-control" />
                            @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- <div class="form-group">
                            <label for="url">URL</label>
                            <x-input type="text" wire:model="url" id="url" class="form-control" />
                            @error('url') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}

                        <div class="form-group">
                            <label for="icono">Ícono</label>
                            <x-input type="text" wire:model="icono" id="icono" class="form-control" />
                            @error('icono') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="roles" class="form-label">Roles</label>
                            <select wire:model="rolSeleccionado" class="form-select" id="select2RolAcceso">
                                <option value="">Seleccione un rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-5">
                            <label class="form-label">Lista de roles</label>
                            <ul class="p-3 border rounded list-unstyled scroll-container" style="min-height: 50px; max-height: 200px; overflow-y: auto;">
                                @isset($selectedRoles)
                                    @foreach ($selectedRoles as $rol)
                                        <li class="mb-2 d-flex justify-content-between align-items-center">
                                            <div>{{ $rol->nombre }}</div>
                                            <i class="cursor-pointer text-danger fas fa-trash" wire:click='eliminarRol({{ $rol->id }})'></i>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                        </div>
                    </div>

                    <div class="gap-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>

@push('scripts')
    <script type="module">
        $('#select2RolAcceso').select2();
        $('#select2RolAcceso').on('change', function(e) {
            var data = $('#select2RolAcceso').select2("val");
            @this.set('rolSeleccionado', data);
        });
    </script>
@endpush
