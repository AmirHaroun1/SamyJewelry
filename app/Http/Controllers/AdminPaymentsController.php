<?php

namespace App\Http\Controllers;

use App\payment;
use App\supplies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPaymentsController extends Controller
{
    //
    public function store(Request $request){
        $NewPayment = payment::create($request->all());

        return response(['NewPayment'=>$NewPayment],200);
    }
    public function destroy(payment $payment){
        $payment->delete();

        return response()->json([],200);
    }
}
