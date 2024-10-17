<div>
    <x-modal-default title="Editar Servicio: {{ $model->nombre }}" name="Editar-Servicio">
        <x-slot:body>
            <div class="p-4">
                <form wire:submit.prevent="editarServicio({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="gap-2 d-flex flex-column form-group">
                            <label for="nombre">Nombre</label>
                            <x-input type="text" wire:model="nombre" id="nombre" class="form-control" />

                            @error('nombre')
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
