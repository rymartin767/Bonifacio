<?php

namespace App\Http\Livewire;

use App\Rules\ScalesFoundOnAws;
use App\Rules\ValidateScales;
use Livewire\Component;
use App\Models\Airline;

class StoreAirline extends Component
{
    public $status;

    public $sector;
    public $name;
    public $icao;
    public $iata;
    public $union;
    public $pilots;
    public $hiring;
    public $url;

    public function rules()
    {
        return [
            'sector' => 'required|string|in:cargo,legacy,major',
            'name' => ['required', 'string', 'unique:airlines', 'min:5', 'max:50'],
            'iata' => 'required|unique:airlines|size:2',
            'union' => 'required|in:alpa,apa,ipa,none,ibt,sapa',
            'pilots' => 'required|numeric|digits_between:3,5',
            'hiring' => 'required|boolean',
            'icao' => ['required','unique:airlines','size:3', new ScalesFoundOnAws, new ValidateScales],
            'url' => 'required|string|min:10|max:255'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected function formData()
    {
        return [
            'sector' => $this->sector,
            'name' => $this->name,
            'icao' => $this->icao,
            'iata' => $this->iata,
            'union' => $this->union,
            'pilots' => $this->pilots,
            'hiring' => $this->hiring,
            'url' => $this->url
        ];
    }

    public function submitForm()
    {
        $this->validate();

        $airline = Airline::create($this->formData());

        if($airline) {
            $airline->seedScales() ? $this->submitSuccess($airline->name) : $this->status = "Airline Created but Scales failed.";
        }
    }

    protected function submitSuccess($airline)
    {
        $this->reset();
        $this->status = $airline . " and Scales Saved!";
    }

    public function render()
    {
        return view('livewire.store-airline');
    }
}
