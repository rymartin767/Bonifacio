<?php

namespace App\Http\Livewire;

use App\Models\Vacancy;
use Livewire\Component;

class VacancyDetails extends Component
{
    public function truncateAwards()
    {
        Vacancy::truncate();
    }

    public function render()
    {
        return view('livewire.vacancy-details');
    }
}
