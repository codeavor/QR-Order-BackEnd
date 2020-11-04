<?php

namespace Tests\Feature\Apis;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Category;
use App\Models\Item;
use App\Models\Role;
use App\Models\UserType;
use App\Models\Order;
use App\Models\Extra;
use App\Models\OrderItem;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    
    use RefreshDatabase;

    protected $orderItem, $category, $item, $role, $userType, $order, $token;

    public function setUp():void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->item = Item::factory()->create();
        $this->category->items()->save($this->item);
        $this->order = Order::factory()->create();
        $this->role = Role::factory()->create();
        $this->userType = new UserType;
        $this->role->userTypes()->save($this->userType);
        $this->userType->order()->save($this->order);
        $this->token = auth()->login($this->userType);
        $this->orderItem = OrderItem::create([
            'order_id' => $this->order->id,
            'item_id' => $this->item->id,
            'quantity' => 2
        ]);
        $this->role2 = Role::create([
            'name' => 'random'
        ]);
        $this->userType2 = new UserType;
        $this->role2->userTypes()->save($this->userType2);
        $this->token2 = auth()->login($this->userType2);
    }

    public function testUpdateOrderItem()
    {
        $updatedData = [
            'quantity' => 1
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('PUT', route('order_item.update', $this->orderItem->id), $updatedData)
        ->assertStatus(200);


        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('PUT', route('order_item.update', 1000), $updatedData)
        ->assertStatus(404);

        $updatedData = [
            'quantity' => 0
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('PUT', route('order_item.update', $this->orderItem->id), $updatedData)
        ->assertStatus(403);


        $this->withHeaders(['Authorization' => 'Bearer ' ])->json('PUT', route('order_item.update', $this->orderItem->id), $updatedData)
        ->assertStatus(401);

        $this->withHeaders(['Authorization' => 'Bearer aklsdjflaksjdf;laksdfnigga' ])->json('PUT', route('order_item.update', $this->orderItem->id), $updatedData)
        ->assertStatus(401);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token2])->json('PUT', route('order_item.update', $this->orderItem->id), $updatedData)
        ->assertStatus(401);        
    }

    public function testDeleteOrderItem()
    {                               
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('DELETE', route('order_item.destroy', 1000))
        ->assertStatus(404); 

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('DELETE', route('order_item.destroy', $this->orderItem->id))
        ->assertStatus(200);         
             
        $this->withHeaders(['Authorization' => 'Bearer ' ])->json('DELETE', route('order_item.destroy', $this->orderItem->id))
        ->assertStatus(401);
     
        $this->withHeaders(['Authorization' => 'Bearer aklsdjflaksjdf;laksdfnigga' ])->json('DELETE', route('order_item.destroy', $this->orderItem->id))
        ->assertStatus(401);  
            
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token2])->json('DELETE', route('order_item.destroy', $this->orderItem->id))
        ->assertStatus(401);   
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

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('POST', route('order_item.store'),$data)
        ->assertStatus(201);

        $this->withHeaders(['Authorization' => 'Bearer ' ])->json('POST', route('order_item.store'),$data)
        ->assertStatus(401);

        $this->withHeaders(['Authorization' => 'Bearer aklsdjflaksjdf;laksdfnigga' ])->json('POST', route('order_item.store'),$data)
        ->assertStatus(401); 
            
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token2])->json('POST', route('order_item.store'),$data)
        ->assertStatus(401);    
    }
}
