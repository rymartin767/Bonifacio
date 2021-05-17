<?php

namespace App\MyClasses;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Vacancy;
use Carbon\Carbon;

class VacancyList
{
    public function __construct(public string $pathToFile)
    {
    }

    public function month()
    {
        return Carbon::parse(Str::of($this->pathToFile)->replace('_', ' ')->substr(-12, 8));
    }

    public function rows(): Collection
    {
        $content = Storage::get($this->pathToFile);
        $rows = explode("\r\n", $content);

        $collection = collect();
        foreach($rows as $row) {
            $c = explode("\t", $row);
            $c = array_filter($c);
            $collection->push(array_values($c)); //array_values adds index to each item.... [0] => '1' (not required in this instance but used)
        }

        return $collection;
    }

    public function createRequests(Collection $rows)
    {
        $requests = collect();

        foreach($rows as $award) {
            $award = collect($award);
    
            // find the first instance of a domicile (which is the current base) and return 6 values 
            $subset = $award->skipUntil(function ($domicile) {
                return $domicile === 'ANC' || $domicile === 'CVG' || $domicile === 'JFK' || $domicile === 'LAX' || $domicile === 'MIA' || $domicile === 'ONT' || $domicile === 'ORD';
            })->splice(0,6);
            
            $request = new Request([
                'base_seniority' => $award[0],
                'emp' => $award[1],
                'base' => $subset[0],
                'fleet' => $subset[1],
                'seat' => $subset[2],
                'award_base' => $subset[3],
                'award_fleet' => $subset[4],
                'award_seat' => $subset[5],
                'new_hire' => $award[2] === 'HIRED' ? true : false,
                'month' => $this->month()
            ]);

            $requests->push($request);
        }

        return $requests;
    }

    public function validate($request)
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
            'new_hire' => ['required', 'boolean'],
            'month' => 'required|date'
        ]);

        return $validator;
    }

    public function save($request)
    {
        Vacancy::create([
            'base_seniority' => $request->base_seniority,
            'emp' => $request->emp,
            'base' => $request->base,
            'fleet' => $request->fleet,
            'seat' => $request->seat,
            'award_base' => $request->award_base,
            'award_seat' => $request->award_seat,
            'award_fleet' => $request->award_fleet,
            'upgrade' => $request->seat === $request->award_seat ? false : true,
            'new_hire' => $request->new_hire,
            'month' => $this->month()
        ]);

        return true;
    }
}

