<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\FarmerReport;
use App\Models\Ledger;
use App\Models\MilkPayment;
use App\Models\User;
use Illuminate\Http\Request;

class MilkPaymentController extends Controller
{
    public function index(Request $request){
        if($request->getMethod()=="POST"){
            $payments=MilkPayment::join('users','users.id','milk_payments.user_id')->where(
                [
                    'milk_payments.session'=>$request->session,
                    'milk_payments.center_id'=>$request->center_id,
                    'milk_payments.year'=>$request->year,
                    'milk_payments.month'=>$request->month,
                ])->select('milk_payments.*','users.no','users.name')->get();
            // dd($payments);
            return view('admin.milk.payment.list',compact('payments'));
        }else{
            return view('admin.milk.payment.index');
        }
    }

    public function add(Request $request){

        $date = str_replace('-', '', $request->date);

        $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->no)->where('farmers.center_id',$request->center_id)->select('users.name','users.id','users.no','farmers.center_id')->first();
        $sessionChecked = FarmerReport::where(['user_id'=>$user->id,'year'=>$request->year,'month'=>$request->month,'session'=>$request->session])->count();
        if($sessionChecked>0){
            $payment=new MilkPayment();
            $payment->session=$request->session;
            $payment->year=$request->year;
            $payment->month=$request->month;
            $payment->center_id=$request->center_id;
            $payment->amount=$request->amount;
            $payment->user_id=$user->id;
            $payment->save();
            $payment->name=$user->name;
            $payment->no=$user->no;
            $ledger=new LedgerManage($user->id);
            $ledger->addLedger('Payment Milk Payment Given To Farmer',1,$request->amount,$date,'121',$payment->id);
            return view('admin.milk.payment.single',compact('payment'));
        }else{
            return '<tr class="text-center"><td colspan="4"> <strong> <span class="text-danger">Your payment has been failed due to Session is not closed yet !</span></strong></td></tr>';
        }
    }

    public function update(Request $request){
        // dd($request->all());
        $date = str_replace('-', '', $request->date);
        $payment=MilkPayment::find($request->id);
        $oldamount=$payment->amount;
        $payment->amount=$request->amount;
        $payment->save();

        $ledger=Ledger::find($request->id);
        dd($ledger);
        $user=User::find($ledger->user_id);
        $ledgers=Ledger::where('id','>',$request->ledger_id)->where('user_id',$ledger->user_id)->orderBy('id','asc')->get();

        $track=0;

        //find first point
        if($ledger->cr>0){
            $track=(-1)*$ledger->cr;
        }
        if($ledger->dr>0){
            $track=$ledger->dr;
        }
        echo 'first'.$track."<br>";

        //find old data

        if($ledger->type==1){
            $track+=$ledger->amount;
        }else{
            $track-=$ledger->amount;
        }

        echo 'second'.$track."<br>";


        if($request->type==1){
            $track-=$request->amount;
        }else{
            $track+=$request->amount;
        }

        echo 'third'.$track."<br>";

        $ledger->type=$request->type;
        $ledger->amount=$request->amount;

        if($track<0){
            $ledger->cr=(-1)*$track;
            $ledger->dr=0;
        }else{
            $ledger->dr=$track;
            $ledger->cr=0;
        }
        $ledger->save();

        foreach($ledgers as $l){

            if($l->type==1){
                $track-=$l->amount;
            }else{
                $track+=$l->amount;
            }

            if($track<0){
                $l->cr=(-1)*$track;
                $l->dr=0;
            }else{
                $l->dr=$track;
                $l->cr=0;
            }

            $l->save();

            echo $l->title . ",".$track."<br>";
        }

        $t=0;
        if($track>0){
            $t=2;

        }else if($track<0){
            $t=1;


        }


        $user->amount=$track;
        $user->amounttype=$t;
        $user->save();
    }

    public function del(Request $request){
        $date = str_replace('-', '', $request->date);
        $payment=MilkPayment::find($request->id);

        $payment->delete();

        $ledger=Ledger::find($request->ledger_id);
        $user=User::find($ledger->user_id);
        $ledgers=Ledger::where('id','>',$request->ledger_id)->where('user_id',$ledger->user_id)->orderBy('id','asc')->get();

        $track=0;

        $track=0;

        //find first point
        if($ledger->cr>0){
            $track=(-1)*$ledger->cr;
        }
        if($ledger->dr>0){
            $track=$ledger->dr;
        }
        echo 'first'.$track."<br>";

        //find old data

        if($ledger->type==1){
            $track+=$ledger->amount;
        }else{
            $track-=$ledger->amount;
        }
        $ledger->delete();


        foreach($ledgers as $l){

            if($l->type==1){
                $track-=$l->amount;
            }else{
                $track+=$l->amount;
            }

            if($track<0){
                $l->cr=(-1)*$track;
                $l->dr=0;
            }else{
                $l->dr=$track;
                $l->cr=0;
            }
            $l->save();

            echo $l->title . ",".$track."<br>";
        }

        $t=0;
        if($track>0){
            $t=2;

        }else if($track<0){
            $t=1;
            $track=(-1)*$track;

        }


        $user->amount=$track;
        $user->amounttype=$t;
        $user->save();
        return response('ok');
    }
}
