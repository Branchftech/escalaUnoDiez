
{{-- select --}}
@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-neutral-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-neutral-800']) !!} >
    {{ $slot }}
</select>
