<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Airline;
use Carbon\Carbon;

class IndexAirlines extends Component
{
    public $status = "Waiting Patiently";

    public function updateScales(Airline $airline)
    {
        $seeded = $airline->seedScales();
        if($seeded) {
            $airline->updated_at = Carbon::now();
            $airline->save();
            $this->status = 'Updated!';
        } else {
            $this->status = 'Exception Caught';
        }
    }

    public function render()
    {
        return view('livewire.index-airlines', [
            'airlines' => Airline::all()->sortDesc()
        ]);
    }
}
