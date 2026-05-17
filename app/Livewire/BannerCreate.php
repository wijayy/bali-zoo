<?php

namespace App\Livewire;

use App\Models\Banner;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BannerCreate extends Component
{
    use WithFileUploads;

    public ?Banner $banner = null;

    public string $name = '';

    public string $startShow = '';

    public string $endShow = '';

    public string $existingImage = '';

    public $image = null;

    public function mount($slug = null): void
    {
        if ($slug) {
            $banner = Banner::where('slug', $slug)->firstOrFail();
        }

        if (isset($banner)) {
            $this->banner = $banner;
            $this->name = $banner->name;
            $this->startShow = $banner->startShow;
            $this->endShow = $banner->endShow;
            $this->existingImage = $banner->image;
        } else {
            $this->banner = null;
            $this->name = '';
            $this->startShow = '';
            $this->endShow = '';
            $this->existingImage = '';
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => [$this->banner ? 'nullable' : 'required', 'image', 'max:2048'],
            'startShow' => ['required', 'date'],
            'endShow' => ['required', 'date', 'after_or_equal:startShow'],
        ], [
            'name.required' => 'Nama banner wajib diisi.',
            'image.required' => 'Gambar banner wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
            'startShow.required' => 'Waktu mulai tampil wajib diisi.',
            'endShow.required' => 'Waktu selesai tampil wajib diisi.',
            'endShow.after_or_equal' => 'Waktu selesai tampil harus setelah waktu mulai tampil.',
        ]);

        $imagePath = $this->existingImage;

        if ($this->image && method_exists($this->image, 'store')) {
            if ($this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
                Storage::disk('public')->delete($this->existingImage);
            }

            $imagePath = $this->image->store('banners', 'public');
        }

        Banner::updateOrCreate(
            ['id' => $this->banner?->id],
            [
                'name' => $validated['name'],
                'image' => $imagePath,
                'startShow' => $validated['startShow'],
                'endShow' => $validated['endShow'],
            ]
        );

        session()->flash('success', $this->banner ? 'Banner berhasil diperbarui.' : 'Banner berhasil ditambahkan.');

        $this->redirectRoute('banners.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.banner-create');
    }
}
