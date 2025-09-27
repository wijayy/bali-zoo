<footer class="bg-white border-t mt-4">
    <div class="p-4 font-poppins mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <div class="space-y-10">
            <div class="font-inter font-bold">Bali Zoo Merchandise</div>
            <div class="text-sm text-gray-600">Jl. Raya Singapadu, Singapadu, Kec. Sukawati, Kabupaten Gianyar, Bali
                80582</div>
        </div>
        <div class="flex justify-between xl:justify-evenly order-3 xl:order-2 ">
            <div class="space-y-2 flex flex-col">
                <div class="text-stone-500">Links</div>
                <a class="text-base">Home</a>
                <a class="">Shop</a>
                <a class="">About</a>
                <a class="">Contact</a>
            </div>
            <div class="space-y-2 flex flex-col">
                <a class="text-stone-500">Helps</a>
                <a class="text-base">Payment Options</a>
                <a class="">Returns</a>
                <a class="">Delivery Options</a>
            </div>
        </div>

        <div class="space-y-2 order-2 xl:order-3">
            <div class="text-stone-500">Newsletter</div>
            <form action="" method="post" class="flex gap-1">
                <x-input id="email" placeholder="Enter Your Email Address"
                    class="block w-full text-xs placeholder:text-xs" type="email" name="email" :value="old('email')"
                    required autocomplete="email" />
                <button class="border-b-2 px-2 border-black text-xs" type="submit">
                    {{ __('Subscribe') }}
                </button>
            </form>
        </div>
    </div>
    <div class="text-center"></div>
</footer>
