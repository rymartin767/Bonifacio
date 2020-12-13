<?php

namespace App\Http\Controllers;

use App\Models\Airline;

class AirlineController extends Controller
{
    public function index()
    {
        $search = request('search') ?? '';
        $hiring = request('hiring');
        
        return Airline::where('name', 'like', '%'.$search.'%')
            ->where('hiring', $hiring)
            ->get()->toJson();
    }

    public function show(Airline $airline)
    {
        return $airline->load('scales')->toJson();
    }
}
