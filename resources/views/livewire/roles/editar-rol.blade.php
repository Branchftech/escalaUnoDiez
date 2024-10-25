<div>
    <x-modal-default title="Editar Rol: {{ $model->name }}" name="Editar-Rol">
        <x-slot:body>
            <div class="p-4">
                <form wire:submit.prevent="editarRol({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="mb-3 form-group col-md-6">
                            <label for="name">Nombre</label>
                            <x-input type="text" wire:model="name" id="name" class="form-control" />
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- select de permisos -
                        <div class="mb-3 form-group col-md-6 d-flex flex-column" wire:ignore>
                            <label for="permisos">Permisos</label>
                            <select wire:model="permisos" class="form-control" id="select2Edit">
                                <option value="">Seleccione un permiso</option>
                                @foreach ($permisos as $permiso)
                                    <option value="{{ $permiso->id }}">{{ $permiso->name }}</option>
                                @endforeach
                            </select>
                            @error('permisos') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div class="mb-3 form-group col-md-6">
                            <label for="permisos">Lista</label>
                            <ul class="overflow-auto list-group scroll-container" style="max-height: 200px;">
                                @foreach ($selectedPermisos as $permiso)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>{{ $permiso->name }}</div>
                                        <i class="cursor-pointer text-danger fa-solid fa-trash" wire:click='eliminarPermiso({{ $permiso->id }})'></i>
                                    </li>
                                @endforeach
                            </ul>
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

@push('scripts')
    <script type="module">
            $('#select2Edit').select2();
            $('#select2Edit').on('change', function(e) {
                var data = $('#select2Edit').select2("val");
                @this.set('permisoSeleccionado', data);
            });
    </script>
@endpush
