<?php

namespace App\MyClasses;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Seniority;
use App\Traits\ParseTsv;
use App\Models\Vacancy;

class VacancyList
{
    use ParseTsv;

    public function __construct(string $pathToTsv)
    {
        $this->pathToTsv = $pathToTsv;
    }

    public function month()
    {
        return $this->parseMonth($this->pathToTsv);
    }

    protected function collectedRows(): Collection
    {
        $collection = collect();
        $rows = $this->parseDataToRows(Storage::get($this->pathToTsv));
        foreach($rows as $row) {
            $collection->push($this->parseRowToCollection($row));
        }

        return $collection;
    }

    protected function checkForNewHire($collection)
    {
        return $collection[1] === 'NH';
    }

    protected function createRequest($awardCollection, $newHire)
    {
        if(!$newHire) {
            $employee = Seniority::where('emp', $awardCollection[1])->first();
            $subset = $awardCollection->skipUntil(function ($fleet) {
                return $fleet === '767' || $fleet === '747';
            })->splice(0,5);
        }

        $request = new Request([
            'base_seniority' => $awardCollection[0],
            'emp' => $newHire ? 0 : $awardCollection[1],
            'base' => $newHire ? $awardCollection[2] : $employee->domicile,
            'fleet' => $newHire ? $awardCollection[3] : $subset[0],
            'seat' => $newHire ? $awardCollection[4] : $subset[1],
            'award_base' => $newHire ? $awardCollection[2] : $subset[2],
            'award_fleet' => $newHire ? $awardCollection[3] : $subset[3],
            'award_seat' => $newHire ? $awardCollection[4] : $subset[4],
            'month' => $this->month()
        ]);

        return $request;
    }

    protected function validate($request)
    {
        $validator = Validator::make($request->all(), [
            'base_seniority' => 'required|integer',
            'emp' => 'required|integer',
            'base' => 'required|string|in:ANC,CVG,HHN,HSV,IAH,ICN,JFK,LAX,MIA,NRT,ONT,ORD,PAE,SYD,TPE',
            'fleet' => 'required|string|in:767,747',
            'seat' => 'required|string|in:CA,FO',
            'award_base' => 'required|string|in:ANC,CVG,HHN,HSV,IAH,ICN,JFK,LAX,MIA,NRT,ONT,ORD,PAE,SYD,TPE',
            'award_seat' => 'required|string|in:CA,FO',
            'award_fleet' => 'required|string|in:767,747',
            'month' => 'required|date'
        ]);

        return $validator;
    }

    public function validated()
    {
        $validatedRequests = collect();
        $collection = $this->collectedRows();
        foreach($collection as $awardCollection) {
            if($this->checkForNewHire($awardCollection)) {
                $request = $this->createRequest($awardCollection, true);
                $validator = $this->validate($request);
                $errors = collect($validator->errors()->all());
                if($errors->isEmpty()) {
                    $validatedRequests->push($request);
                } else {
                    return [
                        'status' => 'failed',
                        'message' => $errors->first() . ' New Hire Row # ' . $awardCollection[0]
                    ];
                }
            } else {
                $request = $this->createRequest($awardCollection, false);
                $validator = $this->validate($request);
                $errors = collect($validator->errors()->all());
                if($errors->isEmpty()) {
                    $validatedRequests->push($request);
                } else {
                    return [
                        'status' => 'failed',
                        'message' => $errors->first() . ' Employee Hire Row # ' . $awardCollection[0]
                    ];
                }
            }   
        }
        
        return [
            'status' => 'passed',
            'validatedRequests' => $validatedRequests
        ];
    }

    public function saveAwards($validatedRequests)
    {
        Vacancy::truncate();

        foreach($validatedRequests as $request) {
            Vacancy::create([
                'base_seniority' => $request->base_seniority,
                'emp' => $request->emp,
                'base' => $request->base,
                'fleet' => $request->fleet,
                'seat' => $request->seat,
                'award_base' => $request->award_base,
                'award_seat' => $request->award_seat,
                'award_fleet' => $request->award_fleet,
                'month' => $this->month()
            ]);
        }

        return true;
    }
}

