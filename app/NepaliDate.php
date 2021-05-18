<?php
namespace App;

class NepaliDate{
    public $year;
    public $month;
    public $day;
    public $session;
    public function __construct($date)
    {
        $this->year=(int)($date/10000);
        $date=$date%10000;
        $this->month=(int)($date/100);
        $this->day= (int)($date%100);
        if($this->day<16){
            $this->session=1;
        }else{
            $this->session=2;
        }
    }

    public static function getDate($year,$month,$session){
        $data=[];
        $date=$year*10000+$month*100;
        $data[1]=$date+($session==1?1:16);
        $data[2]=$date+($session==1?15:32);
        return $data;
    }

    public static function getDateWeek($year,$month,$week){
        $data=[];
        $date=$year*10000+$month*100;
        $data[1]=$date+(($week-1)*7 )+1;
        $data[2]=$date+($week*7);
        return $data;
    }

    public function prevSession(){
        $arr=[$this->year,$this->month,$this->session];
        $arr[2]=$this->session-1;
        if($arr[2]<1){
            $arr[1]=$this->month-1;
            $arr[2]=2;
            if($arr[1]<1){
                $arr[0]=$this->year-1;
                $arr[1]=12;
            }
        }
        return $arr;
    }

    public function isPrevClosed($user_id){
        $s=$this->prevSession();
        return \App\Models\FarmerReport::where([
            ['year',$s[0]],
            ['month',$s[1]],
            ['session',$s[2]],
            ['user_id',$user_id],
        ])->count()>0;
    }

    public static function getDateMonth($year,$month){
        $data=[];
        $date=$year*10000+$month*100;
        $data[1]=$date+1;
        $data[2]=$date+32;
        return $data;
    }

    public static function getDateYear($year){
        $data=[];
        $date=$year*10000;
        $data[1]=$date+101;
        $data[2]=$date+1232;
        return $data;
    }

    public static function nextSession($year,$month,$session){
        $data=[];

        $session+=1;
        if($session>2){
            $session=1;
            $month+=1;
        }

        if($month>12){
            $month=1;
            $year+=1;
        }
        return [
            'year'=>$year,
            'month'=>$month,
            'session'=>$session,
        ];
    }

    public static function getNextDate($year,$month,$session){
        $nsession=self::nextSession($year,$month,$session);
        return self::getDate(
            $nsession['year'],
            $nsession['month'],
            $nsession['session']
        )[1];
    }
}
