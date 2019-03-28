<?php
ini_set('max_execution_time', 15000*60);
//set_time_limit(0); 
ob_implicit_flush(true);
ob_end_flush();
$arr=[];
$error='';
$airlines = str_replace(',',' ',$_COOKIE['sel']);
echo exec('C:\Users\-\AppData\Local\Programs\Python\Python36-32\python.exe  gp_part1.py '.$airlines, $arr, $error); 
echo exec('C:\Users\-\AppData\Local\Programs\Python\Python36-32\python.exe  gp_part2.py '.$airlines, $arr, $error); 
?>