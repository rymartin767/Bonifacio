<?php

namespace App\Http\Controllers;

use App\Models\Ame;
use Exception;
use Illuminate\Validation\Rule;

class AmesController extends Controller
{
    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'string', 'min:5', 'max:50', 'regex:/^([^0-9]*)$/'],
            'street' => ['required', 'string', 'min:5', 'max:50'],
            'city' => ['required', 'string', 'min:2', 'max:75'],
            'state' => ['required', Rule::in(config('general.states'))],
            'zip' => ['required', 'numeric', 'digits:5'],
            'phone' => ['required', 'regex:/^(\+0?1\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/'],
        ]);

        $ame = Ame::create($attributes);
        
        return response()->json(['data' => $ame], 201);
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

    public function destroy($id)
    {
        $ame = Ame::destroy($id);

        if($ame) {
            return response()->json(['data' => ['Success']], 200);
        }

        return response()->json(['data' => ['Failed. Could not find record to destroy by provided id']], 404);
    }
}
