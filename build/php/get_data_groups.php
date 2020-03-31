<?php 

require_once("functions.php");

$groups=get_groups(array("id_groups" => array($_POST["id_groups"])))[0];

echo json_encode($groups);
 ?>