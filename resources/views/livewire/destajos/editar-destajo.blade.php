<div>
    <x-modal-default title="Editar Destajo" name="Editar-Destajo" :modal="'showModal'" class="modal-lg" style="maxWidth: 100% !important; height: 100% !important;">
        <x-slot:body>
            <div class="p-4">
            <form wire:submit.prevent="editarDestajo" class="gap-3 d-grid" style="grid-template-columns: 1fr;">
                <div class="form-group">
                        <label for="presupuesto">Presupuesto</label>
                        <x-input type="number" wire:model="presupuesto" class="form-control" />
                        @error('presupuesto') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" wire:ignore>
                    <label for="obras">Obras</label>
                    <select wire:model="obraSeleccionada" class="form-control" id="select2Obras" style="width: 100%;">
                        <option value="" selected hidden>Seleccione una Obra</option>
                        @foreach ($obras as $obra)
                            <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                        @endforeach
                    </select>
                </div>
                @error('obraSeleccionada') <span class="text-danger">{{ $message }}</span> @enderror

                <div class="form-group" wire:ignore>
                    <label for="clientes">Clientes</label>
                    <select wire:model="clienteSeleccionado" class="form-control" id="select2Clientes" style="width: 100%;">
                        <option value="" selected hidden>Seleccione un Cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                @error('clienteSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror

                <div class="form-group" wire:ignore>
                    <label for="servicios">Servicios</label>
                    <select wire:model="servicioSeleccionado" class="form-control" id="select2Servicios" style="width: 100%;">
                        <option value="" selected hidden>Seleccione un Servicio</option>
                        @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                @error('servicioSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror

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
    $('#select2Obras').select2({
        width: '100%',
        placeholder: "Seleccione una Obra",
        allowClear: true
    });
    $('#select2Obras').on('change', function(e) {
        var data = $('#select2Obras').select2("val");
        @this.set('obraSeleccionada', data);
    });

    $('#select2Clientes').select2({
        width: '100%',
        placeholder: "Seleccione un Cliente",
        allowClear: true
    });
    $('#select2Clientes').on('change', function(e) {
        var data = $('#select2Clientes').select2("val");
        @this.set('clienteSeleccionado', data);
    });

    $('#select2Servicios').select2({
        width: '100%',
        placeholder: "Seleccione un Servicio",
        allowClear: true
    });
    $('#select2Servicios').on('change', function(e) {
        var data = $('#select2Servicios').select2("val");
        @this.set('servicioSeleccionado', data);
    });

    window.addEventListener('livewire:init', () => {
        Livewire.on("clearSelect2", () => {
            $('#select2Obras').val(null).trigger('change');
            $('#select2Clientes').val(null).trigger('change');
            $('#select2Servicios').val(null).trigger('change');
        });
    });
</script>
@endpush
