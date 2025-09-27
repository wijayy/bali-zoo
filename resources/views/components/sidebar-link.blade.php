@props(['active', 'text'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex gap-2 size-10 md:p-2 items-center justify-center md:justify-start md:w-full rounded-lg bg-mine-200 font-medium leading-5 transition duration-150 ease-in-out'
            : 'inline-flex gap-2 size-10 md:p-2 items-center justify-center md:justify-start md:w-full rounded-lg bg-mine-100 hover:bg-mine-200 font-medium leading-5 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    <div class="hidden text-lg text-black md:block">{{ $text }}</div>
</a>
