<div>
    <x-modal-default title="Editar Proveedor: {{ $model->nombre }}" name="Editar-Proveedor">
        <x-slot:body>
            <div class="p-4">
                <form wire:submit.prevent="editarProveedor({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <x-input type="text" wire:model="nombre" class="form-control" />
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="direccion">Direccion</label>
                        <x-input type="text" wire:model="direccion" class="form-control" />
                        @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
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
                    <div class=" form-group d-flex flex-column" wire:ignore>
                        <label for="servicios">Servicios</label>
                        <select wire:model="servicios" class="form-control" id="select2Edit">
                            <option value="">Seleccione un servicio</option>
                            @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('servicios') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="mb-3 form-group col-md-6">
                        <label for="servicios">Lista</label>
                        <ul class="overflow-auto list-group scroll-container" style="max-height: 200px;">
                            @foreach ($selectedServicios as $servicio)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>{{ $servicio->nombre }}</div>
                                    <i class="cursor-pointer text-danger fa-solid fa-trash" wire:click='eliminarServicio({{ $servicio->id }})'></i>
                                </li>
                            @endforeach
                        </ul>
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
                @this.set('servicioSeleccionado', data);
            });
    </script>
@endpush
