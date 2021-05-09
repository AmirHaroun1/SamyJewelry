<?php

namespace App\Http\Controllers;

use App\employee;
use App\Exports\EmployeeExport;
use App\products_invoices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminEmployeesController extends Controller
{
    //
    public function index(){
        return view('employees');
    }

    public function create(){
        return view('CreateEmployees');
    }
    public function edit(employee $employee){
        return view('EditEmployees',compact('employee'));
    }
    public function store(Request $request){

        DB::beginTransaction();

        try{
            $employee =  employee::create($request->except('weight_change'));
            if($request->exists('weight_change')){
                $request['NewEmployee'] = true;
                $employee->RecordNewWeightChange($request);
            }
            DB::commit();

        }catch (Exception $e){
            return response()->json(['Error'=>$request->all()],400);
            DB::rollBack();
        }


        return response()->json(['NewEmployee'=>$employee],200);


    }
    public function update(Request $request,employee $employee,$calledFromAnotherController = false){

        DB::beginTransaction();

        try{
            if($request->exists('weight_change')){
                if($request->exists('bracelets_change')){
                    $employee->RecordNewWeightChangeForBracelet($request);
                    $employee->updateBraceletsWeight($request);
                }else{
                    $employee->RecordNewWeightChange($request);
                    $employee->updateWeight($request);
                }
            }else{
                $employee = $employee->update($request->all());
            }
            DB::commit();
            return response()->json([],200);
        }catch (Exception $e){
            return response()->json(['errormessage' =>$e] , 400);
            DB::rollBack();
        }
        if (!$calledFromAnotherController){
            return response()->json([],500);
        }
    }

    public function ExportSalesExcel($employeeID,$employeeName){

       /* return products_invoices::with(['owner_employee:id,name','product:id,name'])
            ->whereHas('invoice',function ($query)use($employeeID){
                $query->where('employee_id',$employeeID);
            })->get();*/

        return (new EmployeeExport( $employeeID,$employeeName,\request('StartDate'),\request('EndDate') ))->download(time().$employeeName.'.xlsx');

    }
}
