<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Umbrella;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UmbrellaApiTest extends TestCase
{

    use RefreshDatabase;

    public function testShowUmbrella()
    {
        $umbrella = Umbrella::factory()->create();

        $this->get(route('specific_umbrella', $umbrella->id))->assertStatus(200)
        ->assertJson($umbrella->toArray())
        ->assertJsonStructure([
            'id'
        ]);
        $this->get(route('specific_umbrella', 100))->assertStatus(404);
    }
}
