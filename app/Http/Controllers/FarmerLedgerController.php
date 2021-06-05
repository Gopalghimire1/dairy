<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Ledger;
use App\Models\MilkPayment;
use App\Models\Sellitem;
use App\Models\User;
use Illuminate\Http\Request;

class FarmerLedgerController extends Controller
{
    public function sellUpdate(Request $request){
        $ledger=Ledger::find($request->id);

        $sell=Sellitem::find($ledger->foreign_key);
        $title=$sell->item->name.' ('.$request->rate .' X '.$request->qty.''.$sell->item->unit. ')';
        $sell->rate=$request->rate;
        $sell->qty=$request->qty;
        $sell->total=$request->amount;
        $sell->due = $sell->total - $sell->paid;
        $sell->save();

        $user=User::find($ledger->user_id);
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


        if($ledger->type==1){
            $track-=$request->amount;
        }else{
            $track+=$request->amount;
        }

        echo 'third'.$track."<br>";


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
        // LedgerManage::ad();

    }

    public function sellDel(Request $request){
        $ledger=Ledger::find($request->id);

        $sell=Sellitem::find($ledger->foreign_key);
        $sell->delete();

        $user=User::find($ledger->user_id);
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
        // LedgerManage::ad();

    }

    public function update(Request $request){
        $ledger=Ledger::find($request->id);
        $user=User::find($ledger->user_id);

        $ledgers=Ledger::where('id','>',$request->id)->where('user_id',$ledger->user_id)->orderBy('id','asc')->get();

        $track=0;

        //check if it is advance
        if($ledger->identifire == 104){
            $adv = Advance::where('id',$ledger->foreign_key)->first();
            $adv->amount = $request->amount;
            $adv->save();
        }

        //check if is milk payment

        if($ledger->identifire == 121){
            $pay = MilkPayment::where('id',$ledger->foreign_key)->first();
            $pay->amount = $request->amount;
            $pay->save();
        }



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
        $amount=0;
        if($track>0){
            $t=2;
            $amount=$track;
        }else if($track<0){
            $t=1;
            $amount=(-1)*$track;

        }


        $user->amount=$amount;
        $user->amounttype=$t;
        $user->save();
        // LedgerManage::ad();

    }


    public function del(Request $request){
        $ledger=Ledger::find($request->id);
        $user=User::find($ledger->user_id);
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

        //check if it is advance
        if($ledger->identifire == 104){
            $adv = Advance::where('id',$ledger->foreign_key)->first();
            $adv->delete();
        }

         //check if is milk payment

         if($ledger->identifire == 121){
            $pay = MilkPayment::where('id',$ledger->foreign_key)->first();
            $pay->delete();
        }


        $user->amount=$track;
        $user->amounttype=$t;
        $user->save();
        return response('ok');
    }
}
