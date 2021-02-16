<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use App\MyClasses\SeniorityList;
use Illuminate\Support\Str;
use App\Models\Seniority;
use Livewire\Component;
use Carbon\Carbon;

class StoreSeniority extends Component
{
    public $status;

    public $pathToCsv;
    public $savedMonths;

    public function mount()
    {
        $this->savedMonths = Seniority::pluck('month')->unique();    
    }

    public function rules()
    {
        return [
            'pathToCsv' => ['required', 'string', 'ends_with:csv'] 
        ];
    }

    public function submitForm()
    {
        $this->validate();

        $list = new SeniorityList($this->pathToCsv);

        $month = Carbon::parse(Str::of($this->pathToCsv)->replace('_', ' ')->substr(-12, 8));
        $validated = $list->validatePilotData($this->pathToCsv, $month);
        $count = $list->storePilotData($validated, $month);

        $this->submitSuccess($count);
    }

    private function submitSuccess(int $count)
    {
        $this->reset();
        $this->status = $count . " Pilots Saved!";
        $this->savedMonths = Seniority::pluck('month')->unique();
    }

    public function render()
    {
        return view('livewire.store-seniority', [
            'months' => $this->savedMonths,
            'files' => Storage::disk('s3')->allFiles('/archives/seniority-lists/2021/csv')
        ]);
    }
}