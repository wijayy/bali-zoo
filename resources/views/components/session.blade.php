@if (session()->hasAny(['success', 'error']))
<div class="pt-4">
    @if (session()->has('success'))
    <div class="text-green-400">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
    <div class="text-rose-400">{{ session('error') }}</div>
    @endif
</div>
@endif
