<div class="flex flex-row gap-2">
    {{-- <a href="{{ route('detalleObra', $model['id']) }}"  wire:navegate >
        <i class="fas fa-eye"></i>
    </a> --}}
    <x-button class="btn btn-primary" style="background-color:#0a8ebe; border-color:#0a8ebe"
        x-on:click="window.location.href='{{ route('detalleObra', $model['id']) }}'">
        <i class="fas fa-eye"></i>
    </x-button>
</div>
