<?php

namespace App\Http\Controllers\OrderItem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Extra;

class OrderItemController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $orderItem = OrderItem::create([
            'item_id' => $data['item_id'],
            'order_id' => $data['order_id'],
            'quantity'=> $data['quantity']
        ]);
        foreach($data['extras_id'] as $extra_id){
            $extra = Extra::find($extra_id);
            $orderItem->extras()->attach($extra);
        }
        $orderItemExtras = $orderItem->with('extras')->find($orderItem->id);

        return response()->json($orderItemExtras, 201, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
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
        $orderItem = OrderItem::find($id);
        $data = $request->all();
        if (is_null($orderItem)) {
            return response()->json(["error" => "Record not found!"], 404);
        }
        else if ($data['quantity'] <= 0){
            return response()->json(["error" => "Quantity has to be at least 1!"], 403);
        }
        $orderItem->update($request->all());

        return redirect()->route('cart.show', $orderItem->order_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderItem = OrderItem::find($id);
        if (is_null($orderItem)) {
            return response()->json(["error" => "Record not found!"], 404);
        }
        $orderId = $orderItem->order_id;
        $orderItem->delete();

        return redirect()->route('cart.show', $orderId);
    }
}
