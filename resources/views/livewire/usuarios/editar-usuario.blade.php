<div>
    <x-modal-default title="Editar Usuario: {{ $model->name }}" name="Editar-Usuario">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarUsuario({{ $model->id }})" class="gap-4 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <x-input type="text" wire:model="name" class="form-control" />
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <x-input type="text" wire:model="email" class="form-control" autocomplete="off" />
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rolesUsuario" class="form-label">Roles</label>
                            <select wire:model="rolSeleccionadoUsuario" class="form-select" id="select2RolUsuario">
                                <option value="">Seleccione un rol</option>
                                @foreach ($rolesUsuario as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-5">
                            <label class="form-label">Lista de roles</label>
                            <ul class="p-3 border rounded list-unstyled scroll-container" style="min-height: 50px; max-height: 200px; overflow-y: auto;">
                                @isset($selectedRolesUsuario)
                                    @foreach ($selectedRolesUsuario as $rol)
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
        $('#select2RolUsuario').select2();
        $('#select2RolUsuario').on('change', function(e) {
            var data = $('#select2RolUsuario').select2("val");
            @this.set('rolSeleccionadoUsuario', data);
        });
    </script>
@endpush
