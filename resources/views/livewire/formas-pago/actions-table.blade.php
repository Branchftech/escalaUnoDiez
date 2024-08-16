<div class="flex flex-row gap-2">
    <x-button class="btn btn-primary" x-data x-on:click="$dispatch('cargarModalEditar', { model: {{$model}} })">
        <i class="fas fa-edit"></i>
     </x-button>
     <x-danger-button  class="btn btn-danger" x-data x-on:click="$dispatch('cargarModalEliminar',  { model: {{$model}} })">
        <i class="fa-solid fa-trash"></i>
     </x-danger-button>
</div>
