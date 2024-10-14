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
                            <option value="" selected hidden></option>
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
                    <div class="form-group d-flex flex-column" wire:ignore>
                        <label for="unidades">Unidades</label>
                        <select wire:model="unidadSelected" class="form-control"  aria-placeholder="Seleccione una Unidad" id="select2EditarUnidadMaterial">
                            <option value="" selected hidden >Seleccione una Unidad</option>
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
        initializeSelect2();

        // Función para inicializar select2
        function initializeSelect2() {
            $('#select2EditarMaterial').select2({
                placeholder: "Seleccione un Material",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('editarMaterialSelected', data);
            });

            $('#select2EditarUnidadMaterial').select2({
                placeholder: "Seleccione una Unidad",
                allowClear: true
            }).on('change', function(e) {
                var data = $(this).val();
                @this.set('unidadSelected', data);
            });
        }

        // Destruir y reinicializar select2 cuando sea necesario
        function resetSelect2() {
            $('#select2EditarMaterial').select2('destroy');
            $('#select2EditarUnidadMaterial').select2('destroy');
            initializeSelect2();
        }

        // Evento cuando se carga la página
        window.addEventListener('livewire:init', () => {
            initializeSelect2();

            // Evento para recargar los materiales
            Livewire.on("actualizarMateriales", (data) => {
                if (data[0] && data[0]['materiales'] && Array.isArray(data[0]['materiales'])) {
                    let select2Material = $('#select2EditarMaterial');
                    select2Material.select2('destroy');
                    select2Material.find('option').not(':first').remove();

                    data[0]['materiales'].forEach(function(material) {
                        let newOption = new Option(material.nombre, material.id, false, false);
                        select2Material.append(newOption);
                    });

                    select2Material.select2({
                        placeholder: "Seleccione un Material",
                        allowClear: true
                    });
                } else {
                    console.error("Materiales no encontrados o no son un array");
                }
            });

            // Evento para recargar las unidades cuando se selecciona un material
            Livewire.on("actualizarUnidadesMaterial", (data) => {

                // Accede a data[0].unidades
                if (!data[0] || !data[0].unidades || !Array.isArray(data[0].unidades)) {
                    console.error("No se encontraron unidades en los datos recibidos");
                    return;
                }

                let select2Unidad = $('#select2EditarUnidadMaterial');
                select2Unidad.select2('destroy');
                select2Unidad.find('option').not(':first').remove();

                // Recorre el array de unidades dentro de data[0].unidades
                data[0].unidades.forEach(function(unidad) {
                    let newOption = new Option(unidad.nombre, unidad.id, false, false);
                    select2Unidad.append(newOption);
                });

                select2Unidad.select2({
                    placeholder: "Seleccione una Unidad",
                    allowClear: true
                });
                 // Selecciona automáticamente la unidad asociada
                 if (data[0].unidadSeleccionada) {
                    $('#select2EditarUnidadMaterial').val(data[0].unidadSeleccionada).trigger('change');
                }
            });
            // Escucha el evento `resetSelect2` para limpiar y reinicializar los select2
            window.addEventListener('resetSelect2', () => {
                resetSelect2();
            });
        });
    </script>
@endpush
