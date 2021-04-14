<?php

namespace App\Http\Controllers;

use App\Models\Ame;
use Illuminate\Validation\Rule;

class AmesController extends Controller
{
    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'string', 'min:5', 'max:50', 'regex:/^([^0-9]*)$/'],
            'street' => ['required', 'string', 'min:5', 'max:50'],
            'city' => ['required', 'string', 'min:2', 'max:75'],
            'state' => ['required', Rule::in(
                [ 'AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 
                    'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 
                    'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 
                    'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 
                    'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 
                    'WA', 'WV', 'WI', 'WY' ]
            )],
            'zip' => ['required', 'numeric', 'digits:5'],
            'phone' => ['required', 'regex:/^(\+0?1\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/'],
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

        return response()->json(['data' => $ames], 200);
    }

    public function destroy()
    {
        $id = request('id');
        $ame = Ame::find($id);
        $deleted = $ame->delete();

        if($deleted) {
            return response()->json(['data' => []], 201);
        }

        return response()->json(['data' => []], 404);
    }
}
