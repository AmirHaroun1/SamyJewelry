<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products_invoices extends Model
{
    //
    protected $table = 'products_invoices';
    protected $primaryKey = 'id';
    public function owner(){
        return $this->belongsTo('App\employee','owner_employee','id');
    }
    public function invoice(){
        return $this->belongsTo('App\invoices','invoice_id','id');
    }
    public function product(){
        return $this->belongsTo('App\product','product_id','id');

    }

}
