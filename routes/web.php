<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function() {
    // Return json with greek characters, for every category show it's items
    //$order = \App\Models\Order::find(1);
    //$items = $order->items()->get();
    /*
    * For specific category
    * $items = \App\Category::with('Items')->find(1);
    */ 

    //$orderitems = \App\Models\OrderItem::find(2);
    //$extras = $orderitems->extras()->get();

    // $orders = \App\Models\Order::where('id', 1)->with('Items')->get();

    // $orderitems = \App\Models\OrderItem::with('Extras')->get();
    // $orders = \App\Models\Order::select('order_items.id as order_item_id', 'order_items.quantity', 'extras.name as extras', 'extras.price as extra_price','items.name', 'items.price')
    //                              ->join('order_items', 'orders.id', '=', 'order_items.order_id')
    //                              ->join('items', 'order_items.item_id', '=', 'items.id')
    //                              ->join('order_item_extras', 'order_items.id', '=', 'order_item_extras.order_item_id')
    //                              ->join('extras', 'extras.id', '=', 'order_item_extras.extra_id')
    //                              ->where(['orders.id' => 2, 'orders.order_complete' => false])
    //                              ->get();    
    // $orders = \App\Models\Order::get();                                     
    // $orderitems = \App\Models\OrderItem::with('Extras') ->get();
    $userType = \App\Models\UserType::find(1);
    return response()->json($userType->role->name, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
});

// Route::get('/test', function() {
    // How to reset auto increment
    /*
    * DB::statement('ALTER TABLE migrations AUTO_INCREMENT = 1');
    */

    // How to create a table record
    /*
    * \App\Category::create([
    *     'name' => 'First Category',
    *     'description' => 'This is the first category'
    * ]);
    */

    // One to Many relation
    /*
    * 1st way
    * $category = \App\Category::find(1);
    * $category->items()->create([
    *     'name' => 'First item',
    *     'price' => 1.2
    * ]);
    * 
    * 2nd way
    * $category = \App\Category::find(2);
    * $item = new \App\Item([
    *     'name' => 'Second item',
    *     'price' => 4.0
    * ]);
    * $item->category()->associate($category);
    * $item->save();
    */

    // Many to Many relation
    /* 
    * Without extra field
    * $extra = \App\Extra::find(4);
    * $extra->items()->attach($item);
    * $item = \App\Item::find(2);
    * $item->extras()->attach($extra);
    * $extra = \App\Extra::find(5);
    * $item->extras()->attach($extra);
    * $item = \App\Item::find(4);
    * $extra->items()->attach($item);
    * 
    * With extra pivot field    
    * $item = \App\Item::find(1);
    * $order = \App\Extra::find(2);
    * $item->orders()->attach($order, ['quantity' => 2]);
    * $item = \App\Item::find(2);
    * $item->orders()->attach($order, ['quantity' => 1]);
    * $item = \App\Item::find(1);
    * $order = \App\Extra::find(5);
    * $item->orders()->attach($order, ['quantity' => 2]);
    * $item = \App\Item::find(3);
    * $item->orders()->attach($order, ['quantity' => 3]);
    * $item = \App\Item::find(4);
    * $item->orders()->attach($order, ['quantity' => 1]);
    */
// });