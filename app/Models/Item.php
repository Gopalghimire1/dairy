<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function  stocks(){
        return $this->hasMany(CenterStock::class);
    }
    public function stock($center_id){
        return CenterStock::where('item_id',$this->id)->where('center_id',$center_id)->first();
    }
}
