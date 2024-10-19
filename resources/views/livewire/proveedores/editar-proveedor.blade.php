<div>
    <x-modal-default title="Editar Proveedor: {{ $model->nombre }}" name="Editar-Proveedor">
        <x-slot:body>
            <div class="p-4">
                <form wire:submit.prevent="editarProveedor({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 40vh;">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <x-input type="text" wire:model="nombre" class="form-control" />
                            @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        {{-- <div class="form-group">
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
                        </div> --}}
                        <div class=" form-group d-flex flex-column" wire:ignore>
                            <label for="servicios">Servicios</label>
                            <select wire:model="servicios" class="form-control" id="select2EditServicioProveedor">
                                <option value="" selected hidden>Seleccione un servicio</option>
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('servicios') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="mb-3 form-group col-md-6">
                            <label for="servicios">Lista</label>
                            <ul class="overflow-auto list-group" style="max-height: 200px;">
                                @foreach ($selectedServicios as $servicio)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>{{ $servicio->nombre }}</div>
                                        <i class="cursor-pointer text-danger fa-solid fa-trash" wire:click='eliminarServicio({{ $servicio->id }})'></i>
                                    </li>
                                @endforeach
                            </ul>
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

@push('scripts')
     <script type="module">
            // $('#select2Edit').select2();
            // $('#select2Edit').on('change', function(e) {
            //     var data = $('#select2Edit').select2("val");
            //     @this.set('servicioSeleccionado', data);
            // });

        initializeSelect2();

        // Función para inicializar select2
        function initializeSelect2() {
            $('#select2EditServicioProveedor').select2({
                placeholder: "Seleccione un Servicio",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('servicioSeleccionado', data);
            });
        }

        // Destruir y reinicializar select2 cuando sea necesario
        function resetSelect2() {
            $('#select2EditServicioProveedor').select2('destroy');
            initializeSelect2();
        }

        // Evento cuando se carga la página
        window.addEventListener('livewire:init', () => {
            initializeSelect2();
        });
        // Evento para recargar las unidades cuando se selecciona un material
        Livewire.on("actualizarServiciosProveedor", (data) => {

            // Accede a data[0].servicios
            if (!data[0] || !data[0].servicios || !Array.isArray(data[0].servicios)) {
                console.error("No se encontraron servicios en los datos recibidos");
                return;
            }

            let select2ServicioProv = $('#select2EditServicioProveedor');
            select2ServicioProv.select2('destroy');
            select2ServicioProv.find('option').not(':first').remove();

            // Recorre el array de servicios dentro de data[0].servicios
            data[0].servicios.forEach(function(servicio) {
                let newOption = new Option(servicio.nombre, servicio.id, false, false);
                select2ServicioProv.append(newOption);
            });

            select2ServicioProv.select2({
                placeholder: "Seleccione un Servicio",
                allowClear: true
            });
        });
        // Escucha el evento `resetSelect2` para limpiar y reinicializar los select2
        window.addEventListener('resetSelect2', () => {
            resetSelect2();
        });
    </script>
@endpush
