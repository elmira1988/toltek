<?php 

include "functions.php";

$user=json_decode($_POST['val'],true);
$user["note"] = "";
//print_r($user);
if((str_replace(" ","",$user['surname']) == "Ерофеев") && (str_replace(" ","",$user['name']) == "Михаил") && (str_replace(" ","",$user['patronymic']) == "Сергеевич") && ($user['birth']=='2009-01-07'))  
{
	echo json_encode(['status' => 'error', 'message' => 'Ваша заявка отклонена!']);
}
else
{
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
			echo json_encode(['status' => 'ok']);
			
		}
		else
		{
			echo json_encode(['status' => 'error', 'message' => 'Произошла ошибка при работе с базой данных!']);
		}
	}
	else
	{
		echo json_encode(['status' => 'error', 'message' => 'Произошла ошибка при работе с базой данных!']);
	}
}



?>