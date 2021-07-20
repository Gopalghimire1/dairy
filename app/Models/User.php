<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getRole(){
        if($this->role == 0){
            return 'admin';
        }elseif($this->role == 1){
            return "farmer";
        }elseif($this->role == 2){
            return "distributer";
        }elseif($this->role == 3){
            return "supplier";
        }else{
            return "employee";
        }
    }

    public function employee(){
        return Employee::where('user_id',$this->id)->first();
    }

    public function distributer(){
        return Distributer::where('user_id',$this->id)->first();
    }

    public function advance(){
        return Advance::where('user_id',$this->id)->first();
    }

    public function farmer(){
        return Farmer::where('user_id',$this->id)->first();
    }


    public function ledgers(){
        return $this->hasMany(Ledger::class);
    }

    public function customerPayments(){
        return $this->hasMany(CustomerPayment::class);
    }
}
