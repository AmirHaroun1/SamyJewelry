<?php

namespace App\Http\Controllers;

use App\employee;
use App\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class AdminInvoicesController extends Controller
{
    public function index(){
        return view('Invoices');
    }
    public function create(){
        return view('CreateInvoice');
    }
    public function update(Request $request,invoices $Invoice){
        $Invoice->update($request->all());
        return response(['UpdatedInvoice'=> $Invoice],200);
    }
    public function edit(invoices $Invoice){
         $Invoice->load(['products','seller:id']);
        return view('EditInvoice',compact('Invoice'));
    }
    public function destroy(invoices $Invoice){
        DB::table('weight_change')->where('invoice_id',$Invoice->id)->delete();
        $Invoice->delete();
        return response()->json([],200);
    }
    public function store(Request $request){

        $ProductsArray =  json_decode($request['products'],true);
        DB::beginTransaction();
        try{
            $ProductsInsertionArray = [];

            $createdInvoice = invoices::create($request->except('products','products_length'));


            for ($i = 0 ; $i < (integer) $request->products_length ; $i++){
                $ProductHasOwnerEmployee = (isset($ProductsArray[$i]['owner_employee']) && $ProductsArray[$i]['owner_employee'] != '' && $ProductsArray[$i]['owner_employee'] != null && $ProductsArray[$i]['owner_employee'] != "null"  && $request['employee_id'] != $ProductsArray[$i]['owner_employee']);
                $ProductIsBracelet = $ProductsArray[$i]['is_bracelet'];
                // if product is_from_buyer turn the value into negative
                if( isset($ProductsArray[$i]['is_from_buyer']) &&  $ProductsArray[$i]['is_from_buyer']){
                    $ProductsArray[$i]['total_price'] = -1 * abs((float) $ProductsArray[$i]['total_price']);
                }
                array_push( $ProductsInsertionArray,
                    [
                        'product_id'=> $ProductsArray[$i]['id'],
                        'invoice_id'=>$createdInvoice->id,
                        'number_of_items' => $ProductsArray[$i]['number_of_items'],
                        'description' => $ProductsArray[$i]['description'],
                        'total_price' => (float) $ProductsArray[$i]['total_price'],
                        'weight' => (float) $ProductsArray[$i]['weight'],
                        'weight_type' => $ProductsArray[$i]['weight_type'],
                        'is_from_buyer' => $ProductsArray[$i]['is_from_buyer'] ? 1:0 ,
                        'is_bracelet' => $ProductsArray[$i]['is_bracelet'],
                        'owner_employee' => $ProductHasOwnerEmployee ? $ProductsArray[$i]['owner_employee'] : null
                    ]
                );

                //creating new request
                $NewRequest = new Request();
                $Borrower_id = null;
                //if the product is bracelet it must be from batreena
                if($ProductIsBracelet){
                    $owner = employee::where('id',1)->firstOrFail();
                }
                // check if the product has another owner
                else if( $ProductHasOwnerEmployee ){
                    // find the owner employee
                    $owner = employee::where('id',(integer) $ProductsArray[$i]['owner_employee'])->firstOrFail();
                    // add it to the new request
                    $Borrower_id = (integer) $request['employee_id'];

                }else{
                    $owner = employee::where('id',(integer) $request['employee_id'])->firstOrFail();
                }

                // handling request before sending it to employee update method
                if($ProductIsBracelet){
                    $NewRequest->replace([
                        'borrower_id'=> $request['employee_id'], // the invoice seller will be the borrower
                        'employee_id' => 1, // the batreena will be the owner
                        'weight_change'=>'minus_weight',
                        'sold'=>1,
                        'is_bracelet'=>1,
                        'bracelets_number_of_items'=>$ProductsArray[$i]['number_of_items'],
                        'weight_amount'=>$ProductsArray[$i]['weight'],
                        'weight_type'=>$ProductsArray[$i]['weight_type'],
                        'product_id' => $ProductsArray[$i]['id'],
                        'invoice_id'=> $createdInvoice->id,
                        'created_at'=>$request['created_at'],
                    ]);
                    $owner->RecordNewWeightChangeForBracelet($NewRequest);
                    $owner->updateBraceletsWeight($NewRequest);
                }
               else if( !isset($ProductsArray[$i]['is_from_buyer']) ||  !$ProductsArray[$i]['is_from_buyer']){
                    $NewRequest->replace([
                        'borrower_id'=>$Borrower_id,
                        'employee_id' => $request['employee_id'],
                        'weight_change'=>'minus_weight',
                        'sold'=>true,
                        'number_of_items'=>$ProductsArray[$i]['number_of_items'],
                        'weight_amount'=>$ProductsArray[$i]['weight'],
                        'weight_type'=>$ProductsArray[$i]['weight_type'],
                        'product_id' => $ProductsArray[$i]['id'],
                        'invoice_id'=> $createdInvoice->id,
                        'created_at'=>$request['created_at'],
                    ]);

                    $owner->RecordNewWeightChange($NewRequest);
                    $owner->updateWeight($NewRequest);
                }


            }

            DB::table('products_invoices')->insert($ProductsInsertionArray);


            DB::commit();


        }catch (Exception $e){

            DB::rollBack();
            return response()->json(['products_invoices'=>$ProductsArray,'traceMessage'=>$e->getMessage()],400);
        }
        return response()->json([],200);
    }
    public function AddProductToInvoice(Request $request){


        DB::beginTransaction();
        try{

            $invoice = invoices::where('id',$request['invoice_id'])->firstOrFail();
            $invoice->updateAttrsOnChange($request);
            // insert into products_invoices
            // if product is_from_buyer turn the value into negative
            if( $request['product_is_from_buyer'] ){
                $request['product_total_price'] = -1 * abs((float) $request['product_total_price']);
            }
            $owner_employee_found = $request->exists('product_owner_employee');
            //inserting into products_invoices_table
                DB::insert('insert into products_invoices (product_id,invoice_id,number_of_items,description,total_price,weight,weight_type,is_from_buyer,is_bracelet,owner_employee) values (?,?,?,?,?,?,?,?,?,?)',
                [
                     $request['product_id']
                    ,$request['invoice_id']
                    ,$request['product_number_of_items']
                    ,$request['product_description']
                    ,$request['product_total_price']
                    ,$request['product_weight']
                    ,$request['product_weight_type']
                    ,$request['product_is_from_buyer'] ? 1 : 0
                    ,$request['product_is_bracelet'] ? 1 : 0
                    ,$owner_employee_found ? $request['product_owner_employee'] : null
                ]);
            // getting the inserted record id
              $inserted_product_invoices_id =  DB::table('products_invoices')->latest()->select('id')->whereRaw('product_id = ? AND invoice_id = ?',[ $request['product_id'],$request['invoice_id'] ])->take(1)->get();
            // if the product isn't from buyer handle employee weight after adding the product
            if(!$request['product_is_from_buyer']){
                // handling request before sending it to employee update method
                //creating new request
                $Borrower_id = null;
                if($request['product_is_bracelet']){
                    $owner = employee::where('id',1)->firstOrFail();
                    $Borrower_id = (integer) $request['invoice_seller_id'];
                }
                else if($owner_employee_found){
                    // find the owner employee
                    $owner = employee::where('id',(integer) $request['product_owner_employee'])->firstOrFail();
                    // add it to the new request
                    $Borrower_id = (integer) $request['invoice_seller_id'];
                }else{
                    $owner = employee::where('id',(integer) $request['invoice_seller_id'])->firstOrFail();
                }
                if($request['product_is_bracelet']) {
                    $NewRequest = new Request();
                    $NewRequest->replace([
                        'borrower_id'=>$Borrower_id,
                        'employee_id' => 1,
                        'weight_change'=>'minus_weight',
                        'sold'=>true,
                        'bracelets_number_of_items' => $request['product_number_of_items'],
                        'weight_amount'=>$request['product_weight'],
                        'weight_type'=>$request['product_weight_type'],
                        'product_id' => $request['product_id'],
                        'invoice_id'=> $request['invoice_id'],
                        'created_at'=> now(),
                    ]);
                    $owner->RecordNewWeightChangeForBracelet($NewRequest);
                    $owner->updateBraceletsWeight($NewRequest);
                }else{
                    $NewRequest = new Request();
                    $NewRequest->replace([
                        'borrower_id'=>$Borrower_id,
                        'employee_id' => $request['invoice_seller_id'],
                        'weight_change'=>'minus_weight',
                        'sold'=>true,
                        'number_of_items' => $request['product_number_of_items'],
                        'weight_amount'=>$request['product_weight'],
                        'weight_type'=>$request['product_weight_type'],
                        'product_id' => $request['product_id'],
                        'invoice_id'=> $request['invoice_id'],
                        'created_at'=> now(),
                    ]);
                    $owner->RecordNewWeightChange($NewRequest);
                    $owner->updateWeight($NewRequest);
                }

            }
            DB::commit();
            return response()->json(['AddedProduct_invoices_id'=>$inserted_product_invoices_id],200);
        }catch (Exception $e){
            DB::rollBack();
            return $e;
            return response()->json(['error'=>$e],500);
        }
    }
    public function deleteProductFromInvoice(Request $request){
        DB::beginTransaction();
        try{
            $invoice = invoices::where('id',$request['invoice_id'])->firstOrFail();
            $invoice->updateAttrsOnChange($request);
            // if product is not form buyer we should return the weight to the seller

            $owner_employee_found = $request->exists('owner_employee');

            if(!$request['is_from_buyer']){
                if($request['is_bracelet'])
                {
                    $owner = employee::where('id',1)->firstOrFail();
                }
                else if( $owner_employee_found ) {
                    $owner = employee::where('id',(integer) $request['owner_employee'])->firstOrFail();
                }else{
                    $owner = employee::where('id',(integer) $request['seller_id'])->firstOrFail();
                }


                if($request['is_bracelet'])
                {
                    $NewRequest = new Request();
                    $NewRequest->replace([
                        'weight_change' => 'returned_weight',
                        'bracelets_number_of_items' => $request['number_of_items'],
                        'weight_amount' => $request['weight'],
                        'weight_type' => $request['weight_type'],
                    ]);
                    $owner->updateBraceletsWeight($NewRequest);
                }else{
                    $NewRequest = new Request();
                    $NewRequest->replace([
                        'weight_change' => 'returned_weight',
                        'number_of_items' => $request['number_of_items'],
                        'weight_amount' => $request['weight'],
                        'weight_type' => $request['weight_type'],
                    ]);
                    $owner->updateWeight($NewRequest);
                }

            }
            DB::table('products_invoices')->whereRaw('id = ?',[$request['products_invoices_id']])->delete();
            if($owner_employee_found){
                DB::table('weight_change')
                    ->whereRaw('invoice_id = ? and product_id = ? and sold = 1 and weight_amount = ? and weight_type LIKE ? AND employee_id = ? AND borrower_id = ?'
                        ,[
                            $request['invoice_id'],
                            $request['product_id'],
                            $request['weight'],
                            $request['weight_type'],
                            $request['seller_id'],
                            $request['owner_employee'],
                        ]
                    )->delete();
            }else if(!$owner_employee_found){
                DB::table('weight_change')
                    ->whereRaw('invoice_id = ? and product_id = ? and sold = 1 and weight_amount = ? and weight_type LIKE ? AND employee_id = ? AND borrower_id IS NULL'
                        ,[
                            $request['invoice_id'],
                            $request['product_id'],
                            $request['weight'],
                            $request['weight_type'],
                            $request['seller_id'],

                        ]
                    )->delete();
            }


            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return $e;
            return response()->json(['error'=>$e],500);
        }
    }
}
