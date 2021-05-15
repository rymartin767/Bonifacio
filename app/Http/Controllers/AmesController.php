<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Ame;
use Exception;

class AmesController extends Controller
{
    public function store()
    {
        try {
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
        } catch (Exception $e) {
            return response()->json(['data' => [$e->getMessage()]], 422);
        }
    }

    public function index()
    {
        $ames = Ame::latest()->state(request('state'))->search(request(['search']))->get();

        return response()->json(['data' => $ames], 200);
    }

    public function show($id)
    {
        $ame = Ame::find($id);

        if($ame) {
            $ame = $ame->load('comments');

            return response()->json(['data' => $ame], 200);
        }

        return response()->json(['data' => ['Model Not Found (You should be excepted, but are not']], 404);
    }

    public function destroy($id)
    {
        $ame = Ame::destroy($id);

        if($ame) {
            return response()->json(['data' => ['Success!']], 200);
        }

        return response()->json(['data' => ['Model Not Found (You should be excepted, but are not']], 404);
    }
}
