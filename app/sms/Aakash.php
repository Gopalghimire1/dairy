<?php
namespace App\sms;

use Illuminate\Support\Facades\Http;

class Aakash 
{
    const url="https://sms.aakashsms.com/sms/v3/send";
    private $token;
    public function __construct()
    {
        $this->token=env('aakash_token','');
    }

    public function sendMessage($phone ,$msg){
        $response=Http::post(self::url, [
            'auth_token'=> $this->token,
            'to'    => $phone,
            'text'  =>$msg
        ]);
        return $response;
    }
}
