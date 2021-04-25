<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AmeRating;
use Tests\TestCase;
use App\Models\Ame;

class AmeRatingTest extends TestCase
{
    use RefreshDatabase;

    public function test_ame_rating_belongs_to_ame_relationship()
    {
        $rating = AmeRating::factory()->create();
        $this->assertInstanceOf(Ame::class, $rating->ame);
    }
}
