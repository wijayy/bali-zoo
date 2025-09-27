@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-b-2 h-6 border-black dark:border-white text-sm focus:outline-none shadow-xs text-black dark:text-white',
]) !!}>
