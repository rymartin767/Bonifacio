<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Airline;
use Carbon\Carbon;

class IndexAirlines extends Component
{
    public $status = "Waiting Patiently";

    public Airline $airline;
    public $url;
    public $showModal = false;

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

    public function toggleHiring(Airline $airline)
    {
        $airline->hiring = !$airline->hiring;
        $airline->updated_at = Carbon::now();
        $saved = $airline->save();
        if($saved) {
            $this->status = 'Updated!';
        } else {
            $this->status = 'Oops. Not updated.';
        }

    }

    public function modalDisplayed(Airline $airline)
    {
        $this->airline = $airline;
        $this->showModal = true;
    }

    public function modalAction()
    {
        $airline = $this->airline;
        $airline->url = $this->url;
        $saved = $airline->save();
        if($saved) {
            $this->status = 'Updated URL';
            $this->url = '';
            $this->showModal = false;
        } else {
            $this->status = 'Oops. Not Updated.';
        }
    }

    public function render()
    {
        return view('livewire.index-airlines', [
            'airlines' => Airline::all()->sortByDesc('updated_at')
        ]);
    }
}
