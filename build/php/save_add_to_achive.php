<?php 

require_once("functions.php");

$data=json_decode($_POST['data'],true);


$id_students_groups=$data["id_students_groups"];
$note=$data["note"];

//добавляем запись в архив
$query="INSERT INTO `history_of_study` (`id_history_of_study`, `id_students_groups`,  `id_study_status`, `note`) VALUES (NULL, $id_students_groups, '1', '".$note."')";

if ($result=save_data($query))
{
	//меняем months_of_study
	update_months_of_study($id_students_groups,$data["months_of_study"]);
}

echo $result;
 ?>