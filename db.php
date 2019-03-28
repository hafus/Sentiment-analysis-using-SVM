<?php
$host="localhost";
$user="pma";
$pass="";
$db="gp";

$con=mysqli_connect($host,$user,$pass,$db);
if(mysqli_connect_errno($con))
{
	echo mysqli_connect_error();
	exit();
}
?>