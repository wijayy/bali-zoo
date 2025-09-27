@props(['image', 'text'])

<div class="h-60 w-full bg-center bg-cover bg-no-repeat flex gap-4" style="background-image: url({{ $image }})">
    <div class="backdrop-blur-xs flex justify-center flex-col w-full h-full items-center">
        <div class="text-4xl lg:text-5xl font-semibold   ">{{ $text }} </div>
        <div class="text-xs lg:text-sm"><a class="font-semibold" href="{{ route('home') }}">Home</a> > {{ $text }}
        </div>
    </div>
</div>
