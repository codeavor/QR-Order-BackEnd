<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;
use App\Models\UserType;
use App\Models\Item;

class OrderTest extends TestCase
{

    use RefreshDatabase;

    public function testOrderRelations()
    {
        $order = Order::factory()->create();
        $userType = new UserType;
        $item = Item::factory()->create();

        $order->userType()->associate($userType)->save();

        // Tests for userType relation one to one
        $this->assertInstanceOf(UserType::class,$order->userType);

        // Tests for item relation Many to Many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $order->items); 
    }
}
