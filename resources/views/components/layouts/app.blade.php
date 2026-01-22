<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="">
        <flux:session>{{ $title ?? null }}</flux:session>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
