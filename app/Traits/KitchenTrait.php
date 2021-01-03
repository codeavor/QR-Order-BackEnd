<?php

namespace App\Traits;

use App\Models\Order;
use App\Traits\CartTrait;

trait KitchenTrait {

    use CartTrait;

    public function returnOrders() 
    {
        $finorder = collect();
        $orders = Order::orderByDesc('updated_at')->get();   
        // edo sto order  kano order by updated at decented
        foreach($orders as $order){
            if($order->order_complete !== 'completed' && $order->order_complete !== 'not_sent'){
                $cart = $this->refactorCart($order);
                if (is_null($cart) || $cart->count() == 0 ) {
                    continue; 
                }
                $finorder->push(['cart' => $cart,'order_complete' => $order->order_complete,'updated_at' => $order->updated_at,'umbrella_id' => $order->umbrella_id]);
            }
        }
        return $finorder;
    }
}