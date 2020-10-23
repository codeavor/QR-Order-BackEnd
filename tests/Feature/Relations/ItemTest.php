<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Category;
use App\Models\Order;
use App\Models\Extra;

class ItemTest extends TestCase
{

    use RefreshDatabase;

    public function testItemRelations()
    {
        $item = Item::factory()->create();
        $category = Category::factory()->create();
        $order = Order::factory()->create();
        $extra = Extra::factory()->create();

        $item->category()->associate($category)->save();

        // Tests for category relation one to many
        $this->assertEquals(1, $item->category->count());
        $this->assertInstanceOf(Category::class, $item->category);

        // Tests for order relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $item->orders); 

        // Tests for extra relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $item->extras);
    }
}
