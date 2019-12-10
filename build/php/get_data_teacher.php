<?php 

require_once("functions.php");

$teacher=get_teachers(array("id_teachers" => array($_POST["id_teachers"])))[0];

echo json_encode($teacher);
 ?> 