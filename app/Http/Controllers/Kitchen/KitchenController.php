<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Symfony\Component\Console\Output\ConsoleOutput;


class KitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finorder = collect();
        $orders = Order::get();
        $fin = collect();

        $output = new ConsoleOutput();
        // $output->writeln($orders);
        foreach($orders as $order){
            if($order->order_complete !== 'completed' && $order->order_complete !== 'not_sent'){
                
                $cart = collect();
                $items = $order->items;
                
                foreach($items as $item){
                    $cart->push(OrderItem::with('extras')->find($item->pivot->item_id));
                    $output->writeln(OrderItem::with('extras')->find($item->pivot->item_id));
                }
                
                if (is_null($cart) || $cart->count() == 0 ) {
                    continue ;
                }
                $finorder->push($cart->all());
                $fin->push($finorder);
                $fin->push($order->order_complete);
                // $fin = ['Cart' => $finorder, 
                // 'Order Status' => $order->order_complete];
            }
        }
        return response()->json($fin->all(), 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE); 
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
            return response()->json(["Error" => "Record not found!"], 404);
        }
        $order->update($request->all());
        return response()->json($order, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return response()->json(["error" => "Record not found!"], 404);
        }
        $order->delete();

        return response()->json(null, 204);
    }
}
