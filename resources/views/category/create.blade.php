@php
    $title = $category ?? false ? "Edit Category $category->name" : 'Add Category';
@endphp

<x-auth-layout title="{{ $title }}">
    <form enctype="multipart/form-data"
        action="{{ $category ?? false ? route('categories.update', ['category' => $category->slug]) : route('categories.store') }}"
        method="post">
        @csrf
        @if ($category ?? false)
            @method('put')
        @endif
        <div x-data="{
            items: [
                { file: '{{ $category->image ?? false ? asset('storage/' . $category->image) : '' }}' }
            ],

            addItem() {
                this.items.push({
                    file: '',

                });
            },
            removeItem(index) {
                this.items.splice(index, 1);
            }
        }" class="mt-4 space-y-2">
            <!-- Input Fields -->
            <div class="grid items-end gap-2 grid-cols-2 xl:grid-cols-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="relative" x-data="{
                        image: item.file,
                        text: 'Category Photo',
                        label: 'image',
                        lbl: !item.file,
                        fileName: '',
                        imagePreview(event) {
                            const files = event.target.files[0];
                            if (!files) {
                                this.lbl = true;
                                return;
                            }
                            if (files.type.startsWith('image/')) {
                                this.image = URL.createObjectURL(files);
                                this.fileName = ''; // Reset file name jika gambar
                            } else {
                                this.image = ''; // Reset image jika bukan gambar
                                this.fileName = file.name; // Simpan nama file
                            }
                            this.lbl = false;
                        }
                    }">
                        <x-label :required="true" ::for="label" x-text="text" />
                        <div class="relative flex w-full mt-1 text-center rounded-md shadow-md aspect-square">
                            <img :src="image" :alt="text"
                                class="absolute top-0 left-0 z-10 object-cover rounded-md size-full" x-show="image">
                            <!-- Tampilkan Nama File Jika Bukan Gambar -->
                            <span
                                class="absolute text-gray-700 transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                x-show="fileName" x-text="fileName"></span>
                            <input type="file" :id="label" :name="label"
                                @change="imagePreview(event)" @required($category?false:true) class="sr-only">
                            <label :for="label" :class="{ 'opacity-100': (lbl), 'opacity-0': !lbl }"
                                class="absolute top-0 left-0 z-20 flex items-center justify-center w-full h-full bg-transparent border border-black border-dashed rounded-md cursor-pointer text-sky-500 hover:text-blue-700"
                                x-text="text"></label>
                        </div>
                        <x-input-error for="image"></x-input-error>
                    </div>
                </template>
            </div>
        </div>
        <div class="mt-4">
            <x-label required="true" for="name" value="{{ __('category Name') }}" />
            <x-input value="{{ old('name', $category->name ?? false) }}" id="name" type="text"
                class="mt-1 block w-full" name="name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <div class="mt-4">
            <flux:button type="submit">Submit</flux:button>
        </div>
    </form>
</x-auth-layout>
