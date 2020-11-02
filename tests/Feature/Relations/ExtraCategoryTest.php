<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ExtraCategory;

class ExtraCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExtraCategoryRelations()
    {
        $extraCategory = ExtraCategory::factory()->create();

        // Tests for extras relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $extraCategory->extras); 

        // Tests for items relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $extraCategory->items);
    }
}
