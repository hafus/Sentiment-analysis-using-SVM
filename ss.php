<?php
$re = 'it was bad';
$arr=[];
$error='';
echo exec('C:\Users\-\AppData\Local\Programs\Python\Python36-32\python.exe  ss.py '.$re, $arr, $error); 
echo 'finsh php<br>errors below<br>';
var_dump($arr)
?>