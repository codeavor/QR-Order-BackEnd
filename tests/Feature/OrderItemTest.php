<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Category;
use App\Models\Item;
use App\Models\Umbrella;
use App\Models\Order;
use App\Models\OrderItem;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    
    use RefreshDatabase;

    protected $category, $item, $umbrella, $order;

    public function setUp():void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->item = Item::factory()->create();
        $this->category->items()->save($this->item);
        $this->umbrella = Umbrella::factory()->create();
        $this->order = Order::factory()->create();
        $this->umbrella->orders()->save($this->order);
        $this->item->orders()->attach($this->order, ['quantity' => 2]);
    }

    public function testUpdateOrderItem()
    {
        $updatedData = [
            'quantity' => 1
        ];

        $orderitem = OrderItem::where('order_id', $this->order->id)->first();

        $this->json('PUT', route('order_item.update', $orderitem->id), $updatedData)
             ->assertStatus(200)
             ->assertJson($updatedData);

        $updatedData = [
            'quantity' => 0
        ];

        $orderitem = OrderItem::where('order_id', $this->order->id)->first();

        $this->json('PUT', route('order_item.update', $orderitem->id), $updatedData)
             ->assertStatus(403);
    }

    public function testDeleteOrderItem()
    {
        $orderitem = OrderItem::where('order_id', $this->order->id)->first();

        $this->json('DELETE', route('order_item.destroy', $orderitem->id))
             ->assertNoContent($status = 204);             
    }
}
