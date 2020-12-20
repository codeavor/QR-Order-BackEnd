<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserType;
use App\Models\Order;
use App\Models\OrderItem;
use Validator;
use App\Traits\CartTrait;
//use Symfony\Component\Console\Output\ConsoleOutput;


class KitchenController extends Controller
{
    use CartTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => $validator->errors()], 401);

        $usertype = UserType::where('id', '=', $request->input(['id']))->first();;
        $order = Order::create([
            'umbrella_id' => 0,
        ]);
        $order->userType()->associate($usertype)->save();
        return response()->json(['OrderId' => $order->id], 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE); 
    }


    public function index()
    {
        $finorder = collect();
        $orders = Order::get();

        /*
         $output = new ConsoleOutput();
         $output->writeln($orders);
        */
        foreach($orders as $order){
            if($order->order_complete !== 'completed' && $order->order_complete !== 'not_sent'){
                $cart = $this->refactorCart($order);
                if (is_null($cart) || $cart->count() == 0 ) {
                    continue;
                }
                $finorder->push(['cart' => $cart,'order_complete' => $order->order_complete]);
            }
        }
        return response()->json($finorder->all(), 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE); 
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
