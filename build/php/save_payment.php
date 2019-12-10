<?php 
session_name('toltek');
session_start();
//print_r($_SESSION);
require_once("functions.php");

$data=json_decode($_POST['data'],true);

$month_begin=$data["month_begin"];
$month_end=$data["month_end"];
unset($data["month_begin"]);
unset($data["month_end"]);

//Сохраняем роспись
$paint=$data["paint"];
list($type, $paint) = explode(';', $paint);
list(, $paint)      = explode(',', $paint);
$paint = base64_decode($paint);
$fileName=time();

$handle = fopen($_SERVER['DOCUMENT_ROOT']."/paint/".$fileName.".png", "w");
fwrite($handle,$paint);
fclose($handle);
unset($data["paint"]);

$arr=get_array_key_value($data);	

array_push($arr[0],"`months`");
array_push($arr[1],"'".implode(",",get_months_between($month_begin,$month_end))."'");

array_push($arr[0],"`paint`");
array_push($arr[1],"'".$fileName.".png'");

array_push($arr[0],"`year`");
array_push($arr[1],"'".$GLOBALS["year"]."'");

array_push($arr[0],"`id_users`");
array_push($arr[1],"'".$_SESSION["id_users"]."'");
 
$query="INSERT INTO `payment` (".implode(",",$arr[0]).") VALUES (".implode(",",$arr[1]).")";

//сохранеяем данные 
if ($id_payment=save_data($query)) 
{
	echo true;
}
else
{
	echo false;
}

 ?>