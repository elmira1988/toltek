<?php 

require_once("functions.php");


$student=get_students(array("id_students" => array($_POST["id_students"])))[0];


if (!isset($_POST["id_parents"]))
{
	$student["parents"]=get_parents($_POST["id_students"],$_POST["id_parents"]);
}
else
{
	$student["parents"]=get_parents($_POST["id_students"]);
}



echo json_encode($student);
 ?> 