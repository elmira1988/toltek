<?php 

require_once("functions.php");

$requests=find_request($_POST["world"]);

echo json_encode($requests);

 ?>