<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    //
    protected $table = 'suppliers';
    protected $guarded = [];

    public function supplies(){
        return $this->hasMany('App\supplies','supplier_id');
    }
}
