<div>
    <x-modal-default title="Editar Permiso: {{ $model->name }}" name="Editar-Permiso">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarPermiso({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="gap-2 d-flex flex-column form-group col-md-6">
                            <label for="name">Nombre</label>
                            <x-input type="text" wire:model="name" id="name" class="form-control" />
                            @error('name')
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
