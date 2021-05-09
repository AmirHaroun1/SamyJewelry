<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplies extends Model
{
    //
    protected $table = 'supplies';
    protected $guarded = [];

    public function supplier(){
        return $this->belongsTo('App\supplier');
    }
    public function payments(){
        return $this->hasMany('App\payment','supply_id');
    }
}
