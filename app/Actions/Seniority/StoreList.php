<?php

namespace App\Actions\Seniority;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Seniority;
use Carbon\Carbon;
use Exception;


trait StoreList
{
    protected function validatePilotData(string $pathToCsv, Carbon $month)
    {
        $validated = collect([]);
        
        try {
            $csv = Storage::disk('s3')->get($pathToCsv);

            foreach ($this->explodePilotData($csv) as $pilot) {
                $request = $this->makePilotRequest($pilot, $month);
                
                $validator = $this->validatePilotRequest($request);
                
                if ($validator->fails()) {
                    $error = $validator->errors()->first();
                } else {
                    $validated->push($request);
                }
            }
            
            return $validated;
        } catch (Exception $e) {
            //
        }
    }

    protected function explodePilotData($csv)
    {
        $pilots = collect([]);

        try {
            $rows = explode("\r\n", $csv);
            foreach($rows as $row) { 
                $data = explode(",", $row);
                $data = array_filter($data);
                $data = collect(array_values($data));
                $pilots->push($data);
            }
        } catch (Exception $e) {
            //
        }
    
        return $pilots;
    }

    protected function makePilotRequest($pilot, Carbon $month)
    {
        $act = $pilot[count($pilot)-2];
        if($act == 'LOA' || $act == 'MIL' || $act == 'MGMT' ||  $act == 'LMED') {
            $active = 0;
            $domicile = $pilot[count($pilot) - 3];
            $fleet = $pilot[count($pilot) - 4];
            $seat = $pilot[count($pilot) - 5];
        } else {
            $seat = $fleet = $domicile = $active = null;
        }
        
        $request = new Request([
            'sen' => $pilot[0],
            'phire' => $pilot[1],
            'emp' => $pilot[2],
            'doh' => Carbon::parse($pilot[3]),
            'seat' => $seat ?? $pilot[count($pilot) - 4],
            'fleet' => $fleet ?? $pilot[count($pilot) - 3],
            'domicile' => $domicile ?? $pilot[count($pilot) - 2],
            'retire' => Carbon::parse($pilot[count($pilot) - 1]),
            'active' => $active ?? true,
            'month' => $month
        ]);

        return $request;
    }

    protected function validatePilotRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'sen' => 'required|numeric|digits_between:1,4',
            'phire' => 'required|integer|digits_between:1,4',
            'emp' => 'required|numeric|digits_between:3,6',
            'doh' => 'required|date',
            'seat' => 'required|string|in:CA,FO',
            'fleet' => 'required|string|in:767,747',
            'domicile' => 'required|string|in:ANC,CVG,HHN,HSV,IAH,ICN,JFK,LAX,MIA,NRT,ONT,ORD,PAE,SYD,TPE',
            'retire' => 'required|date',
            'active' => 'boolean',
            'month' => 'required|date'
        ]);

        return $validator;
    }

    protected function storePilotData(Collection $validated, Carbon $month)
    {
        $total = 0;
        foreach ($validated as $pilot) {
            Seniority::create([
                'sen' => $pilot->sen,
                'phire' => $pilot->phire,
                'emp' => $pilot->emp,
                'doh' => Carbon::parse($pilot->doh),
                'seat' => $pilot->seat,
                'fleet' => $pilot->fleet,
                'domicile' => $pilot->domicile,
                'retire' => Carbon::parse($pilot->retire),
                'active' => $pilot->active,
                'month' => $month
            ]);
            $total++;
        }
    }
}