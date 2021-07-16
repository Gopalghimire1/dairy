<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Ledger;
use App\Models\Supplierbill;
use App\Models\Supplierbillitem;
use App\Models\Supplierpayment;
use App\Models\User;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return view('admin.supplier.index');
    }

    public function supplierList(){
        $supplier = User::latest()->where('role',3)->get();
        return view('admin.supplier.list',['supplier'=>$supplier]);
    }

    public function addSupplier(Request $request)
    {
        $user = new User();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 3;
        $user->password = bcrypt($request->phone);
        $user->save();
        return view('admin.supplier.single', compact('user'));
    }

    public function updateSupplier(Request $request){
        $user = User::where('id',$request->id)->where('role',3)->first();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 3;
        $user->password = bcrypt($request->phone);
        $user->save();
        return view('admin.supplier.single', compact('user'));
    }

    public function deleteSupplier($id){
        $user = User::where('id',$id)->where('role',3)->first();
        $user->delete();
        return response()->json('Delete successfully !');
    }

    // bill controllers

    public function indexBill(){
        return view('admin.supplier.bill.index');
    }

    public function addBill(Request $request){
        // dd($request->all());
        $date = str_replace('-','',$request->date);
        $bill = new Supplierbill();
        $bill->billno = $request->billno;
        $bill->date = $date;
        $bill->total = $request->total;
        $bill->paid = $request->paid;
        $bill->due = $request->total - $request->paid;
        $bill->user_id = $request->user_id;
        $bill->transport_charge = $request->t_charge;
        $bill->save();
        $traker = explode(',',$request->counter);
        foreach ($traker as $key => $value) {
            $billItem = new Supplierbillitem();
            $billItem->title = $request->input('ptr_'.$value);
            $billItem->rate = $request->input('rate_'.$value);
            $billItem->qty = $request->input('qty_'.$value);
            $billItem->item_id = $request->input('item_id_'.$value);
            $billItem->supplierbill_id = $bill->id;
            $billItem->save();
        }
        $ledger = new LedgerManage($request->user_id);
        $ledger->addLedger('Item puchase from supplier',1,$request->total,$date,'125',$bill->id);
        if($request->paid >0){
            $ledger->addLedger('Paid to supplier',2,$request->paid,$date,'126',$bill->id);
        }
        return view('admin.supplier.bill.single',compact('bill'));
    }



    public function listBill(){
        $bills = Supplierbill::latest()->get();
        return view('admin.supplier.bill.list',compact('bills'));
    }



    public function supplierDetail($id){
        $user = User::where('id',$id)->where('role',3)->first();
        return view('admin.supplier.detail',compact('user'));
    }

    public function billItems(Request $request){
        // dd($request->all());
        $billItem = Supplierbillitem::where('supplierbill_id',$request->bill_id)->get();
        // dd($billItem);
        return view('admin.supplier.bill.item',compact('billItem'));
    }

    public function updateBill(Request $request){
        $date = str_replace('-','',$request->date);
        $bill = Supplierbill::find($request->id);
        $bill->billno = $request->billno;
        $bill->date = $date;
        $bill->total = $request->total;
        $bill->paid = $request->paid;
        $bill->due = $request->total - $request->paid;
        $bill->user_id = $request->user_id;
        $bill->save();
        return view('admin.supplier.bill.single',compact('bill'));
    }

    public function deleteBill($id){
        $bill=Supplierbill::where('id',$id)->first();
        $bill->delete();


        $data=[];
        $data[0]=Ledger::where('foreign_key',$id)->where('identifire',125)->first();
        $ddd=Ledger::where('foreign_key',$id)->where('identifire',126)->first();
        if($ddd!=null){
            $data[1]=$ddd;
        }
        LedgerManage::delLedger($data);
        return response('ok');
    }

    // supplier payment
    public function supplierPayment(){
        return view('admin.supplier.pay.index');
    }

    public function supplierDue(Request $request){
        $supplier=User::find($request->id);
        $id=$request->id;
        return view('admin.supplier.pay.data',compact('supplier','id'));
    }

    public function supplierDuePay(Request $request){
        // $bills1=Distributorsell::where('distributer_id',$request->id)->where('deu','>',0)->get();
        $supplier=User::find($request->id);
        $date = str_replace('-','',$request->date);
        $amount =$request->amount;

        $payment=new Supplierpayment();
        // $paymentDatam
        $payment->amount=$request->amount;
        $payment->date=$date;
        $payment->payment_detail=$request->method??"";
        $payment->user_id=$supplier->id;
        $payment->save();

        $ledger=new LedgerManage($supplier->id);
        $ledger->addLedger("Payment to supplier",2,$request->amount,$date,'127',$payment->id);
        $id=$request->id;
        return view('admin.supplier.pay.data',compact('supplier','id'));

    }



    // supplier previous balance

    public function previousBalance(){
        return view('admin.supplier.previous_balance.index');
    }

    public function previousBalanceAdd(Request $request){
        // dd($request->all());
        $date = str_replace('-','',$request->date);
        $user = User::where('id',$request->supplier_id)->first();
        $ledger = new LedgerManage($user->id);
        $l=$ledger->addLedger('previous Balance',$request->type,$request->amount,$date,'128');
        $l->name=$user->name;
        return view('admin.supplier.previous_balance.single',['ledger'=>$l]);
    }


    public function previousBalanceLoad(Request $request){
        $date = str_replace('-','',$request->date);
        $ledgers = User::join('ledgers','ledgers.user_id','=','users.id')
        ->where('ledgers.date',$date)
        ->where('ledgers.identifire',128)
        ->select('ledgers.id','ledgers.amount','ledgers.type','users.name')->get();
        return view('admin.supplier.previous_balance.list',compact('ledgers'));
    }

}
