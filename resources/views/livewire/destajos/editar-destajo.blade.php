<div>
    <x-modal-default title="Editar Destajo" name="Editar-Destajo" :modal="'showModal'" class="modal-lg" style="maxWidth: 100% !important; height: 100% !important;">
        <x-slot:body>
            <div class="p-1">
            <form wire:submit.prevent="editarDestajo" class="gap-3 d-grid" style="grid-template-columns: 1fr;">
                <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 40vh;">
                    <div class="form-group">
                            <label for="editpresupuesto">Presupuesto</label>
                            <x-input type="numeric" wire:model="editpresupuesto" class="form-control" />
                            @error('editpresupuesto') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group" wire:ignore>
                        <label for="obrasEditarDestajo">Obras</label>
                        <select wire:model="editobraSeleccionada" class="form-control" id="select2ObrasEditarDestajo" style="width: 100%;">
                            <option value="" selected hidden>Seleccione una Obra</option>
                            @foreach ($obrasEditarDestajo as $obra)
                                <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('editobraSeleccionada') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="form-group" wire:ignore>
                        <label for="proveedoresEditarDestajo">Proveedores</label>
                        <select wire:model="editproveedorSeleccionado" class="form-control" id="select2ProveedoresEditarDestajo" style="width: 100%;">
                            <option value="" selected hidden>Seleccione un Proveedor</option>
                            @foreach ($proveedoresEditarDestajo as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('editproveedorSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class=" form-group d-flex flex-column" wire:ignore>
                        <label for="serviciosEditarDestajo">Servicios</label>
                        <select wire:model="editservicios" class="form-control" id="select2ServiciosEditarDestajo">
                            <option value="" selected hidden>Seleccione un servicio</option>
                            @foreach ($serviciosEditarDestajo as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('editservicios') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="mb-3 form-group col-md-6">
                        <label for="editservicios">Lista</label>
                        <ul class="overflow-auto list-group" style="max-height: 200px;">
                            @foreach ($editselectedServicios as $servicio)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>{{ $servicio->nombre }}</div>
                                    <i class="cursor-pointer text-danger fa-solid fa-trash" wire:click='editeliminarServicio({{ $servicio->id }})'></i>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-center">
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

    initializeSelect2();

    // Función para inicializar select2
    function initializeSelect2() {
        $('#select2ObrasEditarDestajo').select2({
            width: '100%',
            placeholder: "Seleccione una Obra",
            allowClear: true
        }).on('change', function(e) {
            var data = $(this).val();
            @this.set('editobraSeleccionada', data);
        });

        $('#select2ProveedoresEditarDestajo').select2({
            width: '100%',
            placeholder: "Seleccione un Proveedor",
            allowClear: true
        }).on('change', function(e) {
            var data = $(this).val();
            @this.set('editproveedorSeleccionado', data);
        });

        $('#select2ServiciosEditarDestajo').select2({
            width: '100%',
            placeholder: "Seleccione una Forma de Pago",
            allowClear: true
        }).on('change', function(e) {
            var data = $(this).val();
            @this.set('editservicioSeleccionado', data);
        });
    }

    // Destruir y reinicializar select2 cuando sea necesario
    function resetSelect2() {
        $('#select2ObrasEditarDestajo').select2('destroy');
        $('#select2ProveedoresEditarDestajo').select2('destroy');
        $('#select2ServiciosEditarDestajo').select2('destroy');
        initializeSelect2();
    }

    // Evento cuando se carga la página
    window.addEventListener('livewire:init', () => {
        initializeSelect2();

        // Evento para recargar todos los select2
        Livewire.on("actualizarDestajo", (data) => {

            // Accede a data[0].unidades
            if (!data[0] || !data[0].obrasEditarDestajo || !Array.isArray(data[0].obrasEditarDestajo)) {
                console.error("No se encontraron obras en los datos recibidos");
                return;
            }

            let select2ObrasEditarDestajo = $('#select2ObrasEditarDestajo');
            select2ObrasEditarDestajo.select2('destroy');
            select2ObrasEditarDestajo.find('option').not(':first').remove();

            // Recorre el array de obras dentro de data[0].obras
            data[0].obrasEditarDestajo.forEach(function(obra) {
                let newOption = new Option(obra.detalle.nombreObra, obra.id, false, false);
                select2ObrasEditarDestajo.append(newOption);
            });

            select2ObrasEditarDestajo.select2({
                placeholder: "Seleccione una Obra",
                allowClear: true
            });
            // Selecciona automáticamente la unidad asociada
            if (data[0].editobraSeleccionada) {
                $('#select2ObrasEditarDestajo').val(data[0].editobraSeleccionada).trigger('change');
            }

            let select2ProveedoresEditarDestajo = $('#select2ProveedoresEditarDestajo');
            select2ProveedoresEditarDestajo.select2('destroy');
            select2ProveedoresEditarDestajo.find('option').not(':first').remove();
            // Recorre el array de obras dentro de data[0].obras
            data[0].proveedoresEditarDestajo.forEach(function(proveedor) {
                let newOption = new Option(proveedor.nombre, proveedor.id, false, false);
                select2ProveedoresEditarDestajo.append(newOption);
            });

            select2ProveedoresEditarDestajo.select2({
                placeholder: "Seleccione un Proveedor",
                allowClear: true
            });
            // Selecciona automáticamente el proveedor asociada
            if (data[0].editproveedorSeleccionado) {
                $('#select2ProveedoresEditarDestajo').val(data[0].editproveedorSeleccionado).trigger('change');
            }

            let select2ServiciosEditarDestajo = $('#select2ServiciosEditarDestajo');
            select2ServiciosEditarDestajo.select2('destroy');
            select2ServiciosEditarDestajo.find('option').not(':first').remove();
            // Recorre el array de FormasPago dentro de data[0].FormasPago
            data[0].serviciosEditarDestajo.forEach(function(servicio) {
                let newOption = new Option(servicio.nombre, servicio.id, false, false);
                select2ServiciosEditarDestajo.append(newOption);
            });

            select2ServiciosEditarDestajo.select2({
                placeholder: "Seleccione un servicio",
                allowClear: true
            });

        });
        // Escucha el evento `resetSelect2` para limpiar y reinicializar los select2
        window.addEventListener('resetSelect2', () => {
            resetSelect2();
        });
    });
</script>
@endpush
