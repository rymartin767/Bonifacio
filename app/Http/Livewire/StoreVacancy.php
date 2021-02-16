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
        $rows = $vacancy->rows();
        $requests = $vacancy->createRequests($rows);
        $validated = $vacancy->validateRequests($requests);
        if($validated) {
            foreach($requests as $request) {
                $vacancy->save($request);
            }
            $this->results('Success! Cache cleared!');
        } else {
            $this->results('Failed to save validated requests');  
        }
    }

    private function results(string $message)
    {
        $this->reset();
        Cache::flush();
        $this->status = $message;
    }

    public function render()
    {
        return view('livewire.store-vacancy', [
            'files' => Storage::disk('s3')->allFiles('/archives/vacancy-awards/2021/tsv')
        ]);
    }
}
