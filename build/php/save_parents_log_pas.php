<?php 
require_once("functions.php");

$id_parents_key=get_data_parents_key(array("key" => array($_POST["key"])))[0]["id_parents_key"];
echo save_data("INSERT INTO `parents_log_pas` (`id_parents_log_pas`, `id_parents_key`, `log`, `pas`) VALUES (NULL, '".$id_parents_key."', '".$_POST["login"]."', '".password_hash($_POST["password"], PASSWORD_DEFAULT)."');")

?>