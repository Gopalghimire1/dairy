<?php

namespace App\Jobs;

use App\Models\Item;
use App\sms\Aakash;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $list;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($_list)
    {
        $this->list=$_list;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $aakash=new Aakash();
        $data=[];
        foreach ($this->list as $item) {
            $msg=view('sms.distributer_credit',['dis'=>$item])->render();
            $aakash->sendMessage($item->phone,$msg); 
        }
    }
}
