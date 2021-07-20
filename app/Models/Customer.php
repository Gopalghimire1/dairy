<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function basicInfo(){
        return json_encode((object)[
            "id"=>$this->id,
            "name"=>$this->user->name,
            "address"=>$this->user->address,
            "phone"=>$this->user->phone,
        ]);
    }
}
