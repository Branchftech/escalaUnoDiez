<div>
    <x-modal-default title="Editar Usuario: {{ $model->name }}" name="Editar-Usuario" >
        <x-slot:body>
            <div class="p-4">
                <form wire:submit.prevent="editarUsuario({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <x-input type="text" wire:model="name" class="form-control"   />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <x-input type="text" wire:model="email" class="form-control"  autocomplete="off" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <x-input type="password" wire:model="password" class="form-control"  autocomplete="off" />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                                <x-input type="password" wire:model="password_confirmation" class="form-control" autocomplete="off" />
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="roles" class="form-label">Roles</label>
                                <select wire:model="roles" class="form-select" id="select2Rol">
                                    <option value="">Seleccione un rol</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="mb-3">
                                <label for="permisos" class="form-label">Permisos</label>
                                <select wire:model="permisos" class="form-select" id="select2Permiso">
                                    <option value="">Seleccione un permiso</option>
                                    @foreach ($permisos as $permiso)
                                        <option value="{{ $permiso->id }}">{{ $permiso->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="gap-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </div>

                        <div class="col-12 col-md-5">
                            {{-- Mostrar los roles seleccionados --}}
                            <div class="mb-3">
                                <label class="form-label">Lista de roles</label>
                                <ul class="p-3 border rounded list-unstyled scroll-container" style="min-height: 50px; max-height: 200px; overflow-y: auto;">
                                    @isset($selectedRoles)
                                        @foreach ($selectedRoles as $rol)
                                            <li class="mb-2 d-flex justify-content-between align-items-center">
                                                <div>{{ $rol->name }}</div>
                                                <i class="cursor-pointer text-danger fas fa-trash" wire:click='eliminarRol({{ $rol->id }})'></i>
                                            </li>
                                        @endforeach
                                    @endisset
                                </ul>
                            </div>

                            {{-- Mostrar los permisos seleccionados --}}
                            {{-- <div class="mb-3">
                                <label class="form-label">Lista de permisos</label>
                                <ul class="p-3 border rounded list-unstyled scroll-container" style="min-height: 50px; max-height: 200px; overflow-y: auto;">
                                    @isset($selectedPermisos)
                                        @foreach ($selectedPermisos as $permiso)
                                            <li class="mb-2 d-flex justify-content-between align-items-center">
                                                <div>{{ $permiso->name }}</div>
                                                <i class="cursor-pointer text-danger fas fa-trash" wire:click='eliminarPermiso({{ $permiso->id }})'></i>
                                            </li>
                                        @endforeach
                                    @endisset
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>

@push('scripts')
    <script type="module">
            $('#select2Rol').select2();
            $('#select2Rol').on('change', function(e) {
                var data = $('#select2Rol').select2("val");
                @this.set('rolSeleccionado', data);
            });

            // $('#select2Permiso').select2();
            // $('#select2Permiso').on('change', function(e) {
            //     var data = $('#select2Permiso').select2("val");
            //     @this.set('permisoSeleccionado', data);
            // });
    </script>
@endpush
