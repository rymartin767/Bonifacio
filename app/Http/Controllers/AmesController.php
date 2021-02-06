<?php

namespace App\Http\Controllers;

use App\Models\Ame;

class AmesController extends Controller
{
    public function store()
    {
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

    public function destroy()
    {
        $id = request('id');
        $deleted = Ame::find($id)->delete();

        if($deleted) {
            return response()->json([
                'status' => 201
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }
}
