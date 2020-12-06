<?php

namespace App\Http\Controllers\ShoppingCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Traits\CartTrait;

class CartController extends Controller
{
    use CartTrait;
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->showCart($id), 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
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
            return response()->json(["error" => "Record not found!"], 404);
        }
        $order->update($request->all());
        return response()->json($this->deleteUserType($id,$request), 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
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
    //         return response()->json(["error" => "Record not found!"], 404);
    //     }
    //     $order->delete();

    //     return response()->json(null, 204);
    // }
}
