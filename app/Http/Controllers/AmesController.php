<?php

namespace App\Http\Controllers;

use App\Models\Ame;
use Illuminate\Validation\Rule;

class AmesController extends Controller
{
    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|string|min:5|max:50',
            'street' => 'required|string|min:5|max:50',
            'city' => 'required|string|min:2|max:50',
            'state' => ['required', Rule::in(config('general.states'))],
            'zip' => 'required|string|min:5|max:12',
            'phone' => 'required|string|min:7|max:12',
        ]);

        $ame = Ame::create($attributes);

        if($ame) {
            return response()->json(['data' => $ame], 201);
        }

        return response()->json(['data' => 'Failed to create resource.'], 404);
    }

    public function index()
    {
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

        return response()->json(['data' => $ames], 200);
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
