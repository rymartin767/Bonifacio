<?php

namespace App\Http\Controllers;

use App\Models\Seniority;

class VerifyEmploymentController extends Controller
{
    public function show()
    {
        if(request('employee')) {
            $sen = Seniority::where('emp', request('employee'))->get()->sortBy('month')->last()->sen;

            return response()->json([
                'status' => 201,
                'data' => $sen
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }
}
