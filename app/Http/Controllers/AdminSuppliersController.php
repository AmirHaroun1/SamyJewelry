<?php

namespace App\Http\Controllers;

use App\supplier;
use Illuminate\Http\Request;

class AdminSuppliersController extends Controller
{
    //
    public function index(){
            return view('suppliers');
    }
    public function create(){
        return view('CreateSuppliers');
    }
    public function edit(supplier $supplier){
            return view('EditSupplier',compact('supplier'));
    }
    public function store(Request $request){
        $NewSupplier = supplier::create($request->all());

        return response()->json(['NewSupplier'=>$NewSupplier],200);
    }
    public function update(Request $request, supplier $supplier){
        $supplier->update($request->all());

        return response()->json(['supplier'=> $supplier],200);
    }
}
