<?php

namespace App\Http\Livewire;

use App\Models\Airline;
use Livewire\Component;

class IndexAirlines extends Component
{
    public function render()
    {
        return view('livewire.index-airlines', [
            'airlines' => Airline::all()
        ]);
    }
}
