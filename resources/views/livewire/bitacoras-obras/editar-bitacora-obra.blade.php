<div>
    <x-modal-default title="Editar Bitacora número: {{ $model->id }}" name="Editar-BitacoraObra">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarBitacoraObra({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="gap-2 d-flex flex-column form-group">
                            <label for="descripcion">Desripción</label>
                            <textarea wire:model="descripcion" id="descripcion"  class="form-control" rows="5"></textarea>
                            @error('descripcion')
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
