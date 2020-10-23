<?php

namespace App\Http\Controllers\ShoppingCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class CartController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::select('order_items.id as order_item_id', 'order_items.quantity', 'extras.name as extras', 'extras.price as extra_price','items.name', 'items.price')
                                 ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                                 ->join('items', 'order_items.item_id', '=', 'items.id')
                                 ->join('order_item_extras', 'order_items.id', '=', 'order_item_extras.order_item_id')
                                 ->join('extras', 'extras.id', '=', 'order_item_extras.extra_id')
                                 ->where(['orders.id' => $id, 'orders.order_complete' => false])
                                 ->get();

        if (is_null($order) || $order->count() == 0) {
            return response()->json(["message" => "Record not found!"], 404);
        }

        return response()->json($order, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        $order->update($request->all());

        return response()->json($order, 200);
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $order = Order::find($id);
    //     if (is_null($order)) {
    //         return response()->json(["message" => "Record not found!"], 404);
    //     }
    //     $order->delete();

    //     return response()->json(null, 204);
    // }
}
