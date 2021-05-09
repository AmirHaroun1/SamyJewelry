<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class invoices extends Model
{
    //

    protected $table = 'invoices';
    protected $guarded = [];
    public function seller(){
        return $this->belongsTo('App\employee','employee_id','id');
    }
    public function products(){
        return $this->belongsToMany('App\product','products_invoices','invoice_id','product_id')
                ->withPivot('id','number_of_items','description','is_bracelet','total_price','weight','weight_type','is_from_buyer','owner_employee','created_at')
                ->as('product_details');
    }
    public function updateAttrsOnChange(Request $request){
        $this->update([
            'total_price' => $request['invoice_total_price']
            ,'actual_price' => $request['invoice_actual_price']
            ,'total_weight_18' => $request['invoice_total_weight_18']
            ,'total_weight_21' => $request['invoice_total_weight_21']
            ,'from_buyer_total_weight_18' => $request['invoice_from_buyer_total_weight_18']
            ,'from_buyer_total_weight_21' => $request['invoice_from_buyer_total_weight_21']
        ]);
    }
}
