<div>
    <x-modal-default title="Editar Insumo" name="Editar-Insumo" :modal="'showModal'" class="modal-lg" style="maxWidth: 100% !important; height: 100%; !important">
        <x-slot:body>
            <div class="p-1">
                <form wire:submit.prevent="editarInsumo" class="gap-3 d-grid" style="grid-template-columns: 1fr;">
                    <div class="gap-3 overflow-y-auto d-flex flex-column" style="max-height: 40vh;">
                        <div class="form-group">
                            <label for="costo">Costo</label>
                            <x-input type="numeric" wire:model="costo" class="form-control" />
                            @error('costo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <x-input type="number" wire:model="cantidad" class="form-control" />
                            @error('cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <x-input type="date" wire:model="fecha" class="form-control" />
                            @error('fecha') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group d-flex flex-column" wire:ignore>
                            <label for="obras">Obras</label>
                            <select wire:model="obraSeleccionada" class="form-control" id="select2ObrasEditar">
                                <option value="" selected hidden >Seleccione una Obra</option>
                                @foreach ($obras as $obra)
                                    <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('obraSeleccionada') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class=" form-group d-flex flex-column" wire:ignore >
                            <label for="materiales">Materiales</label>
                            <select wire:model="materialSeleccionado" class="form-control" id="select2materiales" >
                                <option value="" selected hidden>Seleccione un material</option>
                                @foreach ($materiales as $material)
                                    <option value="{{ $material->id }}">{{ $material->nombre }}</option>
                                @endforeach
                            </select>

                        </div>
                        @error('materialSeleccionado') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="mb-3 form-group col-md-6">
                            <label for="materiales">Lista</label>
                            <ul class="overflow-auto list-group" style="max-height: 200px;">
                                @foreach ($selectedMaterialesEditar as $material)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>{{ $material->nombre }}</div>
                                        <i class="cursor-pointer text-danger fa-solid fa-trash" wire:click='eliminarMaterial({{ $material->id }})'></i>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
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
         $('#select2materiales').select2({
                width: '100%',
                placeholder: "Seleccione materiales",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('materialSeleccionado', data); // Corregido para enviar los IDs seleccionados
            });
        document.addEventListener('livewire:init', function () {

            // Re-inicializa select2 cuando se muestra el modal
            Livewire.on('refreshSelect2', () => {
                $('#select2materiales').val(@json($selectedMaterialesEditar)).trigger('change'); // Carga IDs seleccionados
                $('#select2ObrasEditar').val(@json($obraSeleccionada)).trigger('change'); // Carga la obra seleccionada
            });

            // Evento para mostrar el modal y reinicializar select2
            $('#modalEditarInsumo').on('shown.bs.modal', function () {
                initSelect2();
                Livewire.emit('refreshSelect2');
            });
        });
    </script>
@endpush
