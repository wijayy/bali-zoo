<?php

namespace App\Livewire;

use App\Models\Banner;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class BannerShow extends Component
{
    public Collection $banners;

    public function mount(): void
    {
        $this->banners = Banner::filters(['active' => 'active'])
            ->latest('startShow')
            ->get();
    }

    public function render(): View
    {
        return view('livewire.banner-show');
    }
}
