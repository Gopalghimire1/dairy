<?php

namespace App\Models;

use App\NepaliDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sessionClosed($y,$m){
        $m=$m-1;
        if($m<1){
            $m=12;
            $y=$y-1;
        }
        $range=NepaliDate::getDateMonth($y,$m);
        if(Ledger::where('date','<=',$range[2])->where('user_id',$this->user_id)->count()<=0){
            return true;
        }else{
            return EmployeeSession::where('year',$y)->where('month',$m)->where('user_id',$this->user_id)->count()>0;
        }
    }
}
