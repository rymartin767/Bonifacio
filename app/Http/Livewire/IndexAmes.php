<?php

namespace App\Http\Livewire;

use App\Models\Ame;
use Livewire\Component;

class IndexAmes extends Component
{
    public function truncateAmes()
    {
        Ame::truncate();
    }

    public function render()
    {
        return view('livewire.index-ames');
    }
}
