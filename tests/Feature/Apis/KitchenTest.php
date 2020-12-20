<?php

namespace Tests\Feature\Apis;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Extra;
use App\Models\Item;
use App\Models\Role;
use App\Models\UserType;


class KitchenTest extends TestCase
{
    use RefreshDatabase;

    protected  $orderItem, $item, $role, $userType, $order, $token,$extra;

    public function setUp():void
    {
        parent::setUp();
        $this->item = Item::factory()->create();
        $this->role = Role::factory()->create();
        $extra = Extra::factory()->create();
        $this->userType = new UserType;
        $this->role->userTypes()->save($this->userType);
        $this->order = Order::create([
            'order_complete' => 'sent',
            'umbrella_id' => 0,
        ]);
        $this->userType->order()->save($this->order);
        $this->token = auth()->login($this->userType);
        $this->orderItem = OrderItem::create([
            'order_id' => $this->order->id,
            'item_id' => $this->item->id,
            'quantity' => 2,
            'note' => 'note'
        ]);
        $this->orderItem->extras()->attach($extra);
        $this->role2 = Role::create([
            'name' => 'customer'
        ]);
        $this->userType2 = new UserType;
        $this->role2->userTypes()->save($this->userType2);
        $this->token2 = auth()->login($this->userType2);
    }

    public function testStore()
    {
        $role2 = Role::factory()->create();
        $userType2 = new UserType;
        $role2->userTypes()->save($userType2);
        $token2 = auth()->login($userType2);

        $this->withHeaders(['Authorization' => 'Bearer ' . $token2])->json('POST', route('orders.store',[ 'id'=>$userType2->id]))
        ->assertStatus(200)
        ->assertJsonStructure(["OrderId"]);

        $role2 = Role::create([
            'name' => 'customer'
        ]);
        
        $userType2 = new UserType;
        $role2->userTypes()->save($userType2);
        $token2 = auth()->login($userType2);

        $this->withHeaders(['Authorization' => 'Bearer ' . $token2])->json('POST', route('orders.store',[ 'id'=>$userType2->id]))
        ->assertStatus(401);
    }

    public function testIndex()
    {
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('GET', route('orders.index'))
        ->assertStatus(200)
        ->assertJsonStructure([
            [
                "cart" => [
                    '*' => [
                        "id",
                        "order_id",
                        "item_id", 
                        "quantity", 
                        "notes",
                        'extras' => [
                            '*' => [
                                'id', 'name', 'price', 'pivot' => [
                                    'order_item_id', 'extra_id'
                                ]
                            ]
                        ]
                    ]
                ],
                "order_complete"
            ]
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token2])->json('GET', route('orders.index'))
        ->assertStatus(401);
    }

    public function testUpdate()
    {
        $updatedData = [
            'order_complete' => 'not_sent'
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('PUT', route('orders.update', $this->order->id), $updatedData)
             ->assertStatus(200)
             ->assertJson($updatedData);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('PUT', route('orders.update', 1000), $updatedData)
             ->assertStatus(404);
    }

    public function testDestroy()
    {
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('DELETE', route('orders.destroy', $this->order->id))
             ->assertNoContent($status = 204);   
             
        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])->json('DELETE', route('orders.destroy', 1000))
             ->assertStatus(404);      
    }
}

