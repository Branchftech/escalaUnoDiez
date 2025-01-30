<div>
    <x-modal-default title="Editar Estado: {{ $model->nombre }}" name="Editar-Estado">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarEstado" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <!-- Campo Nombre -->
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <x-input type="text" wire:model="nombre" id="nombre" class="form-control" />
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo Pais -->
                        <div class="form-group">
                            <label for="pais">Pais</label>
                            <select wire:model="idPais" id="pais" class="form-control">
                                <option value="">Seleccione un País</option>
                                @foreach ($paises as $pais)
                                    <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                                @endforeach
                            </select>
                            @error('idPais')
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
