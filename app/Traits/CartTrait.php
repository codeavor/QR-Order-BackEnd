<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderItem;

trait CartTrait {
    public function showCart($id) 
    {
        $cart = collect();
        $order = Order::find($id);
        $items = $order->items;
        foreach($items as $item){
            $cart->push(OrderItem::with('extras')->find($item->pivot->item_id));
        }

        if (is_null($cart) || $cart->count() == 0 || $order->order_complete !== 'not_sent') {
            return [];
        }

        return $cart->all();
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