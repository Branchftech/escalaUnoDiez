@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div class="card px-4 py-5   sm:p-6 shadow rounded-none {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}  " style="box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.05), 0 3px 6px 0 rgba(0, 0, 0, 0.05);">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
                @if (isset($actions))
                    <div class="flex items-center justify-end text-end sm:rounded-bl-md sm:rounded-br-md">
                        {{ $actions }}
                    </div>
                @endif
            </div>

        </form>
    </div>
</div>
