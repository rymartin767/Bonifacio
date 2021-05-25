<?php

namespace App\MyClasses;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Seniority;
use Carbon\Carbon;
use Exception;

class SeniorityList
{
    public function __construct(public string $pathToTsv)
    {
        $this->month = Carbon::parse(Str::of($this->pathToTsv)->replace('_', '/')->substr(-14, 10));
    }

    public function parsedTsvToCollection() : Collection
    {
        try {
            $parsed = collect();

            $tsvFileContents = Storage::disk('s3')->get($this->pathToTsv);
            
            $rows = explode("\r\n", $tsvFileContents);
            foreach($rows as $row) { 
                $data = explode("\t", $row);
                $data = array_filter($data);
                $data = collect(array_values($data));
                $parsed->push($data);
            }
    
            return $parsed;
        } catch (Exception) {
            return collect();
        }
    }

    public function makePilotRequest($pilot) : Request
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
            'month' => $this->month
        ]);

        return $request;
    }

    public function validatePilotRequest($request)
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

    public function storePilotData(Collection $validated)
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
                'month' => $this->month
            ]);
            $total++;
        }

        return $total;
    }
}