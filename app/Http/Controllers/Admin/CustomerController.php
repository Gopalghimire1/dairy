<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\Ledger;
use App\Models\User;
use App\NepaliDate;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        return view('admin.customer.index',['customers'=>Customer::with('user')->get()]);
    }

    public function add(Request $request){
        $user = new User();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->amount = $request->amount??0;
        $user->amounttype = $request->amounttype??0;
        $user->role = 2;
        $user->password = bcrypt($request->phone);
        $user->save();
        $customer = new Customer();
        $customer->user_id=$user->id;
        $customer->save();
        $customer->user=$user;
        if($request->filled('json')){
            return response()->json($customer);
        }else{
            return view('admin.customer.single',compact('customer'));
        }
    }

    public function update(Request $request){
        $customer = Customer::where('id',$request->id)->first();
        $user = User::where('id',$customer->user_id)->first();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->save();
        $customer->user=$user;
        if($request->filled('json')){
            return response()->json($customer);
        }else{
            return view('admin.customer.single',compact('customer'));
        }
    }

    public function detail($id,Request $request){
        $user=User::where('id',$id)->first();
        if($request->getMethod()=="POST"){
            $year=$request->year;
            $month=$request->month;
            $week=$request->week;
            $session=$request->session;
            $type=$request->type;
            $range=[];
            $data=[];
            $date=1;
            $title="";
            $ledger=Ledger::where('user_id',$request->user_id);
            if($type==0){
                $range = NepaliDate::getDate($request->year,$request->month,$request->session);
                $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);
                $title="<span class='mx-2'>Year:".$year ."</span>";
                $title.="<span class='mx-2'>Month:".$month ."</span>";
                $title.="<span class='mx-2'>Session:".$session ."</span>";

            }elseif($type==1){
                $date=$date = str_replace('-','',$request->date1);
               $ledger=$ledger->where('date','=',$date);
               $title="<span class='mx-2'>Date:"._nepalidate($date) ."</span>";

            }elseif($type==2){
                $range=NepaliDate::getDateWeek($request->year,$request->month,$request->week);
                $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);
                $title="<span class='mx-2'>Year:".$year ."</span>";
                $title.="<span class='mx-2'>Month:".$month ."</span>";
                $title.="<span class='mx-2'>Week:".$week ."</span>";

            }elseif($type==3){
                $range=NepaliDate::getDateMonth($request->year,$request->month);
               $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);
               $title="<span class='mx-2'>Year:".$year ."</span>";
                $title.="<span class='mx-2'>Month:".$month ."</span>";

            }elseif($type==4){
                $range=NepaliDate::getDateYear($request->year);
                $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);
                $title="<span class='mx-2'>Year:".$year ."</span>";


            }elseif($type==5){
                $range[1]=str_replace('-','',$request->date1);;
                $range[2]=str_replace('-','',$request->date2);;
                 $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);
                 $title="<span class='mx-2'>from:".$request->date1 ."</span>";
                $title.="<span class='mx-2'>To:".$request->date2 ."</span>";

            }
            // dd($ledger->toSql(),$ledger->getBindings());
            $ledgers=$ledger->orderBy('id','asc')->get();
            $user=User::where('id',$request->user_id)->first();

            return view('admin.customer.load_detail',compact('ledgers','type','user','title'));
        }else{
            return view('admin.customer.detail',compact('user'));
        }
    }
    
    public function payment(Request $request){
        if($request->getMethod()=="POST"){
            $user=User::find($request->id);
            return view('admin.customer.payement.data',compact('user'));
        }else{
            return view('admin.customer.payement.index',[
                'customers'=>Customer::with('user')->get(),
            ]);

        }
    }

    public function addPayment(Request $request){
        $date = str_replace('-','',$request->date);
        $user=User::find($request->id);
        $payment=new CustomerPayment();
        $payment->amount=$request->amount;
        $payment->description=$request->description;
        $payment->date=$date;
        $payment->user_id=$request->id;
        $payment->save();

        $ledger=new LedgerManage($user->id);
        $ledger->addLedger("Payment",2,$payment->amount,$date,132,$payment->id);

        $user=User::find($request->id);
        return view('admin.customer.payement.data',compact('user'));
        
    }

}
