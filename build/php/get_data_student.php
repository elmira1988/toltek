<?php 

require_once("functions.php");


$student=get_students(array("id_students" => array($_POST["id_students"])))[0];


if (isset($_POST["id_parents"]))
{
	$student["parents"]=get_parents(array("id_students" => array($_POST["id_students"]), "id_parents" => array($_POST["id_parents"])));
}
else
{
	$student["parents"]=get_parents(array("id_students" => array($_POST["id_students"])));
}



echo json_encode($student);
 ?> 