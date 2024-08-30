<div>
    <div>
        <x-button class="btn btn-info" style="background-color: #ff6600; border-color: #ff6600; color: rgb(0, 0, 0)" x-data x-on:click="$dispatch('open-modal', {name: 'Crear-Material'})">
            Materiales
        </x-button>
    </div>

    <x-modal-default title="Crear/Editar Material" name="Crear-Material" :modal="'showModal'">
        <x-slot:body>
            <div class="p-4">
                <form wire:submit.prevent="crearMaterial" class="gap-3 d-flex flex-column">
                    <div class="form-group d-flex flex-column" wire:ignore>
                        <label for="materiales">Seleccione un material a editar</label>
                        <select wire:model="editarMaterialSelected" class="form-control" id="select2EditarMaterial">
                            @foreach ($materiales as $material)
                                <option value="{{ $material->id }}">{{ $material->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('editarMaterialSelected') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <x-input type="text" wire:model="nombre" class="form-control" />
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="precioNormal">Precio Normal</label>
                        <x-input type="float" wire:model="precioNormal" class="form-control" />
                        @error('precioNormal') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group d-flex flex-column">
                        <label for="unidades">Unidades</label>
                        <select wire:model="unidadSelected" class="form-control"  aria-placeholder="Seleccione una Unidad">
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('unidadSelected') <span class="text-danger">{{ $message }}</span> @enderror

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
            $('#select2EditarMaterial').select2({
                placeholder: "Seleccione una Unidad",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('editarMaterialSelected', data);
            });

            window.addEventListener('livewire:init', () => {
                Livewire.on("clearSelect2", ()=> {
                    $('#select2EditarMaterial').val(null).trigger('change');
                });
            })
    </script>
@endpush
