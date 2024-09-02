<div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" x-data="{ open: false }">
    <div class="">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="mb-0 me-3">Crear Insumo</h4>
                <button type="button" style="background-color: #50a803; border-color: #50a803; color: white;" class="btn btn-primary" x-on:click="open = !open">
                    <span x-show="!open"><i class="fas fa-plus"></i></span>
                    <span x-show="open"><i class="fa-solid fa-minus"></i></span>
                </button>
            </div>
            <div class="d-flex align-items-center">
                <livewire:materiales.crear-material />
                <livewire:unidades.crear-unidad />
            </div>
        </div>

        <div x-show="open" x-cloak>
            <hr>
            <form wire:submit.prevent="crearInsumo" class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="costo">Costo</label>
                        <x-input type="number" wire:model="costo" class="form-control" />
                        @error('costo') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <x-input type="number" wire:model="cantidad" class="form-control" />
                        @error('cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <x-input type="date" wire:model="fecha" class="form-control" />
                        @error('fecha') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4" >
                    <div class="form-group" wire:ignore>
                        <label for="obras">Obras</label>
                        <select wire:model="obraSelected" class="form-control" id="select2Obras" style="width: 100%;">
                            <option value="" selected hidden >Seleccione una Obra</option>
                            @foreach ($obras as $obra)
                                <option value="{{ $obra->id }}">{{ $obra->detalle->nombreObra }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('obraSelected') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-4">
                    <div class="form-group" wire:ignore>
                        <label for="materiales">Materiales</label>
                        <select wire:model="materialesSeleccionados" multiple class="form-control" id="select2Material" style="width: 100%;">
                            <option value="" selected disabled hidden >Seleccione los Materiales</option>
                            @foreach ($materiales as $material)
                                <option value="{{ $material->id }}">{{ $material->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('materialesSeleccionados') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-12">
                    <div class="gap-2 mt-3 d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" wire:click="limpiar">
                            Limpiar
                        </button>
                        <x-button type="submit" class="btn btn-primary">
                            Guardar
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script type="module">
    $('#select2Obras').select2({
        width: '100%',
        placeholder: "Seleccione una Obra",
        allowClear: true
    });
    $('#select2Obras').on('change', function(e) {
        var data = $('#select2Obras').select2("val");
        @this.set('obraSelected', data);
    });
    $('#select2Material').select2({
        width: '100%',
        placeholder: "Seleccione un Material",
        allowClear: true
    });
    $('#select2Material').on('change', function(e) {
        var data = $('#select2Material').select2("val");
        @this.set('materialesSeleccionados', data);
    });
    window.addEventListener('livewire:init', () => {
        Livewire.on("clearSelect2", ()=> {
            $('#select2Obras').val(null).trigger('change');
            $('#select2Material').val(null).trigger('change');
        });
    })

        Livewire.on("actualizarMaterialesInsumos", (data) => {
            let select2 = $('#select2Material');

            // Obtén los valores actualmente seleccionados
            let selectedValues = select2.val();

            // Limpia las opciones actuales
            select2.find('option').remove();
            // Recargar las opciones desde los materiales obtenidos en el backend
            data[0]['materiales'].forEach(function(material) {
                let isSelected = selectedValues.includes(material.id.toString());
                let newOption = new Option(material.nombre, material.id, isSelected, isSelected);
                select2.append(newOption);
            });

            // Refresca el select2 para que muestre las nuevas opciones y mantenga las selecciones anteriores
            $('#select2Material').val(null).trigger('change');
            select2.trigger('change');
        });
</script>
@endpush
