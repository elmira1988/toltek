<?php 
session_name('toltek');
session_start();
require_once("functions.php");
$url="https://strbsu.ru/payment/api";
$post=json_decode($_POST["data"],true);


$post["CBC"]="00000000000000000130";
$post["Category"]=2;

$post["SUM"]=$post["amount"];
unset($post["amount"]); 

$parent=get_parents(array("id_parents" => array($post["id_parents"])))[0]; 
unset($post["id_parents"]);
$post["LastName"]=$parent["surname"].' '.$parent["name"].' '.$parent["patronymic"];

$students_groups=get_students_groups($post["id_students_groups"]);
unset($post["id_students_groups"]);
$student=get_students(array("id_students" => array($students_groups[0]["id_students"])))[0];
$post["ChildFio"]=$student["surname"].' '.$student["name"].' '.$student["patronymic"];

$post["Form"]="";
$post["Fac"]="";
$post["Sp"]="";
$post["Kurs"]="";

$group=get_groups(array("id_groups" => array($students_groups[0]["id_groups"])))[0];
$post["KursName"]='Толтек СФБашГУ. '.$group["name_of_course"].'. Группа '.$group["name_of_group"];

$settings=get_settings();
$post["DocNo"]=$settings["DocNo"];
$post["PayerAddress"]="";
$post["token"]=$settings["api_sberbank"]; 

//отпарвляем на strbsu.ru запрос на добавление заказа в базу strbsu.ru 
//и получаем ответ от сервера банка со ссылкой на платежную форму
$res=file_get_contents_curl($url,$post); 

$data=json_decode($res,true);

if ($data["result"]=="ok")
{	
	//сохраняем orderId в базе Толтека, чтобы в дальнейшем указать успешность оплаты
	$orderId=$data["orderId"];
	$id_payment=save_payment(json_decode($_POST["data"],true));
	$id_payment_online=save_data("INSERT INTO `payment_online` (`id_payment`, `orderId`) VALUES ('$id_payment', '$orderId')");
} 
 
print_r($res); 

?>