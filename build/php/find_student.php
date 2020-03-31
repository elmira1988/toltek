<?php 

require_once("functions.php");

$students=find_student($_POST["world"]);

echo json_encode($students);

 ?>