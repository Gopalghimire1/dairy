<?php

namespace App\Http\Controllers;

use App\Jobs\SendSms;
use App\Models\Distributer;
use App\sms\Aakash;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function distributerCredit(Request $request){
        $data=[];
        foreach ($request->ids as $id) {

            $dis=Distributer::where('user_id',$id)->first();
            $dis->lastsms=Carbon::now();
            $dis->save();
            $d=[];
            $d['amount']=$request->input('amount_'.$id);
            $d['phone']=$request->input('phone_'.$id);
            $d['name']=$request->input('name_'.$id);
            array_push($data,(object)$d);
        }
        // dd($data);
        // dispatch(new SendSms($data));
        // $smsSender->dispatch();
        $aakash=new Aakash();
        foreach ($data as $item) {
            $msg=view('sms.distributer_credit',['dis'=>$item])->render();
            $aakash->sendMessage($item->phone,$msg); 
        }
        return redirect()->back()->with('msg','SMS Sent Sucessfully');    
    }
}
