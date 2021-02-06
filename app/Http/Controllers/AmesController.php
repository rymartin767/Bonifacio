<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ame;
use Exception;

class AmesController extends Controller
{
    public function store(Request $request)
    {
        try {
            $ame = Ame::create($request);

            if($ame) {
                return response()->json([
                    'status' => 201,
                    'data' => $ame
                ]);
            }

            return response()->json([
                'status' => 404
            ]);
        } catch(Exception $e) {
            return $e;
        }
    }
}
