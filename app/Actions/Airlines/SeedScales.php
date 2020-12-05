<?php

namespace App\Actions\Airlines;

use Illuminate\Support\Facades\Storage;
use Exception;

trait SeedScales
{
    public function seedScales()
    {
        try {
            $file = Storage::disk('s3-public')->get('/scales/' . $this->icao . '.csv');
            $lines = explode("\r\n", $file);
            foreach($lines as $line) {
                $scale = explode(",", $line);
                $this->scales()->create([
                    'year' => $scale[0],
                    'fleet' => $scale[1],
                    'ca' => $scale[2],
                    'fo' => $scale[3]
                ]);
            }
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
}