<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Advance;
use App\Models\Center;
use App\Models\Farmer;
use App\Models\Farmerpayment;
use App\Models\FarmerReport;
use App\Models\Ledger;
use App\Models\Milkdata;
use App\Models\Sellitem;
use App\Models\Snffat;
use App\Models\User;
use App\NepaliDate;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index(){
        return view('admin.farmer.list');
    }

    public function addFarmer(Request $request){
        if($request->isMethod('post')){
            // dd($request->advance);
            // dd($request);
                if($request->filled('no')){
                    $max=$request->no;
                }else{

                    $max=(User::join('farmers','farmers.user_id','=','users.id')->where('farmers.center_id',$request->center_id)->max('users.no')??0)+1;
                }
                // dd($max);
                // $max=User::max('no')??0;
                $user = new User();
                $user->phone = $request->phone??"9800000000";
                $user->name = $request->name;
                $user->address = $request->address;
                $user->role = 1;
                $user->password = bcrypt(12345);
                $user->no=$max;
                $user->save();

                $id=$user->id;
                $farmer=new Farmer();
                $farmer->user_id=$user->id;
                $farmer->center_id=$request->center_id;
                $farmer->usecc=$request->usecc??0;
                $farmer->usetc=$request->usetc??0;
                $farmer->userate=$request->userate??0;
                $farmer->rate=$request->rate;
                $farmer->save();


                if($request->has('advance') ){
                    if($request->advance>0){
                        $manager=new LedgerManage($user->id);
                        $manager->addLedger('Opening Balance',1,$request->advance,$request->date,'101');
                    }
                }

                $user=User::find($id);
                $user->usecc=$farmer->usecc;
                $user->usetc=$farmer->usetc;
                $user->userate=$farmer->userate;
                $user->rate=$farmer->rate;
                return view('admin.farmer.single',compact('user'));
                // return response()->json("Farmer Created successfully !");
        }else{
            return view('admin.farmer.add');
        }
    }

    public function listFarmer(){
        $farmers = User::join('farmers','farmers.user_id','=','users.id')->where('farmers.center_id',1)->where('users.role',1)->select('users.*','farmers.center_id')->orderBy('users.no','asc')->get();
        // return response()->json($farmers);
        return view('admin.farmer.list',['farmers'=>$farmers]);
    }

    public function listFarmerByCenter(Request $request){
        // dd($request->all());
        $farmers = User::join('farmers','farmers.user_id','=','users.id')->where('farmers.center_id',$request->center)->where('users.role',1)->select('users.*','farmers.center_id','farmers.usecc','farmers.usetc','farmers.userate','farmers.rate')->orderBy('users.no','asc')->get();
        // dd($farmers);
        return view('admin.farmer.list',['farmers'=>$farmers]);
    }

    public function farmerDetail($id){
        $user = User::where('id',$id)->where('role',1)->first();
        return view('admin.farmer.detail',compact('user'));
    }

    // public function loadDate(Request $r){
    //     $range=NepaliDate::getDate($r->year,$r->month,$r->session);
    //     $data=$r->all();
    //     $farmer1=User::where('id',$r->user_id)->first();

    //     $sellitem = Sellitem::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
    //     $milkData = Milkdata::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
    //     $snfFats = Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
    //     $snfAvg = truncate_decimals(Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('snf'),2);
    //     $fatAvg = truncate_decimals(Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('fat'),2);
    //     $ledger = Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->orderBy('id','asc')->get();
    //     $farmer = Farmer::where('user_id',$r->user_id)->first();
    //     $fatsnfRate = Center::where('id',$farmer->center_id)->first();
    //     $fatAmount = ($fatAvg * $fatsnfRate->fat_rate);
    //     $snfAmount = ($snfAvg * $fatsnfRate->snf_rate);
    //     $tc=0;
    //     $cc=0;
    //     $center=Center::where('id',$farmer->center_id)->first();

    //     if(env('usetc',0)==1){
    //         $tc= $center->tc *($snfAvg+$fatAvg)/100;
    //     }
    //     if(env('usecc',0)==1){
    //         $cc= $center->cc ;
    //     }
    //     $perLiterAmount =truncate_decimals( $fatAmount + $snfAmount);

    //     $farmer1->old=FarmerReport::where(['year'=>$r->year,'month'=>$r->month,'session'=>$r->session,'user_id'=>$r->user_id])->count()>0;
    //     $farmer1->advance=(float)(Advance::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('amount'));
    //     $farmer1->due=(float)(Sellitem::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('due'));
    //     $farmer1->bonus=0;

    //     $previousMonth=Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','101')->sum('amount');
    //     $previousMonth1=Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','120')->where('type',1)->sum('amount');
    //     $previousAdvance=Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','120')->where('type',2)->sum('amount');

    //     $farmer1->prevdue=(float)$previousMonth+(float)$previousMonth1;
    //     $farmer1->prevadvance=(float)$previousAdvance;
    //     return view('admin.farmer.alldata',compact('tc','cc','center','data','farmer1','sellitem','milkData','milkData','snfFats','snfAvg','fatAvg','ledger','perLiterAmount'));
    // }

    public function loadDate(Request $r){
        // dd($r->all());
        $range=NepaliDate::getDate($r->year,$r->month,$r->session);
        $data=$r->all();
        $farmer1=User::where('id',$r->user_id)->first();
        $center = Center::where('id',$farmer1->farmer()->center_id)->first();

        $farmer1->old=FarmerReport::where(['year'=>$r->year,'month'=>$r->month,'session'=>$r->session,'user_id'=>$r->user_id])->count()>0;

        $sellitem = Sellitem::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        $milkData = Milkdata::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        $snfFats = Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();

        $snfAvg = truncate_decimals(Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('snf'),2);
        $fatAvg = truncate_decimals(Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('fat'),2);


        $fatAmount = ($fatAvg * $center->fat_rate);
        $snfAmount = ($snfAvg * $center->snf_rate);

        $farmer1->snfavg=$snfAvg;
        $farmer1->fatavg=$fatAvg;
        if($farmer1->farmer()->userate==1){

            $farmer1->milkrate=$farmer1->farmer()->rate;
        }else{

            $farmer1->milkrate=truncate_decimals( $fatAmount + $snfAmount);
        }

        $farmer1->milkamount=Milkdata::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('e_amount')+Milkdata::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('m_amount');

        $farmer1->total = truncate_decimals(($farmer1->milkrate * $farmer1->milkamount),2);

        $farmer1->tc=0;
        $farmer1->cc=0;


        if($farmer1->farmer()->usetc==1 && $farmer1->total>0 ){
            $farmer1->tc= truncate_decimals(( ($center->tc *($snfAvg+$fatAvg)/100)* $farmer1->milkamount),2);
        }
        if($farmer1->farmer()->usecc==1 && $farmer1->total>0 ){
            $farmer1->cc=truncate_decimals( $center->cc * $farmer1->milkamount,2);
        }


        $farmer1->fpaid=(Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','106')->sum('amount')+Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','107')->sum('amount'));

        $farmer1->grandtotal=(int)( $farmer1->total+$farmer1->tc+$farmer1->cc);

        $farmer1->bonus=0;
        if (env('hasextra',0)==1){
            $farmer1->bonus=(int)($farmer1->grandtotal * $center->bonus/100);
        }


        // $farmer1->due=(float)(Sellitem::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('due'));
        $farmer1->due=Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','103')->sum('amount');;

        $previousMonth=Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','101')->sum('amount');
        $previousMonth1=Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','120')->where('type',1)->sum('amount');
        $previousBalance=Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','120')->where('type',2)->sum('amount');

        $farmer1->advance=(float)(Advance::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('amount'));
        $farmer1->prevdue=(float)$previousMonth+(float)$previousMonth1;
        $farmer1->prevbalance=(float)$previousBalance;
        $farmer1->paidamount=(float)Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','121')->where('type',1)->sum('amount');
        $balance=$farmer1->grandtotal+$farmer1->balance - $farmer1->prevdue -$farmer1->advance-$farmer1->due-$farmer1->paidamount+$farmer1->prevbalance-$farmer1->bonus+$farmer1->fpaid;

        $farmer1->balance=0;
        $farmer1->nettotal=0;
        if($balance<0){
            $farmer1->balance=(-1)* $balance ;
        }
        if($balance>0){
            $farmer1->nettotal= $balance;
        }

        $farmer1->ledger = Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->orderBy('id','asc')->get();
        $milk_rate = FarmerReport::where(['user_id'=>$r->user_id,'year'=>$r->year,'month'=>$r->month,'session'=>$r->session])->first();
        // dd($milk_rate);
        // dd(compact('snfFats','milkData','data','center','farmer1'));
        return view('admin.farmer.detail.index',compact('snfFats','milkData','data','center','farmer1','milk_rate'));
    }




    public function updateFarmer(Request $request){
        // dd($request->all());
        $user = User::where('id',$request->id)->where('role',1)->first();
        // dd($user);
        if($request->filled('phone')){

            $user->phone = $request->phone;
        }
        $user->no = $request->no;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->save();

        $farmer=Farmer::where('user_id',$request->id)->first();
        $farmer->usecc=$request->usecc??0;
        $farmer->usetc=$request->usetc??0;
        $farmer->userate=$request->userate??0;
        $farmer->rate=$request->rate;
        $farmer->save();

        $user->usecc=$farmer->usecc;
        $user->usetc=$farmer->usetc;
        $user->userate=$farmer->userate;
        $user->rate=$farmer->rate;

        return view('admin.farmer.single',compact('user'));
    }

    public function deleteFarmer($id){
        $user = User::where('id',$id)->where('role',1)->first();
        $user->delete();
        return response()->json('Delete successfully !');
    }


    // due payment controller
    public function due(){
        return view('admin.farmer.due.index');
    }

    public function dueLoad(Request $request){
            $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->no)->where('farmers.center_id',$request->center_id)->select('users.*','farmers.center_id')->first();
            // $user = User::where('no',$request->no)->first();
            $due = Sellitem::where('user_id',$user->id)->where('due','>',0)->get();
        // dd($due);
        return view('admin.farmer.due.due',compact('due'));
    }

    public function paymentSave(Request $request){
        $date = str_replace('-','',$request->date);
        $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->no)->where('farmers.center_id',$request->center_id)->select('users.*','farmers.center_id')->first();
        $farmerPay = new Farmerpayment();
        $farmerPay->amount = $request->pay;
        $farmerPay->date = $date;
        $farmerPay->payment_detail = $request->detail;
        $farmerPay->user_id = $user->id;
        $farmerPay->save();
        // $due = Sellitem::where('user_id',$user->id)->where('due','>',0)->get();
        // $paidmaount = $farmerPay->amount;

        // foreach ($due as $key => $value) {
        //     if($paidmaount<=0){
        //         break;
        //     }
        //     if($paidmaount>=$value->due){
        //         $paidmaount -= $value->due;
        //         $value->due =0;
        //         $value->save();
        //     }else{
        //         $value->due-=$paidmaount;
        //         $paidmaount=0;
        //         $value->save();
        //     }
        // }
        $ledger = new LedgerManage($user->id);
        $ledger->addLedger('Paid by farmer amount',2,$request->pay,$date,'107',$farmerPay->id);
    }

    public function addDueList(Request $request){
        if($request->getMethod()=="POST"){
            $date = str_replace('-','',$request->date);

            $ledgers = User::join('farmers','users.id','=','farmers.user_id')
            ->join('ledgers','ledgers.user_id','=','users.id')
            ->where('farmers.center_id',$request->center)
            ->where('ledgers.date',$date)
            ->where('ledgers.identifire',120)
            ->select('ledgers.id','ledgers.amount','ledgers.type','users.no','users.name','farmers.center_id')->get();
            // dd($ledgers,$request->all());
            return view('admin.farmer.due.list.list',compact('ledgers'));

        }else{
            return view('admin.farmer.due.list.index');
        }
    }


    public function addDue(Request $request){
        $date = str_replace('-','',$request->date);
        $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->id)->where('farmers.center_id',$request->center_id)->select('users.*','farmers.center_id')->first();
        $ledger = new LedgerManage($user->id);
        $l=$ledger->addLedger('previous Balance',$request->type,$request->amount,$date,'120');
        $l->name=$user->name;
        $l->no=$user->no;
        return view('admin.farmer.due.list.single',['ledger'=>$l]);
    }





}
