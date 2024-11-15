<div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" x-data="{  openGenerarReporte: true }">
    <div class="">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="mb-0 me-3">Generar Reporte de Egresos</h4>
                <button type="button" style="background-color: #50a803; border-color: #50a803; color: white;" class="btn btn-primary" x-on:click="openGenerarReporte = !openGenerarReporte">
                    <span x-show="!openGenerarReporte"><i class="fas fa-plus"></i></span>
                    <span x-show="openGenerarReporte"><i class="fa-solid fa-minus"></i></span>
                </button>
            </div>
        </div>

        <div x-show="openGenerarReporte" x-cloak>
            <hr>
            <form action="{{ route('generarReporte') }}" method="POST" target="_blank">
                @csrf
                <div class="row">
                    <!-- Columna Obras -->
                    <div class="col-md-2">
                        <div class="form-group" wire:ignore>
                            <label for="obrasReporte">Obras</label>
                            <select wire:model="obraReporteSeleccionado" class="form-control" id="select2ObrasReporte" name="obra_id" style="width: 100%;">
                                <option value="" selected hidden>Seleccione una Obra</option>
                                @foreach ($obras as $obra)
                                    <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('obraReporteSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Columna Proveedores -->
                    <div class="col-md-2">
                        <div class="form-group" wire:ignore>
                            <label for="proveedoresReporte">Proveedores</label>
                            <select wire:model="proveedorReporteSeleccionado" class="form-control" id="select2ProveedoresReporte" name="proveedor_id" style="width: 100%;">
                                <option value="" selected hidden>Seleccione un Proveedor</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('proveedorReporteSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Columna Servicios -->
                    <div class="col-md-3">
                        <div class="form-group" wire:ignore>
                            <label for="serviciosReporte">Servicios</label>
                            <select wire:model="serviciosReporteSeleccionados" class="form-control" multiple id="select2ServiciosReporte" name="servicio_id" style="width: 100%;">
                                <option value="" selected hidden>Seleccione un Servicio</option>
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('serviciosReporteSeleccionados') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!-- Columna Destajos -->
                    <div class="col-md-3">
                        <div class="form-group" wire:ignore>
                            <label for="destajosReporte">Presupuesto</label>
                            <select wire:model="destajoReporteSeleccionado" class="form-control" id="select2DestajosReporte" name="destajo_id" style="width: 100%;">
                                <option value="" selected hidden>Seleccione un Presupuesto</option>
                                @foreach ($destajos as $destajo)
                                    <option value="{{ $destajo->id }}"> {{ $destajo->id . ' - ' . $destajo->obra->detalle->nombreObra . ' - ' . $destajo->proveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('destajoReporteSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Columna Botón -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100" >Generar Reporte</button>
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

            $('#select2ObrasReporte').select2({
                width: '100%',
                placeholder: "Seleccione una Obra",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('obraReporteSeleccionado', data);
            });

            $('#select2ProveedoresReporte').select2({
                width: '100%',
                placeholder: "Seleccione un Proveedor",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('proveedorReporteSeleccionado', data);
            });

            $('#select2DestajosReporte').select2({
                width: '100%',
                placeholder: "Seleccione un Presupuesto",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('destajoReporteSeleccionado', data);
            });

            $('#select2ServiciosReporte').select2({
                width: '100%',
                placeholder: "Seleccione los Servicios",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('serviciosReporteSeleccionados', data);
            });
        }

        Livewire.on("refreshSelect2", () => {
            $('#select2ObrasReporte').val(null).trigger('change');
            $('#select2ProveedoresReporte').val(null).trigger('change');
            $('#select2DestajosReporte').val(null).trigger('change');
            $('#select2ServiciosReporte').val(null).trigger('change');
        });

        document.addEventListener('livewire:init', function () {
            initSelect2();
        });

    </script>
@endpush
