<?php

function _nepalidate($date){
    $year=(int)($date/10000);
    $date=$date%10000;
    $month=(int)($date/100);
    $day= (int)($date%100);
    return $year."-".($month<10?"0".$month:$month)."-".($day<10?"0".$day:$day);
}