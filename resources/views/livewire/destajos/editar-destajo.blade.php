<div>
    <x-modal-default title="Editar Destajo" name="Editar-Destajo" :modal="'showModal'" class="modal-lg" style="maxWidth: 100% !important; height: 100% !important;">
        <x-slot:body>
            <div class="p-4">
            <form wire:submit.prevent="editarDestajo" class="gap-3 d-grid" style="grid-template-columns: 1fr;">
                <div class="form-group">
                        <label for="editpresupuesto">Presupuesto</label>
                        <x-input type="number" wire:model="editpresupuesto" class="form-control" />
                        @error('editpresupuesto') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" wire:ignore>
                    <label for="editobras">Obras</label>
                    <select wire:model="editobraSeleccionada" class="form-control" id="" style="width: 100%;">
                        <option value="" selected hidden>Seleccione una Obra</option>
                        @foreach ($editobras as $obra)
                            <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                        @endforeach
                    </select>
                </div>
                @error('editobraSeleccionada') <span class="text-danger">{{ $message }}</span> @enderror

                <div class="form-group" wire:ignore>
                    <label for="editproveedor">Proveedores</label>
                    <select wire:model="editproveedorSeleccionado" class="form-control" id="" style="width: 100%;">
                        <option value="" selected hidden>Seleccione un Proveedor</option>
                        @foreach ($editproveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                @error('editproveedorSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror

                <div class=" form-group d-flex flex-column" wire:ignore>
                    <label for="editservicios">Servicios</label>
                    <select wire:model="editservicios" class="form-control" id="select2EditServicios">
                        <option value="" selected hidden>Seleccione un servicio</option>
                        @foreach ($editservicios as $servicio)
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
    $('#select2editObras').select2({
        width: '100%',
        placeholder: "Seleccione una Obra",
        allowClear: true
    });
    $('#select2editObras').on('change', function(e) {
        var data = $('#select2editObras').select2("val");
        @this.set('editobraSeleccionada', data);
    });

    $('#select2editProveedores').select2({
        width: '100%',
        placeholder: "Seleccione un Proveedores",
        allowClear: true
    });
    $('#select2editProveedores').on('change', function(e) {
        var data = $('#select2editProveedores').select2("val");
        @this.set('editproveedorSeleccionado', data);
    });

    $('#select2EditServicios').select2({
        width: '100%',
        placeholder: "Seleccione un Servicio",
        allowClear: true
    });
    $('#select2EditServicios').on('change', function(e) {
        var data = $('#select2EditServicios').select2("val");
        @this.set('editservicioSeleccionado', data);
    });

    window.addEventListener('livewire:init', () => {
        Livewire.on("clearSelect2", () => {
            $('#select2editObras').val(null).trigger('change');
            $('#select2editProveedores').val(null).trigger('change');
            $('#select2EditServicios').val(null).trigger('change');
        });
    });
</script>
@endpush
