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

        return response()->json([
            'status' => 201,
            'data' => $airlines
        ]);
    }

    public function show()
    {
        try {
            $airline = Airline::where('icao', request('icao'))->sole()->load('scales');
            $json = json_decode(file_get_contents('json/airlines.json'));
            $icao = $airline->icao;
            return response()->json([
                'status' => 201,
                'data' => [
                    'profile' => $airline,
                    'quals' => $json->$icao->quals ?? []
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404
            ]);
        }
    }
}
