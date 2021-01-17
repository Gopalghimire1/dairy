<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    public function getForeign(){
        if($this->identifier=="102"){
            return Advance::find($this->foreign_key);
        }elseif($this->identifier='103'){
            return Sellitem::find($this->foreign_key);
        }elseif($this->identifier='105'){
            return Distributorsell::find($this->foreign_key);
        }
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
