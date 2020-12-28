<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::all();

        if($vacancies) {
            return response()->json([
                'status' => 201,
                'data' => $vacancies
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }

    public function show()
    {
        $award = Vacancy::where('emp', request('employee'))->first();
        if($award) {
            return response()->json([
                'status' => 201,
                'data' => $award
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }
}
