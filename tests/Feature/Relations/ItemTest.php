<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Category;

class ItemTest extends TestCase
{

    use RefreshDatabase;

    public function testItemRelations()
    {
        $item = Item::factory()->create();
        $category = Category::factory()->create();

        $item->category()->associate($category)->save();

        // Tests for category relation one to many
        $this->assertEquals(1, $item->category->count());
        $this->assertInstanceOf(Category::class, $item->category);

        // Tests for order relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $item->orders); 

        // Tests for extraCategory relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $item->extra_categories);
    }
}
