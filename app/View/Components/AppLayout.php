<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Ramsey\Uuid\Type\Integer;

class AppLayout extends Component
{

    public function __construct(public $title = "", public $header = false) {}
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}