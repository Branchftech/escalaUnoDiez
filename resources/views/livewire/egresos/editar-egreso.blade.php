<div>
    <x-modal-default title="Editar Egreso" name="Editar-Egreso" :modal="'showModal'" class="modal-lg" style="maxWidth: 100% !important; height: 100% !important;">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarEgreso" class="gap-3 d-grid" style="grid-template-columns: 1fr;">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 40vh;">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-right: none; background-color: transparent;">$</span>
                                <x-input type="numeric" wire:model="cantidad" class="form-control" style="border-left: none;" />
                            </div>
                            @error('cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <x-input type="date" wire:model="fecha" class="form-control" />
                            @error('fecha') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="concepto">Concepto</label>
                            <x-input type="text" wire:model="concepto" class="form-control" />
                            @error('concepto') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <div class="form-group d-flex flex-column"  wire:ignore>
                                <label for="obras">Obras</label>
                                <select wire:model="obraSeleccionada" class="form-control" id="select2ObrasEditar">
                                    <option value=""  hidden>Seleccione una Obra</option>
                                    @foreach ($obras as $obra)
                                        <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('obraSeleccionada') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <div class="form-group d-flex flex-column"  wire:ignore>
                                <label for="proveedores">Proveedores</label>
                                <select wire:model="proveedorSeleccionado" class="form-control" id="select2ProveedoresEditar">
                                    <option value=""  hidden>Seleccione un Proveedor</option>
                                    @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('proveedorSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <div class="form-group d-flex flex-column"  wire:ignore>
                                <label for="formasPago">Formas de Pago</label>
                                <select wire:model="formaPagoSeleccionada" class="form-control" id="select2FormasPagoEditar">
                                    <option value=""  hidden>Seleccione una Forma de Pago</option>
                                    @foreach ($formasPago as $formaPago)
                                        <option value="{{ $formaPago->id }}">{{ $formaPago->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('formaPagoSeleccionada') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <div class="form-group d-flex flex-column"  wire:ignore>
                                <label for="bancos">Bancos</label>
                                <select wire:model="bancoSeleccionado" class="form-control" id="select2BancosEditar">
                                    <option value=""  hidden>Seleccione un Banco</option>
                                    @foreach ($bancos as $banco)
                                        <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('bancoSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <div class="form-group d-flex flex-column"  wire:ignore>
                                <label for="destajos">Destajos</label>
                                <select wire:model="destajoSeleccionado" class="form-control" id="select2DestajosEditar">
                                    <option value=""  hidden>Seleccione un Destajo</option>
                                    @foreach ($destajos as $destajo)
                                        <option value="{{ $destajo->id }}"> {{ $destajo->id . ' - ' . $destajo->obra->detalle->nombreObra . ' - ' . $destajo->proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('destajoSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="form-group d-flex flex-column" wire:ignore>
                                <label for="servicios">Servicios</label>
                                <select wire:model="servicioSeleccionado" class="form-control" id="select2ServiciosEditar">
                                    <option value=""  hidden>Seleccione un Servicio</option>
                                    @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('servicioSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="mb-3 form-group col-md-6">
                            <label for="servicios">Lista de Servicios</label>
                            <ul class="overflow-auto list-group" style="max-height: 200px;">
                                @foreach ($selectedServiciosEditar as $servicio)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>{{ $servicio->nombre }}</div>
                                        <i class="cursor-pointer text-danger fa-solid fa-trash" wire:click='eliminarServicio({{ $servicio->id }})'></i>
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
            $('#select2ObrasEditar').select2({
                width: '100%',
                placeholder: "Seleccione una Obra",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('obraSeleccionada', data);
            });

            $('#select2ProveedoresEditar').select2({
                width: '100%',
                placeholder: "Seleccione un Proveedor",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('proveedorSeleccionado', data);
            });

            $('#select2FormasPagoEditar').select2({
                width: '100%',
                placeholder: "Seleccione una Forma de Pago",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('formaPagoSeleccionada', data);
            });

            $('#select2BancosEditar').select2({
                width: '100%',
                placeholder: "Seleccione un Banco",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('bancoSeleccionado', data);
            });

            $('#select2DestajosEditar').select2({
                width: '100%',
                placeholder: "Seleccione un Destajo",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('destajoSeleccionado', data);
            });

            $('#select2ServiciosEditar').select2({
                width: '100%',
                placeholder: "Seleccione un Servicio",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('servicioSeleccionado', data);
            });
        }

        // Destruir y reinicializar select2 cuando sea necesario
        function resetSelect2() {
            $('#select2ObrasEditar').select2('destroy');
            $('#select2ProveedoresEditar').select2('destroy');
            $('#select2FormasPagoEditar').select2('destroy');
            $('#select2BancosEditar').select2('destroy');
            $('#select2DestajosEditar').select2('destroy');
            $('#select2ServiciosEditar').select2('destroy');
            initializeSelect2();
        }

         // Evento cuando se carga la página
         window.addEventListener('livewire:init', () => {
            initializeSelect2();
        });
        // Evento para recargar todos los select2
        Livewire.on("actualizarEgreso", (data) => {

            // Accede a data[0].unidades
            if (!data[0] || !data[0].obras || !Array.isArray(data[0].obras)) {
                console.error("No se encontraron obras en los datos recibidos");
                return;
            }

            let select2ObrasEditar = $('#select2ObrasEditar');
            select2ObrasEditar.select2('destroy');
            select2ObrasEditar.find('option').not(':first').remove();

            // Recorre el array de obras dentro de data[0].obras
            data[0].obras.forEach(function(obra) {
                let newOption = new Option(obra.detalle.nombreObra, obra.id, false, false);
                select2ObrasEditar.append(newOption);
            });

            select2ObrasEditar.select2({
                placeholder: "Seleccione una Obra",
                allowClear: true
            });
            // Selecciona automáticamente la unidad asociada
            if (data[0].obraSeleccionada) {
                $('#select2ObrasEditar').val(data[0].obraSeleccionada).trigger('change');
            }

            let select2ProveedoresEditar = $('#select2ProveedoresEditar');
            select2ProveedoresEditar.select2('destroy');
            select2ProveedoresEditar.find('option').not(':first').remove();
            // Recorre el array de obras dentro de data[0].obras
            data[0].proveedores.forEach(function(proveedor) {
                let newOption = new Option(proveedor.nombre, proveedor.id, false, false);
                select2ProveedoresEditar.append(newOption);
            });

            select2ProveedoresEditar.select2({
                placeholder: "Seleccione un Proveedor",
                allowClear: true
            });
                // Selecciona automáticamente el proveedor asociada
                if (data[0].proveedorSeleccionado) {
                $('#select2ProveedoresEditar').val(data[0].proveedorSeleccionado).trigger('change');
            }

            let select2FormasPagoEditar = $('#select2FormasPagoEditar');
            select2FormasPagoEditar.select2('destroy');
            select2FormasPagoEditar.find('option').not(':first').remove();
            // Recorre el array de FormasPago dentro de data[0].FormasPago
            data[0].formasPago.forEach(function(formaPago) {
                let newOption = new Option(formaPago.nombre, formaPago.id, false, false);
                select2FormasPagoEditar.append(newOption);
            });

            select2FormasPagoEditar.select2({
                placeholder: "Seleccione una formas de pago",
                allowClear: true
            });
                // Selecciona automáticamente la formasPago asociada
                if (data[0].formaPagoSeleccionada) {
                $('#select2FormasPagoEditar').val(data[0].formaPagoSeleccionada).trigger('change');
            }

            let select2BancosEditar = $('#select2BancosEditar');
            select2BancosEditar.select2('destroy');
            select2BancosEditar.find('option').not(':first').remove();
            // Recorre el array de bancos dentro de data[0].bancos
            data[0].bancos.forEach(function(banco) {
                let newOption = new Option(banco.nombre, banco.id, false, false);
                select2BancosEditar.append(newOption);
            });

            select2BancosEditar.select2({
                placeholder: "Seleccione un Banco",
                allowClear: true
            });
                // Selecciona automáticamente el bancoSeleccionado asociada
                if (data[0].bancoSeleccionado) {
                $('#select2BancosEditar').val(data[0].bancoSeleccionado).trigger('change');
            }

            let select2DestajosEditar = $('#select2DestajosEditar');
            select2DestajosEditar.select2('destroy');
            select2DestajosEditar.find('option').not(':first').remove();
            // Recorre el array de Destajos  dentro de data[0].Destajos
            data[0].destajos.forEach(function(destajo) {
                let newOption = new Option(destajo.id, destajo.id, false, false);
                select2DestajosEditar.append(newOption);
            });

            select2DestajosEditar.select2({
                placeholder: "Seleccione un Destajo",
                allowClear: true
            });
                // Selecciona automáticamente el destajoSeleccionado asociada
                if (data[0].destajoSeleccionado) {
                $('#select2DestajosEditar').val(data[0].destajoSeleccionado).trigger('change');
            }

            let select2ServiciosEditar = $('#select2ServiciosEditar');
            select2ServiciosEditar.select2('destroy');
            select2ServiciosEditar.find('option').not(':first').remove();
            // Recorre el array de Destajos  dentro de data[0].Destajos
            data[0].servicios.forEach(function(servicio) {
                let newOption = new Option(servicio.nombre, servicio.id, false, false);
                select2ServiciosEditar.append(newOption);
            });

            select2ServiciosEditar.select2({
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
