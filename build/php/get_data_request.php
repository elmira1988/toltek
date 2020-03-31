<?php 

require_once("functions.php");

$request=get_all_requests(array("id_requests" => array($_POST["id_requests"])))[0];
$request["id_courses"]=get_all_courses_of_request($_POST["id_requests"]);

echo json_encode($request);
 ?>