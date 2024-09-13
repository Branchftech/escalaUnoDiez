<div class="flex flex-row gap-2">
    <x-button class="btn btn-primary" style="background-color:#0a8ebe; border-color:#0a8ebe" x-data x-on:click="$dispatch('cargarModalEditarEgreso', { model: {{$model}} })">
        <i class="fas fa-edit"></i>
     </x-button>
{{--
    <!-- Botón para firmar el recibo -->
    <a href="/pdf/recibo/{{ json_decode($model)->id }}" target="_blank" style="text-decoration: none;">
        <x-button class="btn btn-warning" type="button">
            Firmar
        </x-button>
    </a> --}}
    <!-- Botón para descargar el PDF -->
    <a href="/pdf/recibo/{{ json_decode($model)->id }}" target="_blank" style="text-decoration: none;">
        <x-button class="btn btn-primary" type="button" style="background-color:#0a8ebe; border-color:#0a8ebe">
            <i class="fa-solid fa-file-signature"></i>
        </x-button>
    </a>

     <x-danger-button  class="btn btn-danger" x-data x-on:click="$dispatch('cargarModalEliminarEgreso',  { model: {{$model}} })">
        <i class="fa-solid fa-trash"></i>
     </x-danger-button>
</div>
