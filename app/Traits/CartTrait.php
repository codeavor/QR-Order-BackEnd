<?php

namespace App\Traits;

use App\Models\Order;

trait CartTrait {
    public function showCart($id) 
    {
        $order = Order::select('order_items.id as order_item_id', 'order_items.quantity', 'extras.name as extras', 'extras.price as extra_price','items.name', 'items.price')
                                 ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                                 ->join('items', 'order_items.item_id', '=', 'items.id')
                                 ->join('order_item_extras', 'order_items.id', '=', 'order_item_extras.order_item_id')
                                 ->join('extras', 'extras.id', '=', 'order_item_extras.extra_id')
                                 ->where(['orders.id' => $id, 'orders.order_complete' => false])
                                 ->get();

        if (is_null($order) || $order->count() == 0) {
            return [];}
        return $order;
    }
    public function deleteUserType($id,$request)
    {
        $order = Order::find($id);
        if($request->order_complete){
            $userType = $order->userType();
            $userType->delete();
        }
        return $order;
    }
}