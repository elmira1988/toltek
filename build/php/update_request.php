<?php 

require_once("functions.php");

//print_r($_POST);

$data=json_decode($_POST["data"],true);

//print_r($data);
echo update_request($data);

 ?>