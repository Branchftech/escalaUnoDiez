<div>
    <div style="display: flex; justify-content: end; align-items: end; padding-bottom: 1rem;">
        <x-button class="btn btn-warning" style="background-color: #50a803; border-color: #50a803; color:white" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-DocumentoObra'})">
            Cargar Documento
        </x-button>
    </div>

    <x-modal-default title="Crear Documento" name="Crear-DocumentoObra" :modal="'showModal'">
        <x-slot:body>
            <div class="p-4 ">
                <form wire:submit.prevent="crearDocumentoObra" class="gap-3 d-flex flex-column">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <x-input type="text" wire:model="nombre" class="form-control" />
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <input type="file" wire:model="documento" class="form-control" />
                        @error('documento') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class=" form-group d-flex flex-column" wire:ignore>
                        <label for="tiposDocumento">Tipo Documento</label>
                        <select wire:model="tipoDocumentoSeleccionado" class="form-control" id="select2tiposDocumento">
                            <option value="">Seleccione un Tipo de Documento</option>
                            @foreach ($tiposDocumento as $tipoDocumento)
                                <option value="{{ $tipoDocumento->id }}">{{ $tipoDocumento->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('documento') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="gap-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" wire:click="limpiar">
                            Limpiar
                        </button>

                        <x-button type="submit" class="btn btn-primary">
                            Guardar
                        </x-button>
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
