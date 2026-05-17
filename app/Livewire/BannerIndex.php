<?php

namespace App\Livewire;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class BannerIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public int $perPage = 10;

    public $id = null;

    protected string $paginationTheme = 'tailwind';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function delete($id): void
    {
        $banner = Banner::findOrFail($id);
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        session()->flash('success', 'Banner berhasil dihapus.');
    }

    public function render()
    {
        $banners = Banner::filters([
            'name' => $this->search,
            'active' => $this->status,
        ])
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.banner-index', [
            'banners' => $banners,
        ]);
    }
}
