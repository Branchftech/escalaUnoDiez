<div>
    <div>
        <x-button class="btn btn-info" style="background-color: #ffcc00; border-color:#ffcc00; color:rgb(0, 0, 0)" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-Unidad'})">
            Unidades
        </x-button>
    </div>

    <x-modal-default title="Crear/Editar Unidad" name="Crear-Unidad" :modal="'showModal'">
        <x-slot:body>
            <div class="p-4 ">
                <form wire:submit.prevent="crearEditarUnidad" class="gap-3 d-flex flex-column">
                    <div class=" form-group d-flex flex-column" wire:ignore>
                        <label for="unidades">Seleccione la unidad a editar</label>
                        <select wire:model="editarUnidadSelected" class="form-control" id="select2EditarUnidad">
                            <option value=""  >Seleccione una unidad</option>
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('unidades') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="form-group">
                        <label for="nombre">Nuevo Nombre</label>
                        <x-input type="text" wire:model="nombre" class="form-control" />
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

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
@push('scripts')
    <script type="module">
            $('#select2EditarUnidad').select2();
            $('#select2EditarUnidad').on('change', function(e) {
                var data = $('#select2EditarUnidad').select2("val");
                @this.set('editarUnidadSelected', data);
            });

    </script>
@endpush
