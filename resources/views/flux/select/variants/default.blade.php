@pure

@props([
    'name' => $attributes->whereStartsWith('wire:model.live')->first(),
    'placeholder' => null,
    'invalid' => null,
    'size' => null,
])

@php
$invalid ??= ($name && $errors->has($name));

$classes = Flux::classes()
    ->add('appearance-none') // Strip the browser's default <select> styles...
    ->add('w-full pe-10 block')
    ->add(match ($size) {
        default => 'h-10 py-2 text-base sm:text-sm leading-[1.375rem] ',
        'sm' => 'h-8 py-1.5 text-sm leading-[1.125rem] ',
        'xs' => 'h-6 text-xs leading-[1.125rem] ',
    })
    ->add('shadow-xs border-b-2')
    ->add('bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]')
    ->add('text-zinc-700 dark:text-zinc-300 disabled:text-zinc-500 dark:disabled:text-zinc-400')
    // Make the placeholder match the text color of standard input placeholders...
    ->add('has-[option.placeholder:checked]:text-zinc-400 dark:has-[option.placeholder:checked]:text-zinc-400')
    // Options on Windows don't inherit dark mode styles, so we need to force them...
    ->add('dark:[&>option]:bg-zinc-700 dark:[&>option]:text-white')
    ->add('disabled:shadow-none')
    ->add($invalid
        ? 'border-red-500'
        : 'border-black dark:border-white'
    )
    ;
@endphp

<select
    {{ $attributes->class($classes) }}
    @if ($invalid) aria-invalid="true" data-invalid @endif
    @isset ($name) name="{{ $name }}" @endisset
    @if (is_numeric($size)) size="{{ $size }}" @endif
    data-flux-control
    data-flux-select-native
    data-flux-group-target
>
    <?php if ($placeholder): ?>
        <option value="" disabled selected class="placeholder">{{ $placeholder }}</option>
    <?php endif; ?>

    {{ $slot }}
</select>
