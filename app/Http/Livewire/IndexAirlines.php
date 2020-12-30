<?php

namespace App\Http\Livewire;

use App\Models\Airline;
use Livewire\Component;

class IndexAirlines extends Component
{
    public $status = "Waiting Patiently";

    public function updateScales(Airline $airline)
    {
        $seeded = $airline->seedScales();
        if($seeded) {
            $this->status = 'Updated!';
        } else {
            $this->status = 'Exception Caught';
        }
    }

    public function render()
    {
        return view('livewire.index-airlines', [
            'airlines' => Airline::all()
        ]);
    }
}
