<div>
    <x-modal-default title="Editar Ingreso" name="Editar-Ingreso" :modal="'showModal'" class="modal-lg" style="maxWidth: 100% !important; height: 100% !important;">
        <x-slot:body>
            <div class="p-4">
            <form wire:submit.prevent="editarIngreso" class="gap-3 d-grid" style="grid-template-columns: 1fr;">
                <div class="form-group">
                        <label for="factura">Factura</label>
                        <x-input type="text" wire:model="factura" class="form-control" />
                        @error('factura') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <x-input type="number" wire:model="cantidad" class="form-control" />
                        @error('cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="concepto">Concepto</label>
                        <x-input type="text" wire:model="concepto" class="form-control" />
                        @error('concepto') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <x-input type="date" wire:model="fecha" class="form-control" />
                        @error('fecha') <span class="text-danger">{{ $message }}</span> @enderror
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
                        <label for="formasPago">Forma de Pago</label>
                        <select wire:model="formaPagoSeleccionada" class="form-control" id="select2FormasPago" style="width: 100%;">
                            <option value="" selected hidden>Seleccione una Forma de Pago</option>
                            @foreach ($formasPago as $formaPago)
                                <option value="{{ $formaPago->id }}">{{ $formaPago->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('formaPagoSeleccionada') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="form-group" wire:ignore>
                        <label for="bancos">Bancos</label>
                        <select wire:model="bancoSeleccionado" class="form-control" id="select2Bancos" style="width: 100%;">
                            <option value="" selected hidden>Seleccione un Banco</option>
                            @foreach ($bancos as $banco)
                                <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('bancoSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
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

    $('#select2FormasPago').select2({
        width: '100%',
        placeholder: "Seleccione una Forma de Pago",
        allowClear: true
    });
    $('#select2FormasPago').on('change', function(e) {
        var data = $('#select2FormasPago').select2("val");
        @this.set('formaPagoSeleccionada', data);
    });

    $('#select2Bancos').select2({
        width: '100%',
        placeholder: "Seleccione un Banco",
        allowClear: true
    });
    $('#select2Bancos').on('change', function(e) {
        var data = $('#select2Bancos').select2("val");
        @this.set('bancoSeleccionado', data);
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
