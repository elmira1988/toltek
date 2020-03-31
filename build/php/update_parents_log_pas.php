<?php 
require_once("functions.php");
global $mysqli;

//print_r($_POST);
$query="UPDATE `parents_log_pas` SET `log`='".$_POST["login"]."', `pas`='".password_hash($_POST["password"], PASSWORD_DEFAULT)."' WHERE `id_parents_key`=".$_POST["id_parents_key"];

echo json_encode($mysqli->query($query));  

?>