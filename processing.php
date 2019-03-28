<?php
	ini_set('max_execution_time', 15000*60);
	echo implode(' ', $_POST);
	echo "</br>";
	$arr = [];
	$error = '';
	exec('cd C:\xampp\htdocs\gp3 | C:\Users\-\AppData\Local\Programs\Python\Python36-32\python.exe  gp.py '.implode(' ',$_POST), $arr, $error);
	if($error)
	{
		echo "</br>error: $error</br>";
		echo "</br>print statment</br>";
		var_dump($arr);
	}
	else{
		setcookie('USER',implode(' ', $_POST),time()+60*60*24);
		header('Location: dashboard.php');
	}

?>