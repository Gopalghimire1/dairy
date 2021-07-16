<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplierbill extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);

    }

    public function billitems(){
        return $this->hasMany(Supplierbillitem::class);
    }

    public function expense(){
        return $this->hasMany(BillExpenses::class);
    }
}
