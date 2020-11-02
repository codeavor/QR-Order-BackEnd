<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Extra;

class ExtrasTest extends TestCase
{

    use RefreshDatabase;

    public function testExtraRelations()
    {
        $extra = Extra::factory()->create();

        // Tests for orderItem relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $extra->orderItems); 

        // Tests for extraCategory relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $extra->extra_categories);
    }
}
