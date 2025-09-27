<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Products extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $minPrice;
    public $maxPrice;

    public $title = '';

    protected $updatesQueryString = ['search', 'category', 'minPrice', 'maxPrice'];

    public function mount()
    {
        if (request()->query('mode') === 'create') {
            $this->title = 'Tambah Produk';
        } elseif (request()->query('mode') === 'edit') {
            $this->title = 'Edit Produk';
        } else {
            $this->title = 'Our Products';
        }
    }

    public function render()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }

        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        $products = $query->paginate(10);



        logger('Products count: ' . $products->total());

        return view('livewire.products', [
            'products' => $products,
        ])->layout('layouts.app', ['title' => $this->title, 'header' => false]);
    }

    public function updating($property)
    {
        logger("UPDATING: {$property} -> " . $this->$property);
        // Contoh: resetPage atau validasi real-time
    }

    public function updated($property)
    {
        logger("UPDATED: {$property} -> " . $this->$property);
        // Bisa buat logika setelah perubahan selesai
    }
}