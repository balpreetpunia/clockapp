<?php
date_default_timezone_set("America/Toronto");
$time = date("H:i:s");

echo $time;


if( date('H:i:s',strtotime($time))> date('H:i:s',strtotime('15:14:30')) && date('H:i:s',strtotime($time)) < date('H:i:s',strtotime('15:14:35'))){
    echo 'yo';
}