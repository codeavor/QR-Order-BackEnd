<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Category;
use App\Models\Item;
use App\Models\Umbrella;
use App\Models\Order;
use App\Models\Extra;
use App\Models\OrderItem;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    
    use RefreshDatabase;

    protected $orderitem, $category, $item, $umbrella, $order;

    public function setUp():void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->item = Item::factory()->create();
        $this->category->items()->save($this->item);
        $this->umbrella = Umbrella::factory()->create();
        $this->order = Order::factory()->create();
        $this->umbrella->orders()->save($this->order);

        $this->orderitem = OrderItem::create([
            'order_id' => $this->order->id,
            'item_id' => $this->item->id,
            'quantity' => 2
        ]);
    }

    public function testUpdateOrderItem()
    {
        $updatedData = [
            'quantity' => 1
        ];

        $this->json('PUT', route('order_item.update', $this->orderitem->id), $updatedData)
             ->assertStatus(200)
             ->assertJson($updatedData);


        $this->json('PUT', route('order_item.update', 1000), $updatedData)
             ->assertStatus(404);

        $updatedData = [
            'quantity' => 0
        ];

        $this->json('PUT', route('order_item.update', $this->orderitem->id), $updatedData)
             ->assertStatus(403);
    }

    public function testDeleteOrderItem()
    {                               
        $this->json('DELETE', route('order_item.destroy', 1000))
             ->assertStatus(404); 

        $this->json('DELETE', route('order_item.destroy', $this->orderitem->id))
             ->assertNoContent($status = 204);           
    }

	public function testStoreOrderItem()
    {
        $extra = Extra::factory()->create();
        $data = [
            'item_id' => $this->item->id,
            'order_id' => $this->order->id,
            'quantity' => 5,
            'extras_id' => [$extra->id],
        ];

        $this->json('POST', route('order_item.store'),$data)
        ->assertStatus(201);

    }
}
