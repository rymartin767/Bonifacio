<?php

namespace App\Http\Livewire;

use App\Models\Seniority;
use Livewire\Component;

class ViewSeniority extends Component
{
    public $savedMonths;

    public function mount()
    {
        $this->savedMonths = Seniority::pluck('month')->unique();    
    }

    public function render()
    {
        return view('livewire.view-seniority');
    }
}
