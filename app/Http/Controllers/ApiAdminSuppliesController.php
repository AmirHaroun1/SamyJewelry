<?php

namespace App\Http\Controllers;

use App\supplies;
use Illuminate\Http\Request;

class ApiAdminSuppliesController extends Controller
{
    //
    public function index(){

        $supplies = supplies::when(!is_null(\request('supplier_id')),function($query){
            $query->where('supplier_id',\request('supplier_id'));
        })->groupBy('id')->paginate(20)->appends(['supplier_id'=>\request('supplier_id')]);

        return response()->json(['supplies'=>$supplies],200);
    }

}
