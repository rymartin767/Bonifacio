<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;

class EventsControllerTest extends TestCase
{
    use RefreshDatabase;

    private function asSanctum()
    {
        return Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    public function test_a_200_response_is_returned_by_events_index()
    {
        $this->asSanctum();

        $response = $this->get('/api/events');
        $response->assertExactJson(['data' => []], 200);
    }

    public function test_a_422_response_is_returned_if_validation_exception_is_caught_during_events_store()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['user_id' => 'string']));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);
    }

    public function test_a_201_response_is_returned_if_event_is_stored()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw());
        $response->assertExactJson(['data' => 'Success'], 201);

        $this->assertDatabaseHas('events', ['id' => 1, 'user_id' => 1, 'title' => 'Event Title']);
    }

    public function test_a_404_response_is_returned_if_delete_event_fails()
    {
        $this->asSanctum();

        Event::factory()->create();

        $this->delete('/api/events/122')
            ->assertStatus(404)
            ->assertJsonFragment(['errors' => 'Model Not Found!']);

        $this->assertDatabaseHas('events', ['id' => 1, 'user_id' => 1, 'title' => 'Event Title']);
    }

    public function test_a_200_response_is_returned_if_delete_event_succeeds()
    {
        $this->asSanctum();

        Event::factory()->create();

        $this->delete('/api/events/1')
            ->assertStatus(200)
            ->assertJsonFragment(['data' => ['Success!']]);

        $this->assertDatabaseMissing('events', ['id' => 1, 'user_id' => 1, 'title' => 'Event Title']);
    }
}
