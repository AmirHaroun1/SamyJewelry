<?php

namespace App\Http\Controllers;

use App\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiAdminInvoicesController extends Controller
{
    //
    public function index(){

        //$Invoices = invoices::with('seller')->paginate(20);
        $Invoices = DB::table('invoices')
                    ->when( ( !is_null(\request('StartDate') ) && \request('StartDate') != '' ),function($query){
                         $query->whereRaw('invoices.created_at >= ? ',[\request('StartDate')] );
                     })
                     ->when( ( !is_null(\request('EndDate') ) && \request('EndDate') != '' ),function($query){
                         $query->whereRaw('invoices.created_at <= ? ',[\request('EndDate')] );
                     })
                    ->join('employees','invoices.employee_id' ,'=','employees.id')
                    ->select(DB::raw('employees.name as seller_name,employees.id as seller_id,invoices.*'))
                    ->latest()
                    ->paginate(20)->appends([
                        'page' => \request('page'),
                        'StartDate'=>request('StartDate'),
                        'EndDate'=>request('EndDate'),
                    ]);
        return response()->json(['Invoices'=>$Invoices],200);
    }
    public function loadProducts(invoices $invoice){
         $invoice->load(['products']);
        return response()->json(['invoice' => $invoice] , 200);
    }
    public function search(){

    }
}
