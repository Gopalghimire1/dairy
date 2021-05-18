<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Farmer;
use App\Models\Item;
use App\Models\Ledger;
use App\Models\Sellitem;
use App\Models\User;
use App\NepaliDate;
use Illuminate\Http\Request;

class SellitemController extends Controller
{
    public function index(){
        return view('admin.sellitem.index');
    }

    public function addSellItem(Request $request){
        $date = str_replace('-','',$request->date);
        $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->user_id)->where('farmers.center_id',$request->center_id)->select('users.*','farmers.center_id')->first();
        // dd($user->id);
        $d=new NepaliDate($date);
        if(!$d->isPrevClosed($user->id)){
            return response('Previous session is not closed yet',500);
        }
        $item_id = Item::where('number',$request->number)->first();
        if($item_id->stock>0){
            $item_id->stock = $item_id->stock - $request->qty;
            $sell_item = new Sellitem();
            $sell_item->total = $request->total;
            $sell_item->qty = $request->qty;
            $sell_item->rate = $request->rate;
            $sell_item->due = $request->due;
            $sell_item->paid = $request->paid;
            // $user = User::where('no',$request->user_id)->first();
            $sell_item->user_id = $user->id;
            $sell_item->item_id = $item_id->id;
            $sell_item->date = $date;
            $item_id->save();
            $sell_item->save();
            $manager=new LedgerManage($user->id);
            $manager->addLedger($item_id->title.' ( Rs.'.$sell_item->rate.' x '.$sell_item->qty. ')',1,$request->total,$date,'103',$sell_item->id);
            if($request->paid>0){
                $manager->addLedger('Paid amount',2,$request->paid,$date,'106',$sell_item->id);
            }
            return view('admin.sellitem.single',compact('sell_item'));
        }else{
            return response('item Stock is not available',500);
        }
        // LedgerManage::addLedger('Sell Item', 1,$request->total,$date,'101');
    }


    // public function updateSellItem(Request $request){
    //     $date = str_replace('-','',$request->date);
    //     $item_id = Item::where('number',$request->number)->first();
    //     if($item_id->stock>0){
    //         $sell_item = Sellitem::where('id',$request->id)->first();

    //         $preitem = Item::where('id',$sell_item->item_id)->first();
    //         if($request->number == $preitem->number){
    //             if($request->qty > $sell_item->qty){
    //                 $qty = $request->qty - $sell_item->qty;
    //                 $item_id->stock = $item_id->stock - $qty;
    //                 $item_id->save();
    //             }else{
    //                 $qty = $sell_item->qty - $request->qty;
    //                 $item_id->stock = $item_id->stock + $qty;
    //                 $item_id->save();
    //             }
    //         }else{
    //             $preitem->stock = $preitem->stock + $sell_item->qty;
    //             $preitem->save();
    //             $item_id->stock = $item_id->stock - $request->qty;
    //             $item_id->save();
    //         }

    //         $sell_item->total = $request->total;
    //         $sell_item->qty = $request->qty;
    //         $sell_item->rate = $request->rate;
    //         $sell_item->due = $request->due;
    //         $sell_item->paid = $request->paid;

    //         $user = User::where('no',$request->user_id)->first();
    //         $sell_item->user_id = $user->id;

    //         $item_id = Item::where('number',$request->number)->first();
    //         $sell_item->item_id = $item_id->id;
    //         $sell_item->date = $date;
    //         $sell_item->save();
    //         return view('admin.sellitem.single',compact('sell_item'));
    //     }else{
    //         return response()->json('Item Stok is not available');
    //     }
    // }


    public function sellItemList(Request $request){
        $date = str_replace('-','',$request->date);
        $farmer = Farmer::where('center_id',$request->center_id)->select('user_id')->get();
        // $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->no)->where('farmers.center_id',$request->center_id)->select('users.*','farmers.center_id')->first();
        $sell = Sellitem::where('date',$date)->whereIn('user_id',$farmer)->get();
        return view('admin.sellitem.list',compact('sell'));
    }

    public function deleteSellitem(Request $request){
        $date = str_replace('-','',$request->date);

        $sell = Sellitem::find($request->id);
        $item = Item::where('id',$sell->item_id)->first();

        $paid=$sell->paid;
        $total=$sell->total;
        $user_id=$sell->user_id;

        $title=$item->title.' ( Rs.'.$sell->rate.' x '.$sell->qty. ')';

        $item->stock = $item->stock + $sell->qty;

        $item->save();
        $sell->delete();
        $manager=new LedgerManage($user_id);
        $ledger=[];
        $ledger[0] = Ledger::where('identifire','103')->where('foreign_key',$request->id)->first();
        if($paid>0){
            $ledger[1]=Ledger::where('identifire','106')->where('foreign_key',$request->id)->first();
        }
        // $ledger[0] = Ledger::where('identifire','106')->where('foreign_key',$request->id);
        LedgerManage::delLedger($ledger);
                // $manager->addLedger('Cancel sell: '.$title,2,$total,$date,'116',$request->id);
        // if($paid>0){
        //     $manager->addLedger('Cancel paid: '.$title,1,$paid,$date,'117',$request->id);
        // }

        return response('Sell Deleted Sucessfully');

    }

    public function multidel(Request $request){
        // dd($request->ids);
        foreach($request->ids as $id){


            $sell = Sellitem::find($id);
            $item = Item::where('id',$sell->item_id)->first();

            $paid=$sell->paid;
            $total=$sell->total;
            $user_id=$sell->user_id;

            $title=$item->title.' ( Rs.'.$sell->rate.' x '.$sell->qty. ')';

            $item->stock = $item->stock + $sell->qty;
            $item->save();
            $sell->delete();
            $manager=new LedgerManage($user_id);
            $ledger=[];
            echo "id:".$id.", paid:".$paid."<br>";
            $ledger1=Ledger::where('user_id',$user_id)->where('identifire','103')->where('foreign_key',$id)->first();
            if($ledger1!=null){
                array_push($ledger,$ledger1);
            }

            echo "step1 <br>";

            if($paid>0){
                $ledger2=Ledger::where('user_id',$user_id)->where('identifire','106')->where('foreign_key',$id)->first();
                if($ledger2!=null){
                    array_push($ledger,$ledger1);
                }
                echo "step2 <br>";

            }
            // $ledger[0] = Ledger::where('identifire','106')->where('foreign_key',$request->id);
            LedgerManage::delLedger($ledger);
        }
    }
}
