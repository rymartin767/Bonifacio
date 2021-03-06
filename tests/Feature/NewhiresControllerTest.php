<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NewhiresControllerTest extends TestCase
{
    use RefreshDatabase;
    
    private function asSanctum()
    {
        return Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    public function test_upgrades_controller_index()
    {
        $this->asSanctum();

        $response = $this->get('api/newhires')
            ->assertStatus(200);
        
        $this->assertIsArray($response['data']);
    }
}
