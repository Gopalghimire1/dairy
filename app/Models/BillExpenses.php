<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillExpenses extends Model
{
    use HasFactory;
    protected $fillable=['title','supplierbill_id','amount'];
}
