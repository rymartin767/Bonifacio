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
            'zip' => 'required|string|size:5',
            'phone' => 'required|string|size:10',
        ]);

        $ame = Ame::create($attributes);

        if($ame) {
            return response()->json(['data' => $ame], 201);
        }

        return response()->json(['data' => []], 404);
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

        foreach($ames as $ame) {
            $ame->phone = $ame->phone;
            $ame->rating = $ame->averageRating;
        }

        return response()->json(['data' => $ames], 200);
    }

    public function destroy()
    {
        $id = request('id');
        $ame = Ame::find($id);
        $deleted = $ame->delete();

        if($deleted) {
            return response()->json(['data' => []], 200);
        }

        return response()->json(['data' => []], 404);
    }
}
