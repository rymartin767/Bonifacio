<?php

namespace App\Http\Controllers;

use App\Models\Ame;

class AmesController extends Controller
{
    public function store()
    {
        return request()->all();
        
        $ame = Ame::create([
            'name' => request('name'),
            'street' => request('street'),
            'city' => request('city'),
            'state' => request('state'),
            'zip' => request('zip'),
            'phone' => request('phone'),
        ]);

        if($ame) {
            return response()->json([
                'status' => 201,
                'data' => $ame
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }
}
