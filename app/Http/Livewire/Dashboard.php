<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $selected;

    public function render()
    {
        return view('livewire.dashboard');
    }
}