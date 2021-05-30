<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\Event;
use App\Models\User;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    private function asSanctum()
    {
        return Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }
    
    public function test_event_user_id_is_required()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['user_id' => '']));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);
    }

    public function test_event_user_id_is_numeric()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['user_id' => 'string']));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_title_is_required()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['title' => '']));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_title_is_a_string()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['title' => 1223]));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_title_min_string_length()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['title' => 'A']));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_title_max_string_length()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['title' => str_repeat('a', 51)]));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_date_validation()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['date' => 'not a valid date']));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_time_is_nullable()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['time' => null]));
        $response->assertStatus(201);    
    }

    public function test_event_time_validation()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['time' => 'not a valid time']));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_image_is_nullable()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['image' => null]));
        $response->assertStatus(201);    
    }

    public function test_event_image_string_validation()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['image' => 12234]));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_image_string_min_length()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['image' => 'a']));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_image_string_max_length()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['image' => str_repeat('a', 101)]));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_url_is_nullable()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['url' => null]));
        $response->assertStatus(201);    
    }

    public function test_event_url_is_a_string()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['url' => 122]));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_url_string_min_length()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['url' => 'a']));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }

    public function test_event_url_string_max_length()
    {
        $this->asSanctum();

        $response = $this->post('/api/events', Event::factory()->raw(['url' => str_repeat('a', 101)]));
        $response->assertExactJson(['data' => [
            'errors' => 'The given data was invalid.']], 422);    
    }
}
