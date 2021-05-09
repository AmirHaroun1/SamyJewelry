<?php

namespace App\Http\Controllers;

use App\supplier;
use App\supplies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class AdminSuppliesController extends Controller
{
    //
    public function create(supplier $supplier){
        return view('CreateSupplies',compact('supplier'));
    }
    public function edit($SupplyID){
        $supply = supplies::findOrFail($SupplyID)->with('supplier:id,name','payments')->first();


        return view('EditSupplies',compact('supply'));
    }
    public function store(Request $request){
        $PaymentsArray =  json_decode($request['payments'],true);
        DB::beginTransaction();
        try{
            $NewSupply = supplies::create($request->except('payments','payments_length'));
            $PaymentsInsertionArray = [];
            for ($i = 0 ; $i < (integer) $request->payments_length ; $i++) {
                array_push( $PaymentsInsertionArray,
                    [
                        'supply_id'=> $NewSupply->id,
                        'weight_amount_18'=>$PaymentsArray[$i]['weight_amount_18'],
                        'weight_amount_21' => $PaymentsArray[$i]['weight_amount_21'],
                        'price' => $PaymentsArray[$i]['price'],
                    ]
                );
            }
            DB::table('payments')->insert($PaymentsInsertionArray);
            DB::commit();

        }catch (Exception $exception){
            return response($exception,400);

            DB::rollBack();
        }
        return response($NewSupply,200);

    }
    public function update(Request $request,$SupplyID){
        $supply = supplies::findOrFail($SupplyID)->update($request->all());

        return response()->json($supply,200);
    }

}
