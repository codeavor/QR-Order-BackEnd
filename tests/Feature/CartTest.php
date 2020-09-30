<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Category;
use App\Models\Item;
use App\Models\Umbrella;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Extra;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected $category, $item, $umbrella, $order;

    public function setUp():void
    {
        parent::setUp();
        $this->extra = Extra::factory()->create();
        $this->category = Category::factory()->create();
        $this->item = Item::factory()->create();
        $this->category->items()->save($this->item);
        $this->umbrella = Umbrella::factory()->create();
        $this->order = Order::factory()->create();
        $this->umbrella->orders()->save($this->order);
        $this->item->orders()->attach($this->order, ['quantity' => 2]);
        $this->extra->items()->attach($this->item);

        $this->orderitem = OrderItem::where('order_id', $this->order->id)->first();

        $this->orderitem->extras()->attach($this->extra);
    }

    public function testShowCart()
    {
        $this->get(route('cart.show', $this->order->id))->assertStatus(200)
        ->assertJsonStructure([[
            'order_item_id',
            'quantity',
            'extras',
            'extra_price',
            'name',
            'price'
        ]]);

        $this->get(route('cart.show', 100))->assertStatus(404);
    }

    public function testUpdateCart()
    {
        $updatedData = [
            'order_complete' => true
        ];

        $this->json('PUT', route('cart.update', $this->order->id), $updatedData)
             ->assertStatus(200)
             ->assertJson($updatedData);

        
    }

    public function testDeleteOrderItem()
    {
        $this->json('DELETE', route('cart.destroy', $this->order->id))
             ->assertNoContent($status = 204);             
    }
}
