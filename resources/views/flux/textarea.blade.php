@props([
    'name' => $attributes->whereStartsWith('wire:model.live')->first(),
    'resize' => 'vertical',
    'variant' => 'outline',
    'invalid' => null,
    'rows' => 4,
])

@php
    $invalid ??= $name && $errors->has($name);

    $classes = Flux::classes()
        ->add('w-full block disabled:shadow-none dark:shadow-none appearance-none')
        ->add('text-base sm:text-sm py-2 leading-[1.375rem]')
        ->add('px-3')
        ->add('shadow-xs rounded-lg')
        ->add(
            match ($variant) {
                'outline' => 'bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] border-b-2 border-black',
                'filled' => 'bg-zinc-800/5 dark:bg-white/10 dark:disabled:bg-white/[7%] border-0',
                default
                    => 'bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] border-zinc-200 border-b-zinc-300/80 dark:border-white/10',
            },
        )
        ->add($resize ? 'resize-y' : 'resize-none')
        ->add(
            match ($variant) {
                'outline' => $invalid ? 'border-red-500' : '',
                'filled' => $invalid ? 'border-red-500' : '',
                default => $invalid ? 'border-red-500' : '',
            },
        )
        ->add(
            'text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500',
        );

    $resizeStyle = match ($resize) {
        'none' => 'resize: none',
        'both' => 'resize: both',
        'horizontal' => 'resize: horizontal',
        'vertical' => 'resize: vertical',
    };
@endphp

<flux:with-field :$attributes>
    <textarea {{ $attributes->class($classes) }} rows="{{ $rows }}"
        style="{{ $resizeStyle }}; {{ $rows === 'auto' ? 'field-sizing: content' : '' }}"
        @isset($name) name="{{ $name }}" @endisset
        @if ($invalid) aria-invalid="true" data-invalid @endif data-flux-control data-flux-textarea>{{ $slot }}</textarea>
</flux:with-field>
