<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use App\MyClasses\SeniorityList;
use App\Models\Seniority;
use Livewire\Component;

class StoreSeniority extends Component
{
    public $status;

    public $s3PathToFile;

    public function rules()
    {
        return [
            's3PathToFile' => ['required', 'string', 'ends_with:.tsv'] 
        ];
    }

    public function submitForm()
    {
        $this->validate();

        $list = new SeniorityList($this->s3PathToFile);
    
        $parsed = $list->parsedTsvToCollection();

        if($parsed->isEmpty()) {
            $this->status = 'Failed to parse s3 tsv to collection instance!';
        } else {
            $validated = collect();
            foreach($parsed as $pilot) {
                $request = $list->makePilotRequest($pilot);
                $validator = $list->validatePilotRequest($request);
                if ($validator->fails()) {
                    $this->status = $validator->errors()->first();
                } else {
                    $validated->push($request);
                }
            }

            $count = $list->storePilotData($validated);
            $this->submitSuccess($count);
        }
    }

    private function submitSuccess(int $count)
    {
        $this->reset();
        $this->status = $count . " Pilots Saved!";
    }

    public function render()
    {
        return view('livewire.store-seniority', [
            'months' => Seniority::pluck('month')->unique(),
            'files' => Storage::disk('s3')->allFiles('/seniority-lists/2021/')
        ]);
    }
}