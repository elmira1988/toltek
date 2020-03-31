<?php 

require_once("functions.php");

$data=json_decode($_POST['data'],true);

echo receiving_money($data); 

 ?>