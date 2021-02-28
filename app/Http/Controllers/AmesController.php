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

    public function index()
    {
        // returned in data key
        $ames = Ame::when(request('state'), function ($query) {
            return $query
                ->where('state', request('state'))
                ->orderBy('updated_at', 'desc')
                ->get();
        }, function ($query) {
            return $query
                ->orderBy('updated_at', 'desc')
                ->get();
        });

        return response()->json([
            'status' => 201,
            'data' => $ames
        ]);
    }

    public function destroy()
    {
        $id = request('id');
        $ame = Ame::find($id);
        $deleted = $ame->delete();

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
