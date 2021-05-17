<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
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
        foreach($requests as $request) {
            $validator = $vacancy->validate($request);
            if($validator->errors()->isNotEmpty()) {
                $this->status = 'EMP# ' . $request->all()['emp'] . ': ' . $validator->errors()->first();
                return;
            } 

            $vacancy->save($request);
        }

        $this->status = 'List Saved!';
    }

    public function render()
    {
        return view('livewire.store-vacancy', [
            'files' => Storage::allFiles('/vacancy-awards/')
        ]);
    }
}
