<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AmeRating;
use Tests\TestCase;

class AmeCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_404_response_is_returned_if_ame_is_not_found()
    {
        $response = $this->postJson('/api/ameComments', AmeRating::factory()->raw(['user_id' => 434]));
        $response->assertExactJson(['data' => []], 404);
    }

    public function test_a_422_response_is_returned_if_validation_exception_is_caught_during_storage()
    {
        $response = $this->postJson('/api/ameComments', AmeRating::factory()->raw(['user_id' => 'string']));
        $response->assertExactJson(['data' => []], 422);
    }
}
