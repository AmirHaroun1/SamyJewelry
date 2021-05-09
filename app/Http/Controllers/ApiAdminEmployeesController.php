<?php

namespace App\Http\Controllers;

use App\employee;
use App\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiAdminEmployeesController extends Controller
{
    //
    public function index(){
        if(\request('withPagination')){
             $employees = employee::WithCurrentMonthStats()->paginate(20);
        }else{
            $employees = DB::table('employees')->selectRaw('id,name')->get();
        }
        return response()->json(['employees'=>$employees],200);
    }
    public function search(){
        $employees = employee::WithCurrentMonthStats()->where('name','LIKE',\request('EmployeeName').'%')->get();

        return response()->json(['SearchedEmployees'=>$employees],200);
    }
    public function weight_history($employeeID){
        $GoldTransactionHistory =
            DB::table('weight_change')
            ->whereRaw('employee_id = ?',[$employeeID])
            ->when(!is_null(\request('ComparingDate')),function ($query){
                $query->whereRaw('created_at = ?',[\request('ComparingDate')]);
            })
            ->latest('created_at')
            ->paginate(20);

        return response()->json(['GoldTransactionHistory'=>$GoldTransactionHistory],200);
    }
    public function search_weight_history($employeeID){
        $SearchedEmployeeGoldHistory =
            DB::table('weight_change')
                ->whereRaw('employee_id = ?',[$employeeID])
                ->whereRaw('DATE(created_at) = ?',[\request('ComparingDate')])
                ->latest('created_at')
                ->paginate(20)->appends([
                    'employee_id' => \request('employee_id'),
                    'ComparingDate' => \request('ComparingDate')
                ]);
        return response()->json(['SearchedEmployeeGoldHistory'=>$SearchedEmployeeGoldHistory],200);
    }
    public function invoices($employeeID){
        $Invoices = invoices::
                     selectRaw('*')
                    ->when( ( !is_null(\request('StartDate') ) && \request('StartDate') != '' ),function($query){
                        $query->whereRaw('created_at >= ? ',[\request('StartDate')] );
                    })
                    ->when( ( !is_null(\request('EndDate') ) && \request('EndDate') != '' ),function($query){
                        $query->whereRaw('created_at <= ? ',[\request('EndDate')] );
                    })
                    ->latest()
                    ->where('employee_id',$employeeID)
                    ->paginate(20)->appends([
                        'page' => \request('page'),
                        'employeeID'=>request('employeeID'),
                        'StartDate'=>request('StartDate'),
                        'EndDate'=>request('EndDate'),
                        'WithStats'=>request('WithStats'),
                    ]);
        $EmployeeSalesStats = 0;
        if(\request('WithStats') == true){

            $EmployeeSalesStats = invoices::selectRaw('SUM(actual_price) as TotalSoldPrice, SUM(total_weight_18) as TotalSoldWeight_18, SUM(total_weight_21) as TotalSoldWeight_21')
                ->when( ( !is_null(\request('StartDate') ) && \request('StartDate') != '' ),function($query){
                    $query->whereRaw('created_at >= ? ',[\request('StartDate')] );
                })
                ->when( ( !is_null(\request('EndDate') ) && \request('EndDate') != '' ),function($query){
                    $query->whereRaw('created_at <= ? ',[\request('EndDate')] );
                })
                ->where('employee_id',$employeeID)
                ->first();
        }

        return response()->json(['Invoices'=>$Invoices , 'EmployeeSalesStats' => $EmployeeSalesStats],200);
    }
}
