<div class="flex flex-row gap-2">
    <x-button class="btn btn-primary" style="background-color:#0a8ebe; border-color:#0a8ebe" x-data x-on:click="$dispatch('cargarModalEditar', { model: {{$model}} })">
        <i class="fas fa-edit"></i>
     </x-button>
</div>
