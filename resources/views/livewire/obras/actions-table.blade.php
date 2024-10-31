<div class="flex flex-row gap-2">
    {{-- <a href="{{ route('detalleObra', $model['id']) }}"  wire:navegate >
        <i class="fas fa-eye"></i>
    </a> --}}
    <div class="flex flex-row gap-2">
        <button class="btn btn-primary" style="background-color:#0a8ebe; border-color:#0a8ebe"
            onclick="window.location.href='{{ route('detalleObra', $model['id']) }}'">
            <i class="fas fa-eye"></i>
        </button>

        <button class="btn btn-danger" x-data x-on:click="$dispatch('cargarModalEliminarObra',  { id: {{$model['id']}} })">
            <i class="fas fa-trash"></i>
        </button>

    </div>
</div>
