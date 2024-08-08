@props(['even'=>false, 'colspan'=> 1])
<td class="px-5 py-2 text-nowrap flex-nowrap {{ $even ? 'bg-neutral-100 group-odd:bg-neutral-100  group-hover:bg-neutral-200' : 'bg-neutral-100 group-odd:bg-white group-hover:bg-neutral-200' }}" colspan="{{ $colspan }}">
    {{ $slot }}
</td>
