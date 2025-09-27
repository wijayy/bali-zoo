@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full text-start text-xs font-medium border-b-2 border-black transition duration-150 ease-in-out'
            : 'block w-full text-start text-xs border-b-2 border-transparent hover:border-mine-400 font-medium transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
