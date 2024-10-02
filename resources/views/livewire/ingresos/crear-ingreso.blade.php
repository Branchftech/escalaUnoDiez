<div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" x-data="{ open: false }">
    <div class="">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="mb-0 me-3">Crear Ingreso</h4>
                <button type="button" style="background-color: #50a803; border-color: #50a803; color: white;" class="btn btn-primary" x-on:click="open = !open">
                    <span x-show="!open"><i class="fas fa-plus"></i></span>
                    <span x-show="open"><i class="fa-solid fa-minus"></i></span>
                </button>
            </div>
        </div>

        <div x-show="open" x-cloak>
            <hr>
            <form wire:submit.prevent="crearIngreso" x-on:submit="open = false" class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="factura">Factura</label>
                        <x-input type="text" wire:model="factura" class="form-control" />
                        @error('factura') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <x-input type="number" wire:model="cantidad" class="form-control" />
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
                <div class="col-md-4">
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
                        <label for="bancos">Banco</label>
                        <select wire:model="bancoSelected" class="form-control" id="select2Bancos" style="width: 100%;">
                            <option value="" selected hidden>Seleccione un Banco</option>
                            @foreach ($bancos as $banco)
                                <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('bancoSelected') <span class="text-danger">{{ $message }}</span> @enderror
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

    $('#select2FormasPago').select2({
        width: '100%',
        placeholder: "Seleccione una Forma de Pago",
        allowClear: true
    });
    $('#select2FormasPago').on('change', function(e) {
        var data = $('#select2FormasPago').select2("val");
        @this.set('formaPagoSelected', data);
    });

    $('#select2Bancos').select2({
        width: '100%',
        placeholder: "Seleccione un Banco",
        allowClear: true
    });
    $('#select2Bancos').on('change', function(e) {
        var data = $('#select2Bancos').select2("val");
        @this.set('bancoSelected', data);
    });

    window.addEventListener('livewire:init', () => {
        Livewire.on("clearSelect2", () => {
            $('#select2Obras').val(null).trigger('change');
            $('#select2Clientes').val(null).trigger('change');
            $('#select2FormasPago').val(null).trigger('change');
            $('#select2Bancos').val(null).trigger('change');
        });
    });
</script>
@endpush
