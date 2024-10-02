<div>
    <x-modal-default title="Editar Egreso" name="Editar-Egreso" :modal="'showModal'" class="modal-lg" style="maxWidth: 100% !important; height: 100% !important;">
        <x-slot:body>
            <div class="p-4">
                <form wire:submit.prevent="editarEgreso" class="gap-3 d-grid" style="grid-template-columns: 1fr;">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <x-input type="number" wire:model="cantidad" class="form-control" />
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
                        <div class="form-group d-flex flex-column" >
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
                        <div class="form-group d-flex flex-column">
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
                        <div class="form-group d-flex flex-column" >
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
                        <div class="form-group d-flex flex-column" >
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

        $('#select2ServiciosEditar').select2({
            width: '100%',
            placeholder: "Seleccione un Servicio",
            allowClear: true
        }).on('change', function(e) {
            var data = $(this).val();
            @this.set('servicioSeleccionado', data);
        });

        document.addEventListener('livewire:init', function () {
            Livewire.on('refreshSelect2', () => {
                $('#select2ObrasEditar').val(@json($obraSeleccionada)).trigger('change');
                $('#select2ProveedoresEditar').val(@json($proveedorSeleccionado)).trigger('change');
                $('#select2FormasPagoEditar').val(@json($formaPagoSeleccionada)).trigger('change');
                $('#select2BancosEditar').val(@json($bancoSeleccionado)).trigger('change');
                $('#select2ServiciosEditar').val(@json($selectedServiciosEditar)).trigger('change');
            });

            $('#modalEditarEgreso').on('shown.bs.modal', function () {
                initSelect2();
                Livewire.emit('refreshSelect2');
            });
        });
    </script>
@endpush
