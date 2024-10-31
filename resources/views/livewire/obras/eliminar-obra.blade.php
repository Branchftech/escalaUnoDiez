<div>
    <x-modal-default title="Eliminar Obra" name="Eliminar-Obra">
        <x-slot:body>
            <div class="p-1">
                <div>
                    @if($model)
                        <h4 class="mb-4 text-lg font-semibold">¿Estás seguro de que deseas eliminar la Obra Número {{ $model->id }}?</h4>
                    @else
                        <h4 class="mb-4 text-lg font-semibold">Obra no encontrada.</h4>
                    @endif
                    <div class="gap-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close-modal')">Cancelar</button>
                        <button type="submit" class="btn btn-primary" x-on:click="$wire.eliminarObra(); showModal = false">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
