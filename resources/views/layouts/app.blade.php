<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <x-header :$title ></x-header>
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen font-poppins   bg-mine-100">
        <x-navbar :$header></x-navbar>

        <!-- Page Content -->
        <main class="space-y-3 lg:space-y-6">
            {{ $slot }}
        </main>
        @include('footer')
    </div>

    @stack('modals')


    @livewireScripts
</body>

</html>
