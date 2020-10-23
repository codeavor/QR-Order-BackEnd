<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Extra;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Order;

class ExtrasTest extends TestCase
{

    use RefreshDatabase;

    public function testExtraRelations()
    {
        $extra = Extra::factory()->create();
        $item = Item::factory()->create();
        $order = Order::factory()->create();
        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'item_id' => $item->id,
            'quantity' => 2
        ]); 

        // Tests for orderItem relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $extra->orderItems); 

        // Tests for extra relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $extra->items);
    }
}
