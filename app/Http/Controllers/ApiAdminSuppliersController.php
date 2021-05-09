<?php

namespace App\Http\Controllers;

use App\supplier;
use Illuminate\Http\Request;

class ApiAdminSuppliersController extends Controller
{
    //
    public function index(){

        $suppliers = supplier::when(!is_null(\request('SupplierName')),function($query){
            $query->where('name','LIKE',\request('SupplierName').'%');
        })->select('id','name','phone','phone2')->paginate(20)->appends(['name'=>\request('SupplierName')]);

        return response()->json(['suppliers'=>$suppliers],200);
    }
}
