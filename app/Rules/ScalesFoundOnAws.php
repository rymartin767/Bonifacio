<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ScalesFoundOnAws implements Rule
{
    public function passes($attribute, $value)
    {
        return Storage::disk('s3-public')->exists('scales/' . $value . '.csv');
    }

    public function message()
    {
        return 'The scales for this airline can not be found on public s3 bucket.';
    }
}
