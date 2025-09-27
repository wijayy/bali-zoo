@props(['value'])

<label {{ $attributes->merge(['class' => 'block capitalize font-medium text-sm text-black dark:text-white']) }}>
    {{ $value ?? $slot }}
</label>
