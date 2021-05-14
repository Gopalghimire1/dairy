<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advance;
use App\Models\Distributorsell;
use App\Models\EmployeeAdvance;
use App\Models\Expense;
use App\Models\Ledger;
use App\Models\MilkPayment;
use App\Models\SalaryPayment;
use App\Models\Sellitem;
use App\NepaliDate;
use Illuminate\Http\Request;

class CashflowController extends Controller
{
    public function index(){
        return view('admin.cash-flow.index');
    }

    public function data(Request $request){
        $type=$request->type;
        $range=[];

        $expense = Expense::orderBy('id','desc');
        $milkPayment = Ledger::where('identifire',121);
        $farmerAdvance = Advance::orderBy('id','desc');
        $sellItems = Sellitem::orderBy('id','desc');
        $distributorSell = Distributorsell::orderBy('id','desc');
        $empAdvance = EmployeeAdvance::orderBy('id','desc');
        $empSalary = SalaryPayment::orderBy('id','desc');
        if($type==0){
        }elseif($type==1){
            $date=$date = str_replace('-','',$request->date1);
            $expense=$expense->where('date','=',$date);
            $milkPayment=$milkPayment->where('date','=',$date);
            $farmerAdvance=$farmerAdvance->where('date','=',$date);
            $sellItems=$sellItems->where('date','=',$date);
            $distributorSell=$distributorSell->where('date','=',$date);
            $empAdvance=$empAdvance->where('date','=',$date);
            $empSalary=$empSalary->where('date','=',$date);

        }elseif($type==2){
            $range=NepaliDate::getDateWeek($request->year,$request->month,$request->week);
           $expense=$expense->where('date','>=',$range[1])->where('date','<=',$range[2]);
           $milkPayment=$milkPayment->where('date','>=',$range[1])->where('date','<=',$range[2]);
           $farmerAdvance=$farmerAdvance->where('date','>=',$range[1])->where('date','<=',$range[2]);
           $sellItems=$sellItems->where('date','>=',$range[1])->where('date','<=',$range[2]);
           $distributorSell=$distributorSell->where('date','>=',$range[1])->where('date','<=',$range[2]);
           $empAdvance=$empAdvance->where('date','>=',$range[1])->where('date','<=',$range[2]);
           $empSalary=$empSalary->where('date','>=',$range[1])->where('date','<=',$range[2]);


        }elseif($type==3){
            $range=NepaliDate::getDateMonth($request->year,$request->month);
            $expense=$expense->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $milkPayment=$milkPayment->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $farmerAdvance=$farmerAdvance->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $sellItems=$sellItems->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $distributorSell=$distributorSell->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $empAdvance=$empAdvance->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $empSalary=$empSalary->where('date','>=',$range[1])->where('date','<=',$range[2]);

        }elseif($type==4){
            $range=NepaliDate::getDateYear($request->year);
            $expense=$expense->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $milkPayment=$milkPayment->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $farmerAdvance=$farmerAdvance->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $sellItems=$sellItems->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $distributorSell=$distributorSell->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $empAdvance=$empAdvance->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $empSalary=$empSalary->where('date','>=',$range[1])->where('date','<=',$range[2]);

        }elseif($type==5){
            $range[1]=str_replace('-','',$request->date1);;
            $range[2]=str_replace('-','',$request->date2);;
            $expense=$expense->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $milkPayment=$milkPayment->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $farmerAdvance=$farmerAdvance->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $sellItems=$sellItems->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $distributorSell=$distributorSell->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $empAdvance=$empAdvance->where('date','>=',$range[1])->where('date','<=',$range[2]);
            $empSalary=$empSalary->where('date','>=',$range[1])->where('date','<=',$range[2]);
        }
        $expense = $expense->sum('amount');
        $milkPayment = $milkPayment->sum('amount');
        $farmerAdvance = $farmerAdvance->sum('amount');
        $sellItems = $sellItems->sum('total');
        $distributorSell = $distributorSell->sum('total');
        $empAdvance = $empAdvance->sum('amount');
        $empSalary = $empSalary->sum('amount');
        // dd($farmerAdvance);
        return view('admin.cash-flow.data',compact('expense','milkPayment','farmerAdvance','sellItems','distributorSell','empAdvance','empSalary'));
    }
}
