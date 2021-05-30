<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Ame;
use Exception;
use Illuminate\Validation\ValidationException;

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
                'zip' => ['required', 'regex:/^[0-9]{5}(?:-[0-9]{4})?$/'],
                'phone' => ['required', 'regex:/^\(?([0-9]{3})\)?[-.●]?([0-9]{3})[-.●]?([0-9]{4})$/'],
                'url' => ['present', 'nullable', 'regex:#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#iS']
            ]);

            $ame = Ame::create($attributes);
            
            return response()->json(['data' => $ame], 201);
        } catch (ValidationException $e) {
            return response()->json(['data' => [
                'errors' => $e->errors()
            ]], 422);
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

        return response()->json(['data' => [
            'errors' => 'Model Not Found!'
        ]], 404);
    }

    public function destroy($id)
    {
        $ame = Ame::destroy($id);

        if($ame) {
            return response()->json(['data' => ['Success!']], 200);
        }

        return response()->json(['data' => [
            'errors' => 'Model Not Found!'
        ]], 404);
    }
}
