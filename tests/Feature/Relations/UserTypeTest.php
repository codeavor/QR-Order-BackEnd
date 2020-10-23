<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Role;
use App\Models\UserType;

class UserTypeTest extends TestCase
{
    
    use RefreshDatabase;

    public function testUserTypeRelations()
    {
        $role = Role::factory()->create();
        $order = Order::factory()->create();
        $userType = new UserType;

        $userType->role()->associate($role)->save();
        $userType->order()->save($order);

        // Tests for role relation one to many
        $this->assertInstanceOf(Role::class,$userType->role);
        $this->assertEquals(1,$userType->role->count());

        //  Tests for order relation one to one
        $this->assertInstanceOf(Order::class,$userType->order);
        $this->assertEquals(1, $userType->order->count());
    }
}
