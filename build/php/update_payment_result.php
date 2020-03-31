<?php 

require_once("functions.php");

global $mysqli;

$query="UPDATE `payment_online` SET `result` = '1' WHERE `payment_online`.`orderId` = '".$_GET['orderId']."'";

print_r($mysqli->query($query)); 


?>