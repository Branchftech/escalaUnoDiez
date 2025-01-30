<div>
    <x-modal-default title="Editar Ciudad: {{ $model->nombre }}" name="Editar-Ciudad">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarCiudad" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <!-- Campo Nombre -->
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <x-input type="text" wire:model="nombre" id="nombre" class="form-control" />
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo Estado -->
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select wire:model="idEstado" id="estado" class="form-control">
                                <option value="">Seleccione un Estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                            @error('idEstado')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="gap-3 d-flex justify-content-end">
                        <x-button type="submit" class="btn btn-primary">
                            Guardar
                        </x-button>
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
