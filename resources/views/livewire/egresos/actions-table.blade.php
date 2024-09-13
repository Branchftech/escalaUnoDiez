<div class="flex flex-row gap-2">
    <x-button class="btn btn-primary" style="background-color:#0a8ebe; border-color:#0a8ebe" x-data x-on:click="$dispatch('cargarModalEditarEgreso', { model: {{$model}} })">
        <i class="fas fa-edit"></i>
     </x-button>
     <script>
        let model = JSON.parse(@json($model)); // Asegúrate de que esta línea no se repita sin control
    </script>

    <!-- Botón para ver el PDF del egreso -->
    <a :href="`/pdf/recibo/${model.id}`" target="_blank">
        <x-button class="btn btn-primary" type="button" style="background-color:#0a8ebe; border-color:#0a8ebe">
            <i class="fas fa-eye"></i>
        </x-button>
    </a>
     <x-danger-button  class="btn btn-danger" x-data x-on:click="$dispatch('cargarModalEliminarEgreso',  { model: {{$model}} })">
        <i class="fa-solid fa-trash"></i>
     </x-danger-button>
</div>
