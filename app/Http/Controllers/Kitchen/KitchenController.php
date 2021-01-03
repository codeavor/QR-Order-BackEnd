<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserType;
use App\Models\Order;
use App\Models\OrderItem;
use Validator;
use App\Traits\KitchenTrait;

class KitchenController extends Controller
{
    use KitchenTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => $validator->errors()], 401);

        $usertype = UserType::where('id', '=', $request->input(['user_id']))->first();;
        $order = Order::create([
            'umbrella_id' => 0,
        ]);
        $order->userType()->associate($usertype)->save();
        return response()->json(['order_id' => $order->id], 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE); 
    }

    public function index()
    { 
        return response()->json($this->returnOrders(), 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE); 
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
        return response()->json($this->returnOrders(), 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
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
