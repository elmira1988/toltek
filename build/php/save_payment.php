<?php 
session_name('toltek');
session_start();
//print_r($_SESSION);
require_once("functions.php");

$data=json_decode($_POST['data'],true);

echo save_payment($data);//возвращаем id_payment

 ?>