<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Http\Request;

class AdminProductsController extends Controller
{
    //

    public function store(Request $request){
        $NewProduct = product::create($request->all());

        return response()->json(['NewProduct'=>$NewProduct],200);
    }
    public function destroy(product $product){
        $product->delete();
        return response()->json([],200);
    }
}
