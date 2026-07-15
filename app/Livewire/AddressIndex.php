<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class AddressIndex extends Component
{

    public $title = "My Addresses";

    public $id;

    #[Computed()]
    public function address()
    {
        return Auth::user()->alamats;
    }

    public function tambahAlamat()
    {
        $this->dispatch('tambahAlamat');
    }
    public function editAlamat($id)
    {
        $this->dispatch('editAlamat', id: $id);
    }

    #[On("updateAlamat")]
    public function updateAlamat($message)
    {
        session()->flash('success', $message);
    }

    public function render()
    {
        return view('livewire.address-index')->layout('layouts.app', ['title' => $this->title, 'header' => false]);
    }
}
