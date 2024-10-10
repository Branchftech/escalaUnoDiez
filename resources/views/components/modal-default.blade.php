@props(['title', 'name','modal'=>'showModal','positionTop' => 'top:0px;','maxWidth' => 'max-width:40vw;'])
<div x-data="{ show: @entangle($modal), name: '{{ $name  }}' }"
    x-show="show" x-on:open-modal.window="show = ($event.detail.name === name)"
    x-on:close-modal.window="show = false" x-on:keydown.escape.window="show = false"
    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="" x-cloak style="position: fixed;z-index: 50;top   : 10%;right: 0;bottom: 0;left: 0; transition: opacity 0.2s;">

    <div x-on:click="show = false" class=""style="position: fixed; opacity: 0.4;background-color: black;inset: 0px;"></div>
    <div class="p-4 rounded-lg shadow-lg card"style="position: relative;margin: auto; border-radius: 0.5rem;{{$maxWidth}};{{$positionTop}}">

        @if (isset($title))
            <div class="d-flex justify-content-between">

                <h2 class="h5 font-weight-bold">{{ $title }}</h2>

                <button class="btn btn-link" x-on:click="$dispatch('close-modal')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <hr>
        @endif
        <div >
            {{ $body }}
        </div>
    </div>
</div>


