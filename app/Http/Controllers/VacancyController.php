<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class VacancyController extends Controller
{
    public function index()
    {
        return Vacancy::all()->toJson();
    }

    public function show()
    {
        $award = Vacancy::where('emp', request('employee'))->first();
        if(!is_null($award)) {
            return response()->json([
                'status' => 200,
                'data' => $award
            ]);
        }

        return response()->json([
            'status' => 403
        ]);
    }
}
