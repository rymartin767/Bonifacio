<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;
use App\Models\Ame;

class AmeCommentsTest extends TestCase
{
    use RefreshDatabase;

    private function asSanctum()
    {
        return Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    public function test_a_422_response_is_returned_if_ame_model_is_not_found()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames/1/comments', ['user_id' => 1, 'body' => 'Testing the ames comments api']);
        $response->assertExactJson(['data' => ['AME Model Not Found!']], 422);
    }

    public function test_a_422_response_is_returned_if_validation_exception_is_caught_during_storage()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames/1/comments', ['user_id' => 1, 'body' => 'api']);
        $response->assertExactJson(['data' => ["The given data was invalid."]], 422);
    }

    public function test_a_201_response_is_returned_if_ame_comment_is_stored()
    {
        $this->asSanctum();

        $ame = Ame::factory()->create();

        $response = $this->post('/api/ames/1/comments', ['user_id' => 1, 'body' => 'Testing the ames comments api']);
        $response->assertExactJson(['data' => ['success']], 201);

        $this->assertDatabaseHas('ame_comments', ['id' => 1, 'user_id' => 1]);
        $this->assertCount(1, $ame->comments);
    }
}
