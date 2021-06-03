<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Ame;
use Tests\TestCase;

class AmeTest extends TestCase
{
    use RefreshDatabase;
    
    private function asSanctum()
    {
        return Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }
    
    public function test_ame_name_is_required()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames', Ame::factory()->raw(['name' => '']));
        $response->assertExactJson(['data' => [
            'errors' => [
                'name' => [
                    'The name field is required.'
                ]
            ]]], 422);
    }

    public function test_ame_name_is_a_string()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames', Ame::factory()->raw(['name' => 123]));
        $response->assertExactJson(['data' => [
            'errors' => [
                'name' => [
                    'The name must be a string.',
                    'The name format is invalid.'
                ]
            ]]], 422);
    }

    public function test_ame_name_is_2_chars_minimum()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames', Ame::factory()->raw(['name' => 'R']));
        $response->assertExactJson(['data' => [
            'errors' => [
                'name' => [
                    'The name must be at least 2 characters.'
                ]
            ]]], 422);
    }

    public function test_ame_name_is_50_chars_max()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames', Ame::factory()->raw(['name' => str_repeat('a', 51)]));
        $response->assertExactJson(['data' => [
            'errors' => [
                'name' => [
                    'The name may not be greater than 50 characters.'
                ]
            ]]], 422);
    }

    public function test_ame_name_regex_for_numerics()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames', Ame::factory()->raw(['name' => 'Ry3n Martin']));
        $response->assertExactJson(['data' => [
            'errors' => [
                'name' => [
                    'The name format is invalid.'
                ]
            ]]], 422);
    }

    public function test_ame_street_is_required()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames', Ame::factory()->raw(['street' => '']));
        $response->assertExactJson(['data' => [
            'errors' => [
                'street' => [
                    'The street field is required.'
                ]
            ]]], 422);
    }

    public function test_ame_street_is_a_string()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames', Ame::factory()->raw(['street' => 12345345]));
        $response->assertExactJson(['data' => [
            'errors' => [
                'street' => [
                    'The street must be a string.'
                ]
            ]]], 422);
    }

    public function test_ame_street_is_5_chars_minimum()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames', Ame::factory()->raw(['street' => 'R']));
        $response->assertExactJson(['data' => [
            'errors' => [
                'street' => [
                    'The street must be at least 5 characters.'
                ]
            ]]], 422);
    }

    public function test_ame_street_is_50_chars_max()
    {
        $this->asSanctum();

        $response = $this->post('/api/ames', Ame::factory()->raw(['street' => str_repeat('a', 51)]));
        $response->assertExactJson(['data' => [
            'errors' => [
                'street' => [
                    'The street may not be greater than 50 characters.'
                ]
            ]]], 422);
    }

    public function test_ame_name_and_street_are_unique()
    {
        $this->asSanctum();
        $ame = Ame::factory()->create();

        $response = $this->post('/api/ames', Ame::factory()->raw(['name' => $ame->name, 'street' => $ame->street]));
        $response->assertExactJson(['data' => [
            'errors' => [
                'name' => [
                    'The name has already been taken.'
                ]
            ]]], 422);
    }
}
