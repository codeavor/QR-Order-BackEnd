<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\OrderItem;
use App\Models\Extra;
use App\Models\Order;
use App\Models\Item;

class OrderItemTest extends TestCase
{

    use RefreshDatabase;

    public function testOrderItemRelations()
    {
        $item = Item::factory()->create();
        $order = Order::factory()->create();
        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'item_id' => $item->id,
            'quantity' => 2
        ]);        
        $extra = Extra::factory()->create();

        // Tests for extra relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $orderItem->extras); 
    }
}
