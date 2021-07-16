<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Employee;
use App\Models\EmployeeAdvance;
use App\Models\EmployeeSession;
use App\Models\Ledger;
use App\Models\SalaryPayment;
use App\Models\User;
use App\NepaliDate;
use Illuminate\Http\Request;

class EmployeeController1 extends Controller
{
    public function index()
    {
        return view('admin.emp.index');
    }

    public function add(Request $request)
    {
        $user = new User();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 4;
        $user->password = bcrypt($request->phone);
        $user->save();

        $emp = new Employee();
        $emp->user_id = $user->id;
        $emp->salary = $request->salary;
        $emp->acc = $request->acc;
        $emp->save();

        return view('admin.emp.single', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::where('id', $request->id)->where('role', 4)->first();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 4;
        $user->password = bcrypt($request->phone);
        $user->save();
        $emp = Employee::where('user_id', $user->id)->first();
        $emp->salary = $request->salary;
        $emp->acc = $request->acc;
        $emp->save();
        return view('admin.emp.single', compact('user'));
    }

    public function list()
    {
        $emp = User::latest()->where('role', 4)->get();
        return view('admin.emp.list', compact('emp'));
    }

    public function delete(Request $request)
    {
        $user = User::where('id', $request->id)->where('role', 4)->first();
        $user->delete();
    }

    public function detail($id)
    {
        $user = User::where('id', $id)->where('role', 4)->first();
        // return view('admin.emp.detail',compact('user'));
        return view('admin.emp.detail1', compact('user'));
    }

    public function loadData(Request $request)
    {
        // $range=[];
        // dd($request->all());
        // $salary = SalaryPayment::where('user_id',$request->user_id);
        // $employee = EmployeeAdvance::join('employees','employees.id','=','employee_advances.employee_id')->where('employees.user_id',$request->user_id);
        // if($request->type == 1){
        //     $range=NepaliDate::getDateYear($request->year);
        //     $employee = $employee->where('employee_advances.date','>=',$range[1])->where('employee_advances.date','<=',$range[2])->get();
        //     $salary = $salary->where('year',$request->year)->get();
        // }
        // if($request->type == 2){
        //     $range=NepaliDate::getDateMonth($request->year,$request->month);
        //     $employee = $employee->where('employee_advances.date','>=',$range[1])->where('employee_advances.date','<=',$range[2])->get();
        //     $salary = $salary->where('year',$request->year)->where('month',$request->month)->get();
        // }
        // return view('admin.emp.data',compact('salary','employee'));

        $year = $request->year;
        $month = $request->month;
        $week = $request->week;
        $session = $request->session;
        $type = $request->type;
        $range = [];
        $data = [];
        $date = 1;
        $title = "";
        $ledger = Ledger::where('user_id', $request->user_id);
        if ($type == 0) {
            $range = NepaliDate::getDate($request->year, $request->month, $request->session);
            $ledger = $ledger->where('date', '>=', $range[1])->where('date', '<=', $range[2]);
            $title = "<span class='mx-2'>Year:" . $year . "</span>";
            $title .= "<span class='mx-2'>Month:" . $month . "</span>";
            $title .= "<span class='mx-2'>Session:" . $session . "</span>";
        } elseif ($type == 1) {
            $date = $date = str_replace('-', '', $request->date1);
            $ledger = $ledger->where('date', '=', $date);
            $title = "<span class='mx-2'>Date:" . _nepalidate($date) . "</span>";
        } elseif ($type == 2) {
            $range = NepaliDate::getDateWeek($request->year, $request->month, $request->week);
            $ledger = $ledger->where('date', '>=', $range[1])->where('date', '<=', $range[2]);
            $title = "<span class='mx-2'>Year:" . $year . "</span>";
            $title .= "<span class='mx-2'>Month:" . $month . "</span>";
            $title .= "<span class='mx-2'>Week:" . $week . "</span>";
        } elseif ($type == 3) {
            $range = NepaliDate::getDateMonth($request->year, $request->month);
            $ledger = $ledger->where('date', '>=', $range[1])->where('date', '<=', $range[2]);
            $title = "<span class='mx-2'>Year:" . $year . "</span>";
            $title .= "<span class='mx-2'>Month:" . $month . "</span>";
        } elseif ($type == 4) {
            $range = NepaliDate::getDateYear($request->year);
            $ledger = $ledger->where('date', '>=', $range[1])->where('date', '<=', $range[2]);
            $title = "<span class='mx-2'>Year:" . $year . "</span>";
        } elseif ($type == 5) {
            $range[1] = str_replace('-', '', $request->date1);;
            $range[2] = str_replace('-', '', $request->date2);;
            $ledger = $ledger->where('date', '>=', $range[1])->where('date', '<=', $range[2]);
            $title = "<span class='mx-2'>from:" . $request->date1 . "</span>";
            $title .= "<span class='mx-2'>To:" . $request->date2 . "</span>";
        }
        // dd($ledger->toSql(),$ledger->getBindings());
        $ledgers = $ledger->orderBy('id', 'asc')->get();
        // dd($ledgers);
        $user = User::where('id', $request->user_id)->first();

        return view('admin.emp.data1', compact('ledgers', 'type', 'user', 'title'));
    }

    // employee advance controller

    public function advance()
    {
        return view('admin.emp.advance.index');
    }

    public function getAdvance(Request $request)
    {
        $date = str_replace('-', '', $request->date);
        $advances = EmployeeAdvance::where('date', $date)->get();

        return view('admin.emp.advance.list', compact('advances'));
    }
    public function addAdvance(Request $request)
    {

        $date = str_replace('-', '', $request->date);
        $np = new NepaliDate($date);


        $employee = Employee::where('id', $request->employee_id)->first();

        if (!($employee->sessionClosed($np->year, $np->month))) {
            return response('previous Month Not Closed', 500);
        }
        $advance = new EmployeeAdvance();
        $advance->employee_id = $request->employee_id;
        $advance->title = $request->title;
        $advance->amount = $request->amount;
        $advance->date = $date;
        $advance->save();

        $ledger = new LedgerManage($employee->user_id);
        $ledger->addLedger('Advance Given-(' . $request->title . ')', 1, $request->amount, $date, '112', $advance->id);
        return view('admin.emp.advance.single', compact('advance'));
    }

    public function updateAdvance(Request $request)
    {
        $date = str_replace('-', '', $request->date);
        $advance = EmployeeAdvance::find($request->id);
        $tempamount = $advance->amount;
        $advance->title = $request->title;
        $advance->amount = $request->amount;
        $advance->save();
        $ledger = new LedgerManage($advance->employee->user_id);
        $ledger->addLedger('Advance Canceled', 2, $tempamount, $date, '113', $advance->id);
        $ledger->addLedger('Advance Updated-(' . $request->title . ')', 1, $request->amount, $date, '112', $advance->id);
        return response()->json(['status' => 'success']);
    }

    public function delAdvance(Request $request)
    {
        $date = str_replace('-', '', $request->date);
        $advance = EmployeeAdvance::find($request->id);
        $tempamount = $advance->amount;
        $advance->delete();
        $ledger = new LedgerManage($advance->employee->user_id);
        $ledger->addLedger('Advance Canceled', 2, $tempamount, $date, '113', $advance->id);
        return response()->json(['status' => 'success']);
    }





    // employee salary pay

    public function salaryIndex()
    {
        return view('admin.emp.salarypay.index');
    }

    public function loadEmpData(Request $request)
    {
        // dd($request->all());
        $range = [];

        $employee = Employee::where('id', $request->emp_id)->first();
        $user = $employee->user;
        $range = NepaliDate::getDateMonth($request->year, $request->month);
        $ledgers = Ledger::where('date', '>=', $range[1])->where('date', '<=', $range[2])->where('user_id', $user->id)->get();
        $empSession = EmployeeSession::where('year', $request->year)->where('month', $request->month)->where('user_id', $user->id)->first();
        // dd($ledgers);
        return view('admin.emp.salarypay.data_new', compact('ledgers', 'user', 'employee', 'empSession'));

        // $salary = Employee::where('id',$request->emp_id)->select('salary')->first();
        // if($employee->count()>0){
        //     $range=NepaliDate::getDateMonth($request->year,$request->month);
        //     $employee = $employee->where('employee_advances.date','>=',$range[1])->where('employee_advances.date','<=',$range[2])->get();
        //     // dd($employee);
        //     return view('admin.emp.salarypay.data',compact('employee','salary'));
        // }else{
        //     $salary = Employee::where('id',$request->emp_id)->select('salary')->first();
        //     $employee=[];
        //     return view('admin.emp.salarypay.data',compact('employee','salary'));
        // }

    }

    public function storeSalary(Request $request)
    {
        // dd($request->all());
        $date = str_replace('-', '', $request->date);
        $employee = Employee::where('id', $request->emp_id)->first();
        $np = new NepaliDate($date);
        if (!($employee->sessionClosed($np->year, $np->month))) {
            return response('previous Month Not Closed', 500);
        } else {
            $salaryPay = new SalaryPayment();
            $salaryPay->date = $date;
            $salaryPay->year = $request->year;
            $salaryPay->month = $request->month;
            $salaryPay->amount = $request->pay;
            $salaryPay->payment_detail = $request->desc;
            $salaryPay->user_id = $employee->user_id;
            $salaryPay->save();
            $ledger = new LedgerManage($employee->user_id);
            $ledger->addLedger('Salary Paid for', 1, $request->pay, $date, '124', $salaryPay->id);
            echo 'ok';
        }
    }


    public function amountTransfer(Request $request)
    {
        // dd($request->all());
        $date = str_replace('-', '', $request->date);
        $employee = Employee::where('id', $request->emp_id)->first();
        $checkUser = SalaryPayment::where('year', $request->year)->where('month', $request->month)->where('user_id', $employee->user_id)->count();
        if ($checkUser > 0) {
            echo 'notok';
        } else {
            $salaryPay = new SalaryPayment();
            $salaryPay->date = $date;
            $salaryPay->year = $request->year;
            $salaryPay->month = $request->month;
            $salaryPay->amount = 0;
            $salaryPay->payment_detail = $request->desc;
            $salaryPay->user_id = $employee->user_id;
            $salaryPay->save();
            $ledger = new LedgerManage($employee->user_id);
            $ledger->addLedger('Salary Paid through balance transfer for:-(' . $request->year . '-' . $request->month . ')', 1, 0, $date, '124', $salaryPay->id);
            $advance = new EmployeeAdvance();
            $advance->date = $date;
            $advance->amount = $request->transfer_amount;
            $advance->employee_id = $employee->id;
            $advance->title = "Previous advance transfer";
            $advance->save();
            echo 'ok';
        }
    }

    public function paidList(Request $request)
    {
        // dd($request->all());
        if ($request->emp_id != -1) {
            $employee = Employee::where('id', $request->emp_id)->first();
            $salary = SalaryPayment::where('year', $request->year)->where('month', $request->month)->where('user_id', $employee->user_id)->get();
        } else {
            $salary = SalaryPayment::where('year', $request->year)->where('month', $request->month)->get();
        }
        return view('admin.emp.salarypay.list', compact('salary'));
    }
    //XXX Employee Month Closing
    public function closeSession(Request $request)
    {
        $employee = Employee::where('id', $request->emp_id)->first();

        //check if session is closed already
        if (EmployeeSession::where('year', $request->year)->where('month', $request->year)->where('user_id', $employee->user_id)->count() > 0) {
            return response("Month Already Closed");
        }

        if ($employee->sessionClosed($request->year, $request->month)) {
            $range = NepaliDate::getDateMonth($request->year, $request->month);
            //track month blance wwith respect to salary
            $cr = Ledger::where('date', '>=', $range[1])->where('date', '<=', $range[2])->where('user_id', $employee->user_id)->where('type', 1)->sum('amount');
            $dr = Ledger::where('date', '>=', $range[1])->where('date', '<=', $range[2])->where('user_id', $employee->user_id)->where('type', 2)->sum('amount');
            $track = $dr - $cr;
            $remaning = $track + $employee->salary;

            $l=[];
            //input salary into ledger
            $lm = new LedgerManage($employee->user_id);
            $lastdate = NepaliDate::getDateMonthLast($request->year, $request->month);
            $l[0]=$lm->addLedger('salary For (' . $request->year . "-" . ($request->month < 10 ? "0" . $request->month : $request->month) . ")", 2, $employee->salary, $lastdate, 129);


            //move remaning balance to another month
            if ($remaning != 0) {
                $_remaning=$remaning<0?(-1*$remaning):$remaning;
                $l[1]=$lm->addLedger('Closing Balance', $remaning < 0 ? 2 : 1, $_remaning, $lastdate, 130);
                $nextMonthRange = NepaliDate::nextMonthStatic($request->year, $request->month);
                $firstDate = NepaliDate::getDateMonthFirst($nextMonthRange[0], $nextMonthRange[1]);
                $l[2]=$lm->addLedger('Opening Balance', $remaning < 0 ? 1: 2, $_remaning, $firstDate, 113);
            }
            $sessionClose=new EmployeeSession();
            $sessionClose->user_id=$employee->user_id;
            $sessionClose->month=$request->month;
            $sessionClose->year=$request->year;
            $sessionClose->save();
            return response('Session closed successfully!');
            // return response()->json([$remaning,$sessionClose,$l,$lastdate,$firstDate,$nextMonthRange,$range]);
        } else {
            return response('previous Month Not Closed', 500);
        }
    }

    //XXX Employee Account Opening
    public function accountIndex(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $date = str_replace('-', '', $request->date);
            $ledgers = Ledger::join('users', 'ledgers.user_id', '=', 'users.id')->select('ledgers.id', 'users.name', 'ledgers.amount', 'ledgers.type')->where('ledgers.date', $date)->where('ledgers.identifire', 113)->get();
            return view('admin.emp.account.list', compact('ledgers'));
        } else {
            $emps = User::where('role', 4)->select('name', 'id')->get();
            return view('admin.emp.account.index', compact('emps'));
        }
    }
    public function accountAdd(Request $request)
    {
        $date = str_replace('-', '', $request->date);
        $ledgerManager = new LedgerManage($request->employee);
        $ledger = $ledgerManager->addLedger('Opening Balance', $request->type, $request->amount, $date, '113');
        $ledger->name = User::where('id', $request->employee)->select('name')->first()->name;
        return view('admin.emp.account.single', compact('ledger'));
    }
}

