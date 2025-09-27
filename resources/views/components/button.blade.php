@props(['as' => null])

@php
    $classes = 'px-2 border-b-4 hover:border-mine-400 pb-1 relative z-10 rounded cursor-pointer group/a transition duration-300'
@endphp

@if ($button ?? false)
<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }} </a>
@else
<button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
    {{ $slot }}
</button>
@endif
