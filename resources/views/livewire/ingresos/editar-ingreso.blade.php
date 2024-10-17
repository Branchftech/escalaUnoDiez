<div>
    <x-modal-default title="Editar Ingreso" name="Editar-Ingreso" :modal="'showModal'" class="modal-lg" style="maxWidth: 100% !important; height: 100% !important;">
        <x-slot:body>
            <div class="p-1">
            <form wire:submit.prevent="editarIngreso" class="gap-3 d-grid" style="grid-template-columns: 1fr;">
                <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 40vh;">
                    <div class="form-group">
                            <label for="factura">Factura</label>
                            <x-input type="text" wire:model="factura" class="form-control" />
                            @error('factura') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <x-input type="number" wire:model="cantidad" class="form-control" />
                        @error('cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="concepto">Concepto</label>
                        <x-input type="text" wire:model="concepto" class="form-control" />
                        @error('concepto') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <x-input type="date" wire:model="fecha" class="form-control" />
                        @error('fecha') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <div class="form-group" wire:ignore>
                            <label for="obrasEditarIngreso">Obras</label>
                            <select wire:model="obraSeleccionada" class="form-control" id="select2ObrasEditarIngreso" style="width: 100%;">
                                <option value="" selected hidden>Seleccione una Obra</option>
                                @foreach ($obrasEditarIngreso as $obra)
                                    <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('obraSeleccionada') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <div class="form-group" wire:ignore>
                            <label for="clientesEditarIngreso">Clientes</label>
                            <select wire:model="clienteSeleccionado" class="form-control" id="select2ClientesEditarIngreso" style="width: 100%;">
                                <option value="" selected hidden>Seleccione un Cliente</option>
                                @foreach ($clientesEditarIngreso as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('clienteSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <div class="form-group" wire:ignore>
                            <label for="formasPagoEditarIngreso">Forma de Pago</label>
                            <select wire:model="formaPagoSeleccionada" class="form-control" id="select2FormasPagoEditarIngreso" style="width: 100%;">
                                <option value="" selected hidden>Seleccione una Forma de Pago</option>
                                @foreach ($formasPagoEditarIngreso as $formaPago)
                                    <option value="{{ $formaPago->id }}">{{ $formaPago->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('formaPagoSeleccionada') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <div class="form-group" wire:ignore>
                            <label for="bancosEditarIngreso">Bancos</label>
                            <select wire:model="bancoSeleccionado" class="form-control" id="select2BancosEditarIngreso" style="width: 100%;">
                                <option value="" selected hidden>Seleccione un Banco</option>
                                @foreach ($bancosEditarIngreso as $banco)
                                    <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('bancoSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
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
        $('#select2ObrasEditarIngreso').select2({
            width: '100%',
            placeholder: "Seleccione una Obra",
            allowClear: true
        }).on('change', function(e) {
            var data = $(this).val();
            @this.set('obraSeleccionada', data);
        });

        $('#select2ClientesEditarIngreso').select2({
            width: '100%',
            placeholder: "Seleccione un Cliente",
            allowClear: true
        }).on('change', function(e) {
            var data = $(this).val();
            @this.set('clienteSeleccionado', data);
        });

        $('#select2FormasPagoEditarIngreso').select2({
            width: '100%',
            placeholder: "Seleccione una Forma de Pago",
            allowClear: true
        }).on('change', function(e) {
            var data = $(this).val();
            @this.set('formaPagoSeleccionada', data);
        });

        $('#select2BancosEditarIngreso').select2({
            width: '100%',
            placeholder: "Seleccione un Banco",
            allowClear: true
        }).on('change', function(e) {
            var data = $(this).val();
            @this.set('bancoSeleccionado', data);
        });
    }

    // Destruir y reinicializar select2 cuando sea necesario
    function resetSelect2() {
        $('#select2ObrasEditarIngreso').select2('destroy');
        $('#select2ClientesEditarIngreso').select2('destroy');
        $('#select2FormasPagoEditarIngreso').select2('destroy');
        $('#select2BancosEditarIngreso').select2('destroy');
        initializeSelect2();
    }
    // Esperar a que Livewire termine de procesar el mensaje
    document.addEventListener('livewire:load', function () {
        initializeSelect2();
    });
    // Evento cuando se carga la página
    window.addEventListener('livewire:init', () => {
        initializeSelect2();


    });
    // Evento para recargar los datos de ingresos todos los select2
    Livewire.on("actualizarIngreso", (data) => {

            // Accede a data[0].unidades
            if (!data[0] || !data[0].obrasEditarIngreso || !Array.isArray(data[0].obrasEditarIngreso)) {
                console.error("No se encontraron obras en los datos recibidos");
                return;
            }
            let select2ObrasEditarIngreso = $('#select2ObrasEditarIngreso');
            select2ObrasEditarIngreso.select2('destroy');
            select2ObrasEditarIngreso.find('option').not(':first').remove();

            // Recorre el array de obras dentro de data[0].obras
            data[0].obrasEditarIngreso.forEach(function(obra) {
                let newOption = new Option(obra.detalle.nombreObra, obra.id, false, false);
                select2ObrasEditarIngreso.append(newOption);
            });

            select2ObrasEditarIngreso.select2({
                placeholder: "Seleccione una Obra",
                allowClear: true
            });
                // Selecciona automáticamente la unidad asociada
                if (data[0].obraSeleccionada) {
                $('#select2ObrasEditarIngreso').val(data[0].obraSeleccionada).trigger('change');
            }

            let select2ClientesEditarIngreso = $('#select2ClientesEditarIngreso');
            select2ClientesEditarIngreso.select2('destroy');
            select2ClientesEditarIngreso.find('option').not(':first').remove();
            // Recorre el array de clientes dentro de data[0].clientes
            data[0].clientesEditarIngreso.forEach(function(cliente) {
                let newOption = new Option(cliente.nombre, cliente.id, false, false);
                select2ClientesEditarIngreso.append(newOption);
            });

            select2ClientesEditarIngreso.select2({
                placeholder: "Seleccione un Cliente",
                allowClear: true
            });
                // Selecciona automáticamente el cliente asociada
                if (data[0].clienteSeleccionado) {
                $('#select2ClientesEditarIngreso').val(data[0].clienteSeleccionado).trigger('change');
            }

            let select2FormasPagoEditarIngresoEditar = $('#select2FormasPagoEditarIngreso');
            select2FormasPagoEditarIngresoEditar.select2('destroy');
            select2FormasPagoEditarIngresoEditar.find('option').not(':first').remove();
            // Recorre el array de FormasPago dentro de data[0].FormasPago
            data[0].formasPagoEditarIngreso.forEach(function(formaPago) {
                let newOption = new Option(formaPago.nombre, formaPago.id, false, false);
                select2FormasPagoEditarIngresoEditar.append(newOption);
            });

            select2FormasPagoEditarIngresoEditar.select2({
                placeholder: "Seleccione una formas de pago",
                allowClear: true
            });
                // Selecciona automáticamente la formasPago asociada
                if (data[0].formaPagoSeleccionada) {
                $('#select2FormasPagoEditarIngreso').val(data[0].formaPagoSeleccionada).trigger('change');
            }

            let select2BancosEditarIngresoEditar = $('#select2BancosEditarIngreso');
            select2BancosEditarIngresoEditar.select2('destroy');
            select2BancosEditarIngresoEditar.find('option').not(':first').remove();
            // Recorre el array de bancos dentro de data[0].bancos
            data[0].bancosEditarIngreso.forEach(function(banco) {
                let newOption = new Option(banco.nombre, banco.id, false, false);
                select2BancosEditarIngresoEditar.append(newOption);
            });

            select2BancosEditarIngresoEditar.select2({
                placeholder: "Seleccione un Banco",
                allowClear: true
            });
                // Selecciona automáticamente el bancoSeleccionado asociada
                if (data[0].bancoSeleccionado) {
                $('#select2BancosEditarIngreso').val(data[0].bancoSeleccionado).trigger('change');
            }

        });
        // Escucha el evento `resetSelect2` para limpiar y reinicializar los select2
        window.addEventListener('resetSelect2', () => {
            resetSelect2();
        });
</script>
@endpush
