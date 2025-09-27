@props(['label'])

<a {{ $attributes->merge(['class' => 'relative flex justify-center items-center group/icon size-fit']) }}>
    {{ $slot }}
    <div
        class="group-hover/icon:block group-focus/icon:block bg-inherit hidden absolute text-xs z-50 border-b-2 top-full text-nowrap text-inherit left-0 translate-y-0 px-1 py-0.5 capitalize ">
        {{ $label ?? '' }}
    </div>
</a>
