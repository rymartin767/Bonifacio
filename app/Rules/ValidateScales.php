<?php

namespace App\Rules;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;

class ValidateScales implements Rule
{
    public function passes($attribute, $value)
    {
        try {
            $file = Storage::disk('s3')->get('/scales/csv/' . $value . '.csv');
            $lines = explode("\r\n", $file);
            foreach($lines as $line) {
                $scale = explode(",", $line);
                $request = new HttpRequest([
                    'year' => $scale[0],
                    'fleet' => $scale[1],
                    'ca' => $scale[2],
                    'fo' => $scale[3]
                ]);

                Validator::make($request->all(), [
                    'year' => 'required|numeric|between:1,15',
                    'fleet' => 'required',
                    'ca' => 'required|numeric|between:50,400',
                    'fo' => 'required|numeric|between:50,400'
                ]);
            }
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Scales for this airline have failed validation.';
    }
}
