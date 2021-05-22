<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class NewhiresController extends Controller
{
    public function index()
    {
        $newhires = Vacancy::where('new_hire', true)->get()->sortBy('award_fleet');
        return response()->json(['data' => $newhires], 200);
    }
}
