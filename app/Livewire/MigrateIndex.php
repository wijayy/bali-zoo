<?php

namespace App\Livewire;

use Livewire\Component;

class MigrateIndex extends Component
{
    public $title = 'Migration Process';

    public function render()
    {
        return view('livewire.migrate-index')->layout('');
    }
}
