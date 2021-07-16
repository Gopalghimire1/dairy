<?php
function _nepalidate($date){
    $year=(int)($date/10000);
    $date=$date%10000;
    $month=(int)($date/100);
    $day= (int)($date%100);
    return $year."-".($month<10?"0".$month:$month)."-".($day<10?"0".$day:$day);
}

function truncate_decimals($number, $decimals=2)
{
  $factor = pow(10,$decimals);
  $val = intval($number*$factor)/$factor;
  return $val;
}

function rupee($amount) {
    $fmt = new NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL);
    return $fmt->format($amount);
}
