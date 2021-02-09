<?php

namespace App\Http\Controllers;

use App\Models\Seniority;

class VerifyEmploymentController extends Controller
{
    public function show()
    {
        if(request('employee') && request('sen')) {
            $pilot = Seniority::where('emp', request('employee'))->where('sen', request('sen'))->get()->sortBy('month')->last();

            if(!is_null($pilot)) {
                return response()->json([
                    'status' => 201,
                    'data' => $pilot
                ]);
            }
        }

        return response()->json([
            'status' => 404
        ]);
    }
}
