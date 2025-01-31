
    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"  x-data="{ open: false }">
        <div class="">
            <div class="mb-3 d-flex align-items-center">
                <h4 class="mb-0">Crear Obra</h4>
                <button type="button" style="background-color: #50a803; border-color: #50a803; color:white" class="btn btn-primary ms-3" x-on:click="open = !open">
                    <span x-show="!open"><i class="fa-solid fa-plus"></i></span>
                    <span x-show="open"><i class="fa-solid fa-minus"></i></span>
                </button>
            </div>

            <div x-show="open" x-cloak>
                <hr>
                <form wire:submit.prevent="crearObra" class="row g-3">
                    <!-- Primer fila -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombreObra">Nombre Obra</label>
                            <x-input type="text" wire:model="nombreObra" class="form-control" />
                            @error('nombreObra') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="contrato">Contrato</label>
                            <x-input type="text" wire:model="contrato" class="form-control" />
                            @error('contrato') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="licenciaConstruccion">Licencia Construccion</label>
                            <x-input type="text" wire:model="licenciaConstruccion" class="form-control" />
                            @error('licenciaConstruccion') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fechaInicio">Fecha Inicio</label>
                            <x-input type="date" wire:model="fechaInicio" class="form-control" />
                            @error('fechaInicio') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <!-- Segunda fila -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fechaFin">Fecha Fin</label>
                            <x-input type="date" wire:model="fechaFin" class="form-control" />
                            @error('fechaFin') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="estadosObra">Estado Obra</label>
                        <select wire:model="estadoObraSeleccionado" class="form-control" id="select2EstadosObras">
                            <option value="" selected hidden>Seleccione el Estado de la Obra</option>
                            @foreach ($estadosObra as $estadoObra)
                                <option value="{{ $estadoObra->id }}">{{ $estadoObra->nombre }}</option>
                            @endforeach
                        </select>
                        @error('estadoObraSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="clientes">Cliente</label>
                        <select wire:model="clienteSeleccionado" class="form-control" id="select2EstadosObras">
                            <option value="" selected hidden>Seleccione el Cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                        @error('clienteSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    {{-- <div class="col-md-3">
                        <div  wire:ignore>
                            <label for="proveedores">Proveedores</label>
                            <select wire:model="proveedoresSeleccionados" multiple class="form-control" id="select2proveedores">
                                <option value="" selected hidden>Seleccione los proveedores</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('proveedoresSeleccionados') <span class="text-danger">{{ $message }}</span> @enderror
                    </div> --}}
                    <div class="col-md-3">
                        <div class="form-group" wire:ignore>
                            <label for="proveedores">Proveedores</label>
                            <select wire:model="proveedoresSeleccionados" multiple class="form-control" id="select2proveedores" style="width: 100%;">
                                <option value=""  hidden>Seleccione los proveedores</option>
                                @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                            </select>
                        </div>
                        @error('proveedoresSeleccionados') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="total">Presupuesto</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-right: none; background-color: transparent;">$</span>
                                <x-input type="numeric" wire:model="total" class="form-control" style="border-left: none;" />
                            </div>
                            @error('total') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="moneda">Moneda</label>
                            <select wire:model="moneda" class="form-control" style="width: 100%;">
                                <option value="" selected hidden>Seleccione una moneda</option>
                                <option value="mnx">MNX</option>
                                <option value="dls">DLS</option>
                            </select>
                            @error('moneda') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="calle">Calle</label>
                            <x-input type="text" wire:model="calle" class="form-control" />
                            @error('calle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lote">Lote</label>
                            <x-input type="text" wire:model="lote" class="form-control" />
                            @error('lote') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Tercera fila -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="manzana">Manzana</label>
                            <x-input type="text" wire:model="manzana" class="form-control" />
                            @error('manzana') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="metrosCuadrados">Metros Cuadrados</label>
                            <x-input type="number" wire:model="metrosCuadrados" class="form-control" />
                            @error('metrosCuadrados') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fraccionamiento">Fraccionamiento</label>
                            <x-input type="text" wire:model="fraccionamiento" class="form-control" />
                            @error('fraccionamiento') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="dictamenUsoSuelo">Dictamen Uso Suelo</label>
                            <x-input type="text" wire:model="dictamenUsoSuelo" class="form-control" />
                            @error('dictamenUsoSuelo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div> --}}

                    <!-- Cuarta fila -->
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label for="paises" class="me-2">País</label>
                        </div>
                        <select wire:model="paisSeleccionado" wire:change="cambiar" class="form-control" id="select2Paises">
                            <option value="" selected hidden>Seleccione un país</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                            @endforeach
                        </select>
                        @error('paisSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Estado -->
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label for="estados" class="me-2">Estado</label>

                        </div>
                        <select wire:model="estadoSeleccionado" wire:change="cambiarCiudad" class="form-control" id="select2Estados">
                            <option value="" selected hidden>Seleccione un estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                        @error('estadoSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                     <!-- ciudad -->
                     <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label for="ciudades" class="me-2">Ciudad</label>

                        </div>
                        <select wire:model="ciudadSeleccionado"  class="form-control" id="select2Ciudades">
                            <option value="" selected hidden>Seleccione una ciudad</option>
                            @foreach ($ciudades as $ciudad)
                                <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                            @endforeach
                        </select>
                        @error('ciudadSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!-- Botones -->
                    <div class="col-md-12">
                        <div class="gap-2 mt-3 d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary" wire:click="limpiar">
                                Limpiar
                            </button>
                            <x-button type="submit" class="btn btn-primary">
                                Crear
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script type="module">

            $('#select2proveedores').select2({
                width: '100%',
                placeholder: "",
                allowClear: true
            });
            $('#select2proveedores').on('change', function(e) {
                var data = $('#select2proveedores').select2("val");
                @this.set('proveedoresSeleccionados', data);
            });


    </script>
@endpush
