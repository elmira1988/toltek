<?php 

include "functions.php";
//print_r($_POST);

if ($_POST["type"]=="group")
{
	$data=json_decode($_POST["data"],true);
	
	$key=array();
	$val=array();
	
	foreach ($data as $name => $value) {
		array_push($key,"`".$name."`");
		array_push($val,"'".$value."'");  
	}

	$query="INSERT INTO `groups` (".implode(",",$key).") VALUES (".implode(",",$val).");";
	
	echo save_data($query) ; 
}
?>