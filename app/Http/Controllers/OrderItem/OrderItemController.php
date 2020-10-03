<?php

namespace App\Http\Controllers\OrderItem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;

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
        $order_item = OrderItem::create([
            'item_id' => $data['item_id'],
            'order_id' => $data['order_id'],
            'quantity'=> $data['quantity']
        ]);

        return response()->json($order_item, 201, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $orderitem = OrderItem::find($id);
        $data = $request->all();
        if (is_null($orderitem)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        else if ($data['quantity'] <= 0){
            return response()->json(["message" => "Quantity has to be at least 1!"], 403);
        }
        $orderitem->update($request->all());

        return response()->json($orderitem, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderitem = OrderItem::find($id);
        if (is_null($orderitem)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        $orderitem->delete();

        return response()->json(null, 204);
    }
}
