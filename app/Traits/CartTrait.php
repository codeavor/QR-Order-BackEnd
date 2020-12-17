<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderItem;

trait CartTrait {
    public function showCart($id) 
    {
        $finorder = collect();
        $order = Order::find($id);
        $items = $order->items;
        $cart = OrderItem::with('extras')->where('order_id', '=', $order->id)->get();
        if (is_null($cart) || $cart->count() == 0 || $order->order_complete !== 'not_sent') {
            return [];
        }
        return $cart;
    }
    public function deleteUserType($id,$request)
    {
        $order = Order::find($id);

        if($request->order_complete === 'sent' && $order->order_complete === 'not_sent'){
            $order->update($request->all());
            $userType = $order->userType();
            $userType->delete();
        }
        return $order;
    }
}