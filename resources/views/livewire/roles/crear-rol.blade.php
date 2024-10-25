<div>
    <div >
        <x-button class="btn btn-warning" style="background-color: #50a803; border-color: #50a803; color:white" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-Rol'})">
            Agregar
        </x-button>
    </div>

    <x-modal-default title="Crear Rol" name="Crear-Rol" :modal="'showModal'" positionTop="top:0px;" maxWidth="max-width:40vw;">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="crearRol" class="gap-3 d-flex flex-column">
                    <div class="mb-3 form-group col-md-6">
                        <label for="name">Nombre</label>
                        <x-input type="text" wire:model="name" class="form-control" />
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    {{-- select de permisos
                    <div class="mb-3 form-group d-flex flex-column col-md-6" wire:ignore>
                        <label for="permisos">Permisos</label>
                        <select wire:model="permisos" class="form-control" id="select2">
                            <option value="">Seleccione un permiso</option>
                            @foreach ($permisos as $permiso)
                                <option value="{{ $permiso->id }}">{{ $permiso->name }}</option>
                            @endforeach
                        </select>
                        @error('permisos') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3 form-group col-md-6">
                        <label for="permisos">Lista</label>
                        <ul class="overflow-auto list-group" style="max-height: 200px;">
                            @foreach ($selectedPermisos as $permiso)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>{{ $permiso->name }}</div>
                                    <i class="cursor-pointer text-danger fa-solid fa-trash" wire:click='eliminarPermiso({{ $permiso->id }})'></i>
                                </li>
                            @endforeach
                        </ul>
                    </div> --}}
                    <div class="gap-3 d-flex justify-content-end">
                        <x-button class="btn btn-secondary" wire:click="limpiar">
                            Limpiar
                        </x-button>
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
            $('#select2').select2();
            $('#select2').on('change', function(e) {
                var data = $('#select2').select2("val");
                @this.set('permisoSeleccionado', data);
            });
    </script>
@endpush
