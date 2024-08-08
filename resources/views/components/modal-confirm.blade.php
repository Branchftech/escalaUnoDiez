@props(['id', 'event','message','modo'])
<div x-data="{ showConfirm: false }">
    @if ($modo == 'primary')
        <x-button @click="showConfirm = true"  >
            {{ $slot }}
        </x-button>
    @else
        <x-danger-button @click="showConfirm = true" >
            {{ $slot }}
        </x-danger-button>
    @endif

    <!-- Modal de confirmación -->
    <div x-data x-show="showConfirm"  x-on:open-modal.window="showConfirm = ($event.detail.name === name)"
    x-on:close-modal.window="showConfirm = false" x-on:keydown.escape.window="showConfirm = false"
    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center bg-opacity-75 bg-black/30 ">
        <div class="p-5 bg-white rounded-lg">
            <div class="flex justify-end w-full ">
                <i class="cursor-pointer fa-solid fa-xmark" @click="showConfirm = false"></i>
            </div>
           <div class="p-5">
            <h2 class="mb-4 text-lg font-semibold">{{ $message }}</h2>
            <div class="flex justify-end space-x-4">
                <x-secondary-button @click="showConfirm = false">Cancelar</x-button>
                <x-danger-button x-on:click="$wire.{{ $event }}({{ $id }}); showConfirm = false">
                    Confirmar
                </x-danger-button>
            </div>
           </div>
        </div>
    </div>
</div>
