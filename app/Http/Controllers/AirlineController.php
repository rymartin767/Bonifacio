<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index()
    {
        $search = request('search') ?? '';
        return Airline::where('name', 'like', '%'.$search.'%')->get();
    }

    public function show(Airline $airline)
    {
        return $airline->load('scales');
    }
}
