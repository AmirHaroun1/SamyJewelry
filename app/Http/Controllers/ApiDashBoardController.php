<?php

namespace App\Http\Controllers;

use App\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiDashBoardController extends Controller
{
    //
    public function index(){
        $InvoicesStats = null;
        $employees = null;
        $PaymentStats = null;
        if(\request('WithInvoicesStats')){
        $InvoicesStats =   DB::table('invoices')
            ->selectRaw('COUNT(id) as TotalInvoices , SUM(total_price) as TotalSoldPrice, SUM(actual_price) as TotalActualPrice, SUM(paid_in_visa) as TotalPaidInVisa, SUM(paid_in_cache) as TotalPaidInCache, SUM(total_weight_18) as TotalSoldWeight_18, SUM(total_weight_21) as TotalSoldWeight_21, SUM(from_buyer_total_weight_18) as FromBuyerTotalWeight_18, SUM(from_buyer_total_weight_21) as FromBuyerTotalWeight_21')
            ->when( ( !is_null(\request('StartDate') ) && \request('StartDate') != '' ),function($query){
                $query->whereRaw('invoices.created_at >= ? ',[\request('StartDate')] );
            })
            ->when( ( !is_null(\request('EndDate') ) && \request('EndDate') != '' ),function($query){
                $query->whereRaw('invoices.created_at <= ? ',[\request('EndDate')] );
            })
            ->first();
        }
       if(\request('WithPaymentsStats')){
           $PaymentStats = DB::table('payments')
                ->selectRaw('SUM(price) as paid_price,SUM(weight_amount_18) as paid_weight_18,SUM(weight_amount_21) as paid_weight_21')
               ->when( ( !is_null(\request('StartDate') ) && \request('StartDate') != '' ),function($query){
                   $query->whereRaw('payments.created_at >= ? ',[\request('StartDate')] );
               })
               ->when( ( !is_null(\request('EndDate') ) && \request('EndDate') != '' ),function($query){
                   $query->whereRaw('payments.created_at <= ? ',[\request('EndDate')] );
               })
               ->first();
       }
      if(\request('WithEmployeesStats')){
          $employees = employee::WithCurrentMonthStats()->orderBy('CurrentMonthTotalWeight','DESC')->paginate(5)->appends(\request()->all());
      }
      return response()->json(['InvoiceStats'=>$InvoicesStats,'employees'=>$employees,'PaymentStats'=>$PaymentStats],200);
    }
}
