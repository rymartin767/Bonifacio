<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\MyClasses\VacancyList;
use Livewire\Component;

class StoreVacancy extends Component
{
    public $status;
    public $pathToTsv;

    public function rules()
    {
        return [
            'pathToTsv' => ['required', 'string', 'ends_with:tsv'] 
        ];
    }

    public function submitForm()
    {
        $this->validate();

        $vacancy = new VacancyList($this->pathToTsv);

        if($vacancy->validated()['status'] === 'passed') {
            $saved = $vacancy->saveAwards($vacancy->validated()['validatedRequests']);
            $saved ? $this->submitSuccess() : $this->status = 'Failed during saving!';
        }

        if($vacancy->validated()['status'] === 'failed') {
            $this->status = $vacancy->validated()['message'];
        }
    }

    private function submitSuccess()
    {
        $this->reset();
        Cache::flush();
        $this->status = "Vacancy Awards Saved! Cache flushed.";
    }

    public function render()
    {
        return view('livewire.store-vacancy', [
            'files' => Storage::disk('s3')->allFiles('/vacancies/2020')
        ]);
    }
}
