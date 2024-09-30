<div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" x-data="{ open: false }">
    <div class="">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="mb-0 me-3">Crear Destajo</h4>
                <button type="button" style="background-color: #50a803; border-color: #50a803; color: white;" class="btn btn-primary" x-on:click="open = !open">
                    <span x-show="!open"><i class="fas fa-plus"></i></span>
                    <span x-show="open"><i class="fa-solid fa-minus"></i></span>
                </button>
            </div>
        </div>

        <div x-show="open" x-cloak>
            <hr>
            <form wire:submit.prevent="crearDestajo" class="row g-4">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="presupuesto">Presupuesto</label>
                        <x-input type="number" wire:model="presupuesto" class="form-control" />
                        @error('presupuesto') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
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
                </div>
                <div class="col-md-3">
                    <div class="form-group" wire:ignore>
                        <label for="clientes">Cliente</label>
                        <select wire:model="clienteSelected" class="form-control" id="select2Clientes" style="width: 100%;">
                            <option value="" selected hidden>Seleccione un Cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('clienteSelected') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-group" wire:ignore>
                        <label for="servicios">Servicio</label>
                        <select wire:model="servicioSelected" class="form-control" id="select2Servicios" style="width: 100%;">
                            <option value="" selected hidden>Seleccione un Servicio</option>
                            @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('servicioSelected') <span class="text-danger">{{ $message }}</span> @enderror
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
    $('#select2Obras').select2({
        width: '100%',
        placeholder: "Seleccione una Obra",
        allowClear: true
    });
    $('#select2Obras').on('change', function(e) {
        var data = $('#select2Obras').select2("val");
        @this.set('obraSelected', data);
    });

    $('#select2Clientes').select2({
        width: '100%',
        placeholder: "Seleccione un Cliente",
        allowClear: true
    });
    $('#select2Clientes').on('change', function(e) {
        var data = $('#select2Clientes').select2("val");
        @this.set('clienteSelected', data);
    });

    $('#select2Servicios').select2({
        width: '100%',
        placeholder: "Seleccione un Servicio",
        allowClear: true
    });
    $('#select2Servicios').on('change', function(e) {
        var data = $('#select2Servicios').select2("val");
        @this.set('servicioSelected', data);
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
