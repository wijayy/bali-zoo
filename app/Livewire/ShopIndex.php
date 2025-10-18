<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;

class ShopIndex extends Component
{

    public $title = "Shop";
    public  $categories;

    #[Url(except: '')]
    public $search = '', $category = '';

    #[Url(except:null)]
    public $min, $max;

    public function mount()
    {
        $this->categories = Category::all();
    }


    public function render()
    {
        $products = Product::withCount('review')->filters(request(['category', 'min', 'max', 'search']))->paginate(12);

        return view('livewire.shop-index', compact('products'))->layout('layouts.app', ['title' => $this->title, 'header' => false]);
    }
}
