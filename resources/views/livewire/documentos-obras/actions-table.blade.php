<div class="flex flex-row gap-2">
    <button  class="btn btn-danger" style="background-color:#0a8ebe; border-color:#0a8ebe" x-data x-on:click="$dispatch('visualizarDocumento', { model: {{$model}} })">
        <i class="fa-solid fa-eye"></i>
    </button>

    <x-danger-button  class="btn btn-danger" x-data x-on:click="$dispatch('cargarModalEliminarDocumentoObra',  { model: {{$model}} })">
        <i class="fa-solid fa-trash"></i>
     </x-danger-button>
</div>
