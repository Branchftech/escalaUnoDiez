<div class="flex flex-row gap-2">
    <x-button class="btn btn-primary" style="background-color:#0a8ebe; border-color:#0a8ebe"
        x-data
        x-on:click="$dispatch('cargarModalEditarPais', { model: {{$model}} })">
        <i class="fas fa-edit"></i>
    </x-button>

    <x-danger-button class="btn btn-danger" x-data
        x-on:click="$dispatch('cargarModalEliminarPais', { model: {{$model}} })">
        <i class="fa-solid fa-trash"></i>
    </x-danger-button>
</div>
