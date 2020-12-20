<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderItem;

trait CartTrait {
    public function refactorCart($order) 
    {
        $items = $order->items;
        $cart = OrderItem::with('extras')->where('order_id', '=', $order->id)->get();
        // Get each order item {"id":1,"name":"Espresso","price":"1","category_id":1,"description":null,"pivot":{"order_id":8,"item_id":1,"quantity":2,"notes":"geia"}}      
        foreach ($items as $item ) {
            // Get each cart item {"id":28,"order_id":8,"item_id":1,"quantity":2,"notes":null,"extras":[{"id":0,"name":" ","price":"0","pivot":{"order_item_id":28,"extra_id":0}}]}
            foreach ($cart as $itemCart) {
                if ($item->id == $itemCart->item_id) {
                    $itemCart->item_name = $item->name;
                    $itemCart->price = $item->price;
                    $itemCart->description = $item->description;                    
                }
            }            
        }
        return $cart;
    }

    public function showCart($id) 
    {
        $order = Order::find($id);
         
        $cart = $this->refactorCart($order);
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