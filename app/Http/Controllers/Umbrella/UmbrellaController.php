<?php

namespace App\Http\Controllers\Umbrella;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Umbrella;

class UmbrellaController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function umbrellaById($id){
        $umbrella = Umbrella::find($id);
        if (is_null($umbrella)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        return response()->json($umbrella, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
