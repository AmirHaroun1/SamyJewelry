<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    //
    protected $table = 'products';
    protected $guarded = [];

    public function owner(){
        return $this->belongsTo('App\employee','products_invoices.owner_employee','id');
    }
}
