<?php

namespace App\Http\Controllers;

use App\Models\Airline;

class AirlineController extends Controller
{
    public function index()
    {
        // returned in data key
        return Airline::when(request('hiring'), function ($query) {
            return $query
                ->where('name', 'like', '%' . request('search') . '%')
                ->where('hiring', true)
                ->orderBy('updated_at', 'desc')
                ->paginate(25);
        }, function ($query) {
            return $query
                ->where('name', 'like', '%' . request('search') . '%')
                ->orderBy('updated_at', 'desc')
                ->paginate(25);
        })->toJson();
    }

    public function show()
    {
        if(request('icao')) {
            $airline = Airline::where('icao', request('icao'))->first();
            if($airline) {
                $json = json_decode(file_get_contents('json/airlines.json'));
                $icao = $airline->icao;
                return response()->json([
                    'status' => 201,
                    'data' => [
                        'airline' => $airline->load('scales'),
                        'quals' => $json->$icao->quals ?? []
                    ]
                ]);
            }
        }

        return response()->json([
            'status' => 404
        ]);
    }
}
