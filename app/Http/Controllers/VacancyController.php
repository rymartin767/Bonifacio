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
        $employee = request('employee');
        return Vacancy::where('emp', $employee)->first()->toJson();
    }
}
