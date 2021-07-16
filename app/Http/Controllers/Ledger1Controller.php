<?php

namespace App\Http\Controllers;

use App\LedgerManage;
use App\Models\Advance;
use App\Models\DistributorPayment;
use App\Models\Distributorsell;
use App\Models\EmployeeAdvance;
use App\Models\Farmerpayment;
use App\Models\Ledger;
use App\Models\MilkPayment;
use App\Models\Sellitem;
use App\Models\Supplierbill;
use App\Models\Supplierpayment;
use App\Models\User;
use Illuminate\Http\Request;

class Ledger1Controller extends Controller
{
    /*
    *amounttype[1="CR",2="DR"]
    * "101"= Aalya --
    * "102"= "farmer opening balance/advance" --
    * "103" = "item sell" --
    * "104" = "Farmer Advance"--
    * "106" = "Farmer amount paid at Selling item"v--
    * "107" = "Amount paid by farmer" --
    * "108" = "Payment For Milk" --
    * "109" = "Closing Balance Farmer" --
    * "110" = "Automatic payment Given to famer when closing" --
    * "116" = "Farmer item return"
    * "117" = "Farmer item return paid cancel"
    * "121" = "Farmer paid for milk" --
    * "124" = "Farmer Bonus" --

    * "114" = "distributer Payment" --
    * "115" = "distributer sell cancel" --
    * "118" = "Account Adjustment"
    * "119" = "Distributor opening balance"
    * "120" = ""

    * "112" = "Employee Advaance payment"
    * "113" = "Employee Advaance payment cancel"
    * "124" = "Employee Salary payment"
    * "122" = "paid amount while billing"
    * "123" = "purchase in billing items"



    * "125" = "purchase from suppliers"
    * "126" = "paid to suppliers through billing entry"
    * "127" = "Payment to supplier"
    * "128" = "Previous balance of supplier"

    */
    public function edit(Request $request){
        $ledger=Ledger::where('id',$request->id)->first();
        if($ledger->identifire==103){
            $sellitem=Sellitem::where('id',$ledger->foreign_key)->first();
            return view('admin.ledger.sellitem-edit',compact('ledger','sellitem'));
        }else if($ledger->identifire==125){
            return response("<h5 class='text-center'>Supplier Bill Cannot Be Edited From This interface</h5>");
        }else{
            return view('admin.ledger.edit',compact('ledger'));
        }
    }

    public function update(Request $request){
        $ledger=Ledger::where('id',$request->id)->first();
        $user=User::find($ledger->user_id);
        $title=$ledger->title;
        $i=$ledger->identifire;
        $key=$ledger->foreign_key;
        $type=$request->type;
        if($i==103){
            $type=1;
            $sellitem=Sellitem::where('id',$key)->first();
            $title=$sellitem->item->name.' ('.$request->rate .' X '.$request->qty.''.$sellitem->item->unit. ')';
            $sellitem->rate=$request->rate;
            $sellitem->qty=$request->qty;
            $sellitem->total=$request->amount;
            $sellitem->due = $sellitem->total - $sellitem->paid;
            $sellitem->save();
        }else if($i==104){
            $type=1;
            $advance=Advance::where('id',$key)->first();
            $advance->amount=$request->amount;
            $advance->save();
        }else if($i==107){
            $type=2;
            $advance=Farmerpayment::where('id',$key)->first();
            $advance->amount=$request->amount;
            $advance->save();
        }else if($i==121){
            $type=1;
            $payment=MilkPayment::where('id',$key)->first();
            $payment->amount=$request->amount;
            $payment->save();
        }else if($i==114){
            $type=2;
            $payment=DistributorPayment::where('id',$key)->first();
            $payment->amount=$request->amount;
            $payment->save();
        }else if($i==112){
            $type=1;
            $payment=EmployeeAdvance::where('id',$key)->first();
            $payment->amount=$request->amount;
            $payment->save();
        }else if($i==127){
            $type=2;
            $payment=Supplierpayment::where('id',$key)->first();
            $payment->amount=$request->amount;
            $payment->save();
        }
        $ledgers=Ledger::where('id','>',$request->id)->where('user_id',$ledger->user_id)->orderBy('id','asc')->get();
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

        //set new data
        if($type==1){
            $track-=$request->amount;
        }else{
            $track+=$request->amount;
        }

        echo 'third'.$track."<br>";


        $ledger->type=$type;
        $ledger->amount=$request->amount;
        $ledger->title=$title;
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
            $track=(-1)*$track;


        }


        $user->amount=$track;
        $user->amounttype=$t;
        $user->save();
    }

    public function del(Request $request){
        $ledger=Ledger::where('id',$request->id)->first();
        $user=User::find($ledger->user_id);
        $i=$ledger->identifire;
        $key=$ledger->foreign_key;
        $foreign=null;
        if($i==103){
            $foreign=Sellitem::where('id',$key)->first();
        }else if($i==104){

            $foreign=Advance::where('id',$key)->first();

        }else if($i==107){

            $foreign=Farmerpayment::where('id',$key)->first();

        }else if($i==121){

           $foreign=MilkPayment::where('id',$key)->first();

        }else if($i==112){

            $foreign=EmployeeAdvance::where('id',$key)->first();

         }else if($i==114){

           $foreign=DistributorPayment::where('id',$key)->first();

        }else if($i==127){

           $foreign=Supplierpayment::where('id',$key)->first();

        }
        if($foreign!=null){
            $foreign->delete();
        }
        $ledgers=Ledger::where('id','>',$request->id)->where('user_id',$ledger->user_id)->orderBy('id','asc')->get();
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
