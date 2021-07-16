<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\CenterStock;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function index(){
        $items = Item::latest()->get();
        return view('admin.item.index',compact('items'));
    }


    public function saveItems(Request $request){
        $item = new Item();
        $item->title = $request->name;
        $item->number = $request->number;
        $item->cost_price = $request->cost_price;
        $item->sell_price = $request->sell_price;
        $item->stock = $request->stock;
        $item->unit = $request->unit;
        $item->reward_percentage = $request->reward;
        $item->save();
        if($request->filled('rettype')){
            return response()->json($item);
        }else{

            return view('admin.item.single',compact('item'));
        }
    }

    public function updateItem(Request $request){
        $item = Item::where('id',$request->id)->first();
        $item->title = $request->name;
        $item->number = $request->number;
        $item->cost_price = $request->cost_price;
        $item->sell_price = $request->sell_price;
        $item->stock = $request->stock;
        $item->unit = $request->unit;
        $item->reward_percentage = $request->reward;
        $item->save();
        return view('admin.item.single',compact('item'));
    }


    public function centerStock($id,Request $request){
        if(env('multi_stock',false)){

            $totalStock=0;
            $item = Item::find($id);
            if($request->getMethod()=="POST"){
                foreach ($request->center_ids as $center_id) {
                    $amount=$request->input('amount_'.$center_id);
                    $rate=$request->input('rate_'.$center_id);
                    $stock=CenterStock::where('item_id',$id)->where('center_id',$center_id)->first();
                    if($stock==null){
                        $stock=new CenterStock();
                        $stock->item_id=$id;
                        $stock->center_id=$center_id;
                    }
                    $stock->amount=$amount;
                    $stock->rate=$rate;
                    $stock->save();
                    $totalStock+=$amount;
                }
                $item->stock=$totalStock;
                $item->save();
                return redirect()->back()->with('msg','Stock Updated Sucessfully');
            }else{
                $centers=Center::select('id','name')->get();
                return view('admin.item.stock',compact('item','centers'));
            }
        }else{
            return redirect()->route('admin.dashboard');
        }

    }

    public function deleteItem($id){
        $item = Item::find($id);
        $item->delete();
    }
}
