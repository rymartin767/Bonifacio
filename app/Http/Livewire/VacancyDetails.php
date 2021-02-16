<?php

namespace App\Http\Livewire;

use App\Models\Vacancy;
use Livewire\Component;

class VacancyDetails extends Component
{
    public $upgrades;
    public $hires;

    public function mount()
    {
        $this->upgrades = Vacancy::where('upgrade', 1)->count();
        $this->hires = Vacancy::where('emp', 0)->count();
    }

    public function truncateAwards()
    {
        Vacancy::truncate();
        $this->reset();
    }

    public function render()
    {
        return view('livewire.vacancy-details');
    }
}
