
<div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" x-data="{ open: false }">
    <div class="">
        <div class="mb-3 d-flex align-items-center">
            <h4 class="mb-0">Detalle Obra</h4>
            <button type="button" style="background-color: #50a803; border-color: #50a803; color:white" class="btn btn-primary ms-3" x-on:click="open = !open">
                <span x-show="!open"> <i class="fas fa-edit"></i></span>
                <span x-show="open"><i class="fa-solid fa-xmark"></i></span>
            </button>
        </div>
        <div x-show="open" x-cloak>
            <hr>
            <form wire:submit.prevent="editarDetalleObra" class="row g-3">

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
                        <option value="" selected hidden >Seleccione el estado</option>
                        @foreach ($estadosObra as $estadoObra)
                            <option value="{{ $estadoObra->id }}">{{ $estadoObra->nombre }}</option>
                        @endforeach
                    </select>
                    @error('estadoObraSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="total">Presupuesto</label>
                        <x-input type="numeric" wire:model="total" class="form-control" />
                        @error('total') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="moneda">Moneda</label>
                        <select wire:model="moneda" class="form-control" style="width: 100%;">
                            <option value="" selected hidden >Seleccione una Moneda</option>
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
                    <label for="paises">País</label>
                    <select wire:model="paisSeleccionado" wire:change="cambiar" class="form-control" id="select2Paises">
                        <option value="" selected hidden >Seleccione un Pais</option>
                        @foreach ($paises as $pais)
                            <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                        @endforeach
                    </select>
                    @error('paisSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <!-- Campo Estado -->
                <div class="col-md-3">
                    <label for="estados">Estado</label>
                    <select wire:model="estadoSeleccionado" class="form-control" id="select2Estados">
                        <option value="" selected hidden >Seleccione un Estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                        @endforeach
                    </select>
                    @error('estadoSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <!-- Botones -->
                <div class="col-md-12">
                    <div class="gap-2 mt-3 d-flex justify-content-center">
                        <x-button type="submit" class="btn btn-primary">
                            Editar
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


