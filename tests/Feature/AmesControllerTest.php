<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;
use App\Models\Ame;

class AmesControllerTest extends TestCase
{
    use RefreshDatabase;

    private function asSanctum()
    {
        return Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    public function test_index_returns_ames_by_state_if_requested()
    {
        Ame::factory()->create();

        $this->asSanctum();
        $response = $this->get('/api/ames?state=OH');

        $response->assertJsonFragment(["state" => "OH"]);
    }

    public function test_index_returns_search_data_if_requested()
    {
        Ame::factory()->create(['name' => 'Ryan Martin']);

        $this->asSanctum();
        $response = $this->get('/api/ames?search=Ry');

        $response->assertJsonFragment(["name" => "Ryan Martin"]);
    }

    public function test_ames_store_success()
    {
        $this->asSanctum();
        $this->post('api/ames', Ame::factory()->raw())->assertStatus(201);
        
        $this->assertDatabaseHas('ames', ['id' => 1]);
    }
}
