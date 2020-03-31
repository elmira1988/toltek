<?php 

require_once("functions.php");

$add_data=json_decode($_POST["add_data"],true);

$parents=find_parent($add_data["id_students_groups"]);   

echo json_encode($parents);


 ?>