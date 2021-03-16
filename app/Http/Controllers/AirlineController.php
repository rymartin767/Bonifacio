<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AirlineController extends Controller
{
    public function index()
    {
        // returned in data key
        $airlines = Airline::when(request('hiring'), function ($query) {
            return $query
                ->where('name', 'like', '%' . request('search') . '%')
                ->where('hiring', true)
                ->orderBy('updated_at', 'desc')
                ->get();
        }, function ($query) {
            return $query
                ->where('name', 'like', '%' . request('search') . '%')
                ->orderBy('updated_at', 'desc')
                ->get();
        });

        return response()->json(['data' => $airlines], 200);
    }

    public function show()
    {
        $airline = Airline::where('icao', request('icao'))->sole()->load('scales');
        if($airline) {
            $json = json_decode(file_get_contents('json/airlines.json'));
            $icao = $airline->icao;
            return response()->json([
                'data' => [
                    'profile' => $airline,
                    'quals' => $json->$icao->quals ?? []
                ], 200
            ]);
        }

        return response()->json(['data' => []], 404);
    }
}
