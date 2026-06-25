<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="">
        <flux:session class="print:hidden">{{ $title ?? null }}</flux:session>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
