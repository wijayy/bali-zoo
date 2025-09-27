@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center cursor-pointer px-1 pt-1 border-b-2 text-xs text-inherit border-black leading-5 transition duration-150 ease-in-out'
            : 'inline-flex items-center cursor-pointer px-1 pt-1 border-b-2 text-xs text-inherit border-transparent hover:border-mine-400 leading-5 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
