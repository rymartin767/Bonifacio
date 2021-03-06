<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use App\Models\Airline;
use Livewire\Component;

class SeedAirlines extends Component
{
    public $status;
    public $pathToJson;

    public function rules()
    {
        return [
            'pathToJson' => ['required', 'string', 'ends_with:json'] 
        ];
    }

    public function submitForm()
    {
        $this->validate();

        $json = Storage::get($this->pathToJson);
        $airlines = json_decode($json);

        foreach($airlines as $airline) {
            $airline = Airline::create([
                'sector' => $airline->sector,
                'name' => $airline->name,
                'icao' => $airline->icao,
                'iata' => $airline->iata,
                'union' => $airline->union,
                'pilots' => $airline->pilots,
                'hiring' => $airline->hiring,
                'url' => $airline->url
            ]);

            if($airline) {
                $airline->seedScales();
            }
        }

        $this->submitSuccess();
    }

    private function submitSuccess()
    {
        $this->reset();
        $this->status = "Airlines Seeded!";
    }
    
    public function render()
    {
        return view('livewire.seed-airlines', [
            'files' => Storage::disk('s3')->allFiles('/api/json')
        ]);
    }
}
