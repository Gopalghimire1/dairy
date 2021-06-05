<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Advance;
use App\Models\Ledger;
use App\Models\User;
use App\NepaliDate;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{
    public function index(){
       return view('admin.farmer.advance.index');
    }

    public function addFormerAdvance(Request $request){
        $date = str_replace('-','',$request->date);
        $adv = new Advance();
        $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->no)->where('farmers.center_id',$request->center_id)->select('users.*','farmers.center_id')->first();
        // $user = User::where('no',$request->no)->first();
        $d=new NepaliDate($date);
        if(!$d->isPrevClosed($user->id)){
            return response('notOk');
        }
        if($user==null ){
            return response("Farmer Not Found",400);
        }else{
            if($user->no==null){
            return response("Farmer Not Found",500);
            }
        }
        $adv->user_id = $user->id;
        $adv->amount = $request->amount;
        $adv->date = $date;
        $adv->save();
        $ledger = new LedgerManage($user->id);
        $ledger->addLedger('Advance to Farmer',1,$request->amount,$date,'104',$adv->id);
        return view('admin.farmer.advance.single',compact('adv'));
    }

    public function listFarmerAdvance(Request $r){
        $date = str_replace('-','',$r->date);
        $user = User::join('farmers','users.id','=','farmers.user_id')->where('farmers.center_id',$r->center_id)->select('farmers.user_id')->get();
        // dd($user);
        $advs = Advance::where('date',$date)->whereIn('user_id',$user)->get();
        return view('admin.farmer.advance.list',compact('advs'));
    }


    public function updateFormerAdvance(Request $request){
        $adv = Advance::find($request->id);
    }


    function advanceListByDate(Request $r){
        $date = str_replace('-','',$r->date);
        $user = User::join('farmers','users.id','=','farmers.user_id')->where('farmers.center_id',$r->center_id)->select('farmers.user_id')->get();
        // dd($user);
        $advs = Advance::where('date',$date)->whereIn('user_id',$user)->get();
        return view('admin.farmer.advance.list',compact('advs'));
        // return response()->json($adv);
        // dd($date);
    }


   public function deleteFarmerAdvance($id){
        $adv = Advance::find($id);
        $ledger = Ledger::where(['user_id' => $adv->user_id, 'identifire' => '104', 'foreign_key' => $adv->id])->first();
        LedgerManage::delLedger([$ledger]);
        $adv->delete();
    }
}
