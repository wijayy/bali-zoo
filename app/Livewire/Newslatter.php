<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class Newslatter extends Component
{
    #[Validate('required|string|max:255|email')]
    public $email = '';

    public function submit()
    {
        $this->validate();
    }

    public function render()
    {
        return view('livewire.newslatter');
    }
}
