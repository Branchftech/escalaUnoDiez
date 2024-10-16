<div>
    <x-modal-default title="Editar Banco: {{ $model->nombre }}" name="Editar-Banco">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarBanco({{ $model->id }})" class="gap-3 d-flex flex-column">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 30vh;">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <x-input type="text" wire:model="nombre" id="nombre" class="form-control" />
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div >
                        <div class="form-group">
                            <label for="activo">Estado</label>
                            <select id="activo" wire:model="activo" class="form-control">
                                <option value="" selected hidden >Seleccione una Estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                            @error('activo') <span class="text-danger">{{ $message }}</span> @enderror
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
