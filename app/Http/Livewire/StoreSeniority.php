<?php

namespace App\Http\Livewire;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Actions\Seniority\StoreList;
use Illuminate\Support\Str;
use App\Models\Seniority;
use Livewire\Component;
use Carbon\Carbon;

class StoreSeniority extends Component
{
    use StoreList;

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

        $month = Carbon::parse(Str::of($this->pathToCsv)->replace('_', ' ')->substr(-12, 8));
        $validated = $this->validatePilotData($this->pathToCsv, $month);
        $this->storePilotData($validated, $month);

        $this->submitSuccess();
    }

    private function submitSuccess()
    {
        $this->reset();
        Cache::flush();
        $this->status = "Saved! Cache cleared!";
        $this->savedMonths = Seniority::pluck('month')->unique();
    }

    public function render()
    {
        return view('livewire.store-seniority', [
            'months' => $this->savedMonths,
            'files' => Storage::disk('s3')->allFiles('/pilots/CSV/2020')
        ]);
    }
}