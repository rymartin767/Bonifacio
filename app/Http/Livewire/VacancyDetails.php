<?php

namespace App\Http\Livewire;

use App\Models\Vacancy;
use Carbon\Carbon;
use Livewire\Component;

class VacancyDetails extends Component
{
    public $upgrades;
    public $new_hires;

    public function mount()
    {
        $this->upgrades = Vacancy::where('upgrade', 1)->count();
        $this->new_hires = Vacancy::where('new_hire', 1)->count();
    }

    public function truncateAwards()
    {
        Vacancy::truncate();
        $this->reset();
    }

    public function seedAwards(){
        $file = file_get_contents('json/awards.json');
        $json = json_decode($file);
        foreach($json as $j) {
            Vacancy::create([
                'base_seniority' => $j->base_seniority, 
                'emp' => $j->emp, 
                'base'=> $j->base,
                'fleet' => $j->fleet,
                'seat' => $j->seat,
                'award_base' => $j->award_base,
                'award_fleet' => $j->award_fleet,
                'award_seat' => $j->award_seat,
                'upgrade' => $j->upgrade,
                'month' => new Carbon($j->month)
            ]);
        }
        $this->reset();
    }

    public function render()
    {
        return view('livewire.vacancy-details');
    }
}
