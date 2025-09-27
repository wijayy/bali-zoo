<x-app-layout title="Our Contact" header="true">
    <x-secondary-header :text="'Our Contact'" :image="asset('build/assets/jerry-wang-qBrF1yu5Wys-unsplash.jpg')"></x-secondary-header>

    <div class="mt-4">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 flex items-center flex-col">
            <div class="text-2xl text-center">Get In Touch With Us</div>
            <div class="text-center w-full lg:w-1/2">For More Information About Our Product & Services. Please Feel Free
                To Drop Us An
                Email. Our Staff Always Be There To Help You Out. Do Not Hesitate!</div>

        </div>
    </div>

    <div class="mt-4 lg:mt-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 flex gap-4">
            <div class="space-y-4 w-full lg:w-1/2">
                <div class="flex">
                    <div class=""><i class="bx text-4xl bxs-map"></i></div>
                    <div class="">
                        <div class="font-bold text-lg">Address</div>
                        <div class="">Jl. Raya Singapadu, Singapadu, Kec. Sukawati, Kabupaten Gianyar, Bali
                            80582</div>
                    </div>
                </div>
                <div class="flex">
                    <div class=""><i class="bx text-4xl bxs-map"></i></div>
                    <div class="">
                        <div class="font-bold text-lg">Phone</div>
                        <div class="">Mobile : </div>
                    </div>
                </div>
                <div class="flex">
                    <div class=""><i class="bx text-4xl bxs-map"></i></div>
                    <div class="">
                        <div class="font-bold text-lg">Working Time</div>
                        <div class="">adasdas</div>
                    </div>
                </div>
            </div>
            <form class="space-y-4 w-full lg:w-1/2">
                <div class="w-full">
                    <x-label for="name">Your name</x-label>
                    <x-input id="name" name="name" required autocomplete="name" class="mt-1"></x-input>
                </div>
                <div class="w-full">
                    <x-label for="email">Email</x-label>
                    <x-input id="email" name="email" type="email" required autocomplete="email"
                        class="mt-1"></x-input>
                </div>
                <div class="w-full">
                    <x-label for="subject">subject</x-label>
                    <x-input id="subject" required placeholder="This field an optional" autocomplete="subject"
                        class="mt-1"></x-input>
                </div>
                <div class="w-full">
                    <x-label for="message">message</x-label>
                    <textarea name="message" id="message" class="border-b-2 focus:outline-none mt-1 resize-y w-full"></textarea>
                    {{-- <x-input id="message" required autocomplete="message" class="mt-1"></x-input> --}}
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
