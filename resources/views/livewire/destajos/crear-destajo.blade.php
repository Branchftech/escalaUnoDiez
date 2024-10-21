<div>
    <div>
        <x-button class="btn btn-warning"  style="background-color: #50a803; border-color: #50a803; color:white" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-Destajo'})">
            Agregar Destajo
        </x-button>
    </div>

    <x-modal-default title="Crear Destajo" name="Crear-Destajo" :modal="'showModal'">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="crearDestajo" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 40vh;">
                        <div class="form-group">
                            <label for="presupuesto">Presupuesto</label>
                            <x-input type="numeric" wire:model="presupuesto" class="form-control" />
                            @error('presupuesto') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group" wire:ignore>
                            <label for="obras">Obra</label>
                            <select wire:model="obraSelected" class="form-control" id="select2Obras" style="width: 100%;">
                                <option value="" selected hidden>Seleccione una Obra</option>
                                @foreach ($obras as $obra)
                                    <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('obraSelected') <span class="text-danger">{{ $message }}</span> @enderror

                        <div class="form-group" wire:ignore>
                            <label for="proveedores">Proveedor</label>
                            <select wire:model="proveedorSelected" class="form-control" id="select2Proveedores" style="width: 100%;">
                                <option value="" selected hidden>Seleccione un Proveedor</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('proveedorSelected') <span class="text-danger">{{ $message }}</span> @enderror

                        <div class=" form-group d-flex flex-column" wire:ignore>
                            <label for="servicios">Servicios</label>
                            <select wire:model="servicios" class="form-control" id="select2CrearServicios">
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
        </x-slot:body>
    </x-modal-default>
</div>

@push('scripts')
<script type="module">
    $('#select2Obras').select2({
        width: '100%',
        placeholder: "Seleccione una Obra",
        allowClear: true
    });
    $('#select2Obras').on('change', function(e) {
        var data = $('#select2Obras').select2("val");
        @this.set('obraSelected', data);
    });

    $('#select2Proveedores').select2({
        width: '100%',
        placeholder: "Seleccione un Proveedor",
        allowClear: true
    });
    $('#select2Proveedores').on('change', function(e) {
        var data = $('#select2Proveedores').select2("val");
        @this.set('proveedorSelected', data);
    });

    $('#select2CrearServicios').select2({
        width: '100%',
        placeholder: "Seleccione un Servicio",
        allowClear: true
    });
    $('#select2CrearServicios').on('change', function(e) {
        var data = $('#select2CrearServicios').select2("val");
        @this.set('servicioSeleccionado', data);
    });


    window.addEventListener('livewire:init', () => {
        Livewire.on("resetSelect2", () => {
            $('#select2Obras').val(null).trigger('change');
            $('#select2Proveedores').val(null).trigger('change');
            $('#select2CrearServicios').val(null).trigger('change');
        });
    });
</script>
@endpush
