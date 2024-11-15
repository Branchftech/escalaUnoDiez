<div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" x-data="{ openCrearEgreso: false }">
    <!-- Sección de Crear Egreso -->
    <div class="">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="mb-0 me-3">Crear Egreso</h4>
                <button type="button" style="background-color: #50a803; border-color: #50a803; color: white;" class="btn btn-primary" x-on:click="openCrearEgreso = !openCrearEgreso">
                    <span x-show="!openCrearEgreso"><i class="fas fa-plus"></i></span>
                    <span x-show="openCrearEgreso"><i class="fa-solid fa-minus"></i></span>
                </button>
            </div>
        </div>

        <div x-show="openCrearEgreso" x-cloak>
            <hr>
            <form wire:submit.prevent="crearEgreso" class="row g-3">

                    <!-- Campos del formulario de Crear Egreso -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-right: none; background-color: transparent;">$</span>
                                <x-input type="numeric" wire:model="cantidad" class="form-control" style="border-left: none;" />
                            </div>
                            @error('cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="concepto">Concepto</label>
                            <x-input type="text" wire:model="concepto" class="form-control" />
                            @error('concepto') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <x-input type="date" wire:model="fecha" class="form-control" />
                            @error('fecha') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" wire:ignore>
                            <label for="obras">Obras</label>
                            <select wire:model="obraSelected" class="form-control" id="select2Obras" style="width: 100%;">
                                <option value="" selected hidden>Seleccione una Obra</option>
                                @foreach ($obras as $obra)
                                    <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('obraSelected') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" wire:ignore>
                            <label for="proveedores">Proveedores</label>
                            <select wire:model="proveedorSelected" class="form-control" id="select2Proveedores" style="width: 100%;">
                                <option value="" selected hidden>Seleccione un Proveedor</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('proveedorSelected') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" wire:ignore>
                            <label for="formasPago">Forma de Pago</label>
                            <select wire:model="formaPagoSelected" class="form-control" id="select2FormasPago" style="width: 100%;">
                                <option value="" selected hidden>Seleccione una Forma de Pago</option>
                                @foreach ($formasPago as $formaPago)
                                    <option value="{{ $formaPago->id }}">{{ $formaPago->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('formaPagoSelected') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" wire:ignore>
                            <label for="bancos">Bancos</label>
                            <select wire:model="bancoSelected" class="form-control" id="select2Bancos" style="width: 100%;">
                                <option value="" selected hidden>Seleccione un Banco</option>
                                @foreach ($bancos as $banco)
                                    <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('bancoSelected') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" wire:ignore>
                            <label for="destajos">Presupuestos</label>
                            <select wire:model="destajoSelected" class="form-control" id="select2Destajos" style="width: 100%;">
                                <option value="" selected hidden>Seleccione un Presupuesto</option>
                                @foreach ($destajos as $destajo)
                                    <option value="{{ $destajo->id }}">  {{ $destajo->id . ' - ' . $destajo->obra->detalle->nombreObra . ' - ' . $destajo->proveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('destajoSelected') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" wire:ignore>
                            <label for="servicios">Servicios</label>
                            <select wire:model="serviciosSeleccionados" multiple class="form-control" id="select2Servicios" style="width: 100%;">
                                <option value="" selected hidden>Seleccione los Servicios</option>
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('serviciosSeleccionados') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                <div class="col-md-12">
                    <div class="gap-2 mt-3 d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" wire:click="limpiar">
                            Limpiar
                        </button>
                        <x-button type="submit" class="btn btn-primary">
                            Guardar
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        // Inicializamos Select2 cuando la página carga por primera vez
        initSelect2();
            function initSelect2() {
            $('#select2Obras').select2({
                width: '100%',
                placeholder: "Seleccione una Obra",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('obraSelected', data);
            });

            $('#select2Proveedores').select2({
                width: '100%',
                placeholder: "Seleccione un Proveedor",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('proveedorSelected', data);
            });

            $('#select2FormasPago').select2({
                width: '100%',
                placeholder: "Seleccione una Forma de Pago",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('formaPagoSelected', data);
            });

            $('#select2Bancos').select2({
                width: '100%',
                placeholder: "Seleccione un Banco",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('bancoSelected', data);
            });

            $('#select2Destajos').select2({
                width: '100%',
                placeholder: "Seleccione un Presupuesto",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('destajoSelected', data);
            });

            $('#select2Servicios').select2({
                width: '100%',
                placeholder: "Seleccione los Servicios",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('serviciosSeleccionados', data);
            });

        }

        Livewire.on("refreshSelect2", () => {
            $('#select2Obras').val(null).trigger('change');
            $('#select2Proveedores').val(null).trigger('change');
            $('#select2FormasPago').val(null).trigger('change');
            $('#select2Bancos').val(null).trigger('change');
            $('#select2Servicios').val(null).trigger('change');
            $('#select2Destajos').val(null).trigger('change');
        });

        document.addEventListener('livewire:init', function () {
            initSelect2();
        });


    </script>
@endpush
