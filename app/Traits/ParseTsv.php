<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Carbon\Carbon;

Trait parseTsv
{
    protected function parseMonth($pathToTsv)
    {
        return Carbon::parse(Str::of($pathToTsv)->replace('_', ' ')->substr(-12, 8));
    }

    public function parseDataToRows($tsv)
    {
        $rows = explode("\r\n", $tsv);
        return $rows;
    }

    public function parseRowToCollection($row)
    {
        $collection = explode("\t", $row);
        $collection = array_filter($collection);
        $collection = collect(array_values($collection));
        return $collection;
    }
}