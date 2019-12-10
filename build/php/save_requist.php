<?php 

include "functions.php";

$user=json_decode($_POST['val'],true);

$array_key=array();
$array_val=array();

foreach ($user as $key => $value) {
	if ($key!='id_courses')
	{
		array_push($array_key,"`".$key."`");
		array_push($array_val,"'".$value."'");	
	}
	
}


$query="INSERT INTO `requests` (".implode(",",$array_key).") VALUES (".implode(",",$array_val).")";


if ($id_request=save_data($query))
{  
	
	if (($save_key=save_key($id_request)) && ($id_request_of_courses=save_courses_of_request($id_request,$user["id_courses"])))
	{
		echo $id_request;
		
	}
	else
	{
		echo false;
	}
}
else
{
	echo false;
}

?>