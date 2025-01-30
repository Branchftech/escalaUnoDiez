<div>
    <x-modal-default title="Eliminar Pais: {{ $model->nombre }}" name="Eliminar-Pais">
        <x-slot:body>
            <div class="p-4">
                <div>
                    <h4 class="mb-4 text-lg font-semibold">¿Estás seguro de que deseas eliminar el Pais "{{ $model->nombre }}" ?</h4>
                    <!-- Mensaje de advertencia -->
                    <p class="text-danger text-sm">⚠️ Al eliminar el país, se eliminarán todos los estados asociadas.</p>

                    <div class="gap-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close-modal')">Cancelar</button>
                        <button type="submit" class="btn btn-primary" x-on:click="$wire.eliminarPais(); showModal = false">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </x-slot:body>
    </x-modal-default>
</div>
