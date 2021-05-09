<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiAdminProductsController extends Controller
{
    //
    public function index(){
        $products = DB::table('products')->selectRaw('id,name')->get();
        return response()->json(['products'=>$products],200);
    }
}
