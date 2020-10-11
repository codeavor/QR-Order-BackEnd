<?php

namespace Tests\Feature\Apis;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\Role;
use App\Models\UserType;
use App\Models\OrderItem;
use App\Models\Extra;
use Tests\TestCase;

class CartTest extends TestCase
{
    
    use RefreshDatabase;

    protected $category, $item, $role, $userType, $orderItem, $order;

    public function setUp():void
    {
        parent::setUp();
        $this->extra = Extra::factory()->create();
        $this->category = Category::factory()->create();
        $this->item = Item::factory()->create();
        $this->category->items()->save($this->item);
        $this->order = Order::factory()->create();
        $this->role = Role::factory()->create();
        $this->item->orders()->attach($this->order, ['quantity' => 2]);
        $this->extra->items()->attach($this->item);
        $this->userType = new UserType;
        $this->role->userTypes()->save($this->userType);
        $this->userType->orders()->save($this->order);
        $this->orderItem = OrderItem::where('order_id', $this->order->id)->first();
        $this->orderItem->extras()->attach($this->extra);
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

        $this->json('PUT', route('cart.update', 1000), $updatedData)
             ->assertStatus(404);
        
    }

    public function testDeleteOrderItem()
    {
        $this->json('DELETE', route('cart.destroy', $this->order->id))
             ->assertNoContent($status = 204);   
             
        $this->json('DELETE', route('cart.destroy', 1000))
             ->assertStatus(404);      
    }
}