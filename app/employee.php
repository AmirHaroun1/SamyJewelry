<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class employee extends Model
{
    //
    protected $table = 'employees';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public function invoices(){
        return $this->hasMany('App\invoices','employee_id','id');
    }
    public function updateWeight(Request $request){
        if($request->weight_change == 'add_weight'){
            $this->number_of_items += $request->number_of_items;
            $this->current_weight_18 += $request->current_weight_18;
            $this->current_weight_21 += $request->current_weight_21;
        }else if($request->weight_change == 'minus_weight'){
            $this->number_of_items -= $request->number_of_items;
            if($request['weight_type'] == '18'){
                $this->current_weight_18 -= $request['weight_amount'];
            }else{
                $this->current_weight_21 -= $request['weight_amount'];
            }
        }else if($request->weight_change == 'returned_weight'){
            $this->number_of_items += $request->number_of_items;
            if($request['weight_type'] == '18'){
                $this->current_weight_18 += $request['weight_amount'];
            }else{
                $this->current_weight_21 += $request['weight_amount'];
            }
        }
        $this->save();
    }
    public function updateBraceletsWeight(Request $request){
        if($request->weight_change == 'add_weight'){
            $this->bracelets_number_of_items += $request->bracelets_number_of_items;
            $this->bracelets_current_weight_18 += $request->bracelets_current_weight_18;
            $this->bracelets_current_weight_21 += $request->bracelets_current_weight_21;
        }else if($request->weight_change == 'minus_weight'){
            $this->bracelets_number_of_items -= $request->bracelets_number_of_items;
            if($request['weight_type'] == '18'){
                $this->bracelets_current_weight_18 -= $request['weight_amount'];
            }else{
                $this->bracelets_current_weight_21 -= $request['weight_amount'];
            }
        }else if($request->weight_change == 'returned_weight'){
            $this->bracelets_number_of_items += $request->bracelets_number_of_items;
            if($request['weight_type'] == '18'){
                $this->bracelets_current_weight_18 += $request['weight_amount'];
            }else{
                $this->bracelets_current_weight_21 += $request['weight_amount'];
            }
        }
        $this->save();
    }
    public function RecordNewWeightChange(Request $request){
        if($request['NewEmployee']){
            $this->current_weight_18 = 0;
            $this->current_weight_21 = 0;
        }
        if($request->exists('sold')){
            DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,sold,employee_id,borrower_id,invoice_id,product_id,created_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                       $request['weight_type'] == '18' ? $this->current_weight_18 : $this->current_weight_21
                    ,  $request['weight_amount']
                    ,  $request['weight_type']
                    ,   1
                    ,  $this->id
                    ,  $request['borrower_id']
                    ,  $request['invoice_id']
                    ,  $request['product_id']
                    ,  $request['created_at']
                ]);
        }
        else{
            if($request->exists('current_weight_18') && $request->exists('current_weight_21')){

                DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,employee_id,created_at) values (?, ?, ?, ?, ?)',
                    [
                        $this->current_weight_18
                        ,  $request->current_weight_18
                        , '18'
                        , $this->id
                        , Carbon::now()]);
                DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,employee_id,created_at) values (?, ?, ?, ?, ?)',
                    [
                        $this->current_weight_21
                        ,  $request->current_weight_21
                        , '21'
                        , $this->id
                        , Carbon::now()]);

            }
            else if($request->exists('current_weight_18') || $request->exists('current_weight_21')){
                DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,employee_id,created_at) values (?, ?, ?, ?, ?)',
                    [
                        $request->exists('current_weight_18') ? $this->current_weight_18 : $this->current_weight_21
                        , $request->exists('current_weight_18') ? $request->current_weight_18 : $request->current_weight_21
                        , $request->exists('current_weight_18') ? '18' : '21'
                        , $this->id
                        , Carbon::now()]);
            }
           /* if($request->exists('bracelets_current_weight_18') && $request->exists('bracelets_current_weight_21')){
                DB::insert('insert into weight_change (bracelets_original_weight, bracelets_weight_amount,weight_type,employee_id,created_at) values (?, ?, ?, ?, ?)',
                    [
                        $this->bracelets_current_weight_18
                        ,  $request->bracelets_current_weight_18
                        , '18'
                        , $this->id
                        , Carbon::now()]);
                DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,employee_id,created_at) values (?, ?, ?, ?, ?)',
                    [
                        $this->bracelets_current_weight_21
                        ,  $request->bracelets_current_weight_21
                        , '21'
                        , $this->id
                        , Carbon::now()]);

            }
            else if($request->exists('bracelets_current_weight_18') || $request->exists('bracelets_current_weight_21')){
                DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,employee_id,created_at) values (?, ?, ?, ?, ?)',
                    [
                        $request->exists('bracelets_current_weight_18') ? $this->bracelets_current_weight_18 : $this->bracelets_current_weight_21
                        , $request->exists('bracelets_current_weight_18') ? $request->bracelets_current_weight_18 : $request->bracelets_current_weight_21
                        , $request->exists('bracelets_current_weight_18') ? '18' : '21'
                        , $this->id
                        , Carbon::now()]);
            }*/
        }
    }
    public function RecordNewWeightChangeForBracelet(Request $request){
        if($request->exists('sold')){
            DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,sold,is_bracelet,employee_id,borrower_id,invoice_id,product_id,created_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $request['weight_type'] == '18' ? $this->bracelets_current_weight_18 : $this->bracelets_current_weight_21
                    ,  $request['weight_amount']
                    ,  $request['weight_type']
                    ,   1
                    ,   1
                    ,   1
                    ,  $request['borrower_id']
                    ,  $request['invoice_id']
                    ,  $request['product_id']
                    ,  $request['created_at']
                ]);
        }
        if($request->exists('bracelets_current_weight_18') && $request->exists('bracelets_current_weight_21')){

            DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,is_bracelet,employee_id,created_at) values (? , ?, ?, ?, ?, ?)',
                [
                       $this->bracelets_current_weight_18
                    ,  $request->bracelets_current_weight_18
                    , '18'
                    , 1
                    , $this->id
                    , Carbon::now()]);
            DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,is_bracelet,employee_id,created_at) values (?, ?, ?, ?, ?, ?)',
                [
                       $this->bracelets_current_weight_21
                    ,  $request->bracelets_current_weight_21
                    , '21'
                    , 1
                    , $this->id
                    , Carbon::now()]);

        }
        else if($request->exists('bracelets_current_weight_18') || $request->exists('bracelets_current_weight_21')){
            DB::insert('insert into weight_change (original_weight, weight_amount,weight_type,is_bracelet,employee_id,created_at) values (?, ?, ?, ?, ?, ?)',
                [
                    $request->exists('bracelets_current_weight_18') ? $this->bracelets_current_weight_18 : $this->bracelets_current_weight_21
                    , $request->exists('bracelets_current_weight_18') ? $request->bracelets_current_weight_18 : $request->bracelets_current_weight_21
                    , $request->exists('bracelets_current_weight_18') ? '18' : '21'
                    , 1
                    , $this->id
                    , Carbon::now()]);
        }
    }
    public function scopeWithCurrentMonthStats($query){
        $yearMonth = date("Y").'-'. date('m');

        $StartDate = $yearMonth . '-' .'01' . ' ' . '00:00';
        $EndDate = $yearMonth . '-' .'31' . ' ' . '23:59';

        return $query->leftJoin('invoices',function($join) use($StartDate,$EndDate){
            $join->on('invoices.employee_id', '=', 'employees.id')
                ->whereRaw('invoices.created_at >= ? AND invoices.created_at <= ? ',[$StartDate,$EndDate]);
        })->selectRaw('employees.*,SUM(invoices.actual_price) as CurrentMonthSales,SUM(invoices.total_weight_18+invoices.total_weight_21) as CurrentMonthTotalWeight,SUM(invoices.total_weight_18) CurrentMonthTotalWeight_18,SUM(invoices.total_weight_21) CurrentMonthTotalWeight_21')
            ->groupBy(['employees.id','employees.name','employees.national_id','employees.current_weight_21','employees.current_weight_18','employees.number_of_items','bracelets_number_of_items','bracelets_current_weight_18','bracelets_current_weight_21','employees.created_at','employees.updated_at','employees.phone','employees.phone2']);
    }
}
