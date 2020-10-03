<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Item;
use App\Models\Extra;

class OrderItemExtraTest extends TestCase
{
    use RefreshDatabase;
    
    public function testStoreOrderItemExtra()
    {

        $order = Order::factory()->create();
        $item = Item::factory()->create();
        $orderitem = OrderItem::create([
            'order_id' => $order->id,
            'item_id' => $item->id,
            'quantity' => 2
        ]);
        $extra = Extra::factory()->create();
        $datax = [
            'order_item_id' => $orderitem->id,
            'extra_id' => $extra->id];

        $assertdata = OrderItem::where('id',$orderitem->id)->with('extras')->get()->toArray();

        $this->json('POST', route('order_item_extra.store'),$datax)
        ->assertStatus(201)
        ->assertJson($assertdata);
    }
}
