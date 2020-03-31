<?php 

require_once("functions.php");

$data=json_decode($_POST['data'],true);

//print_r($data);

$id_students_groups=$data["id_students_groups"];
$month_begin=$data["month_begin"];
$months_of_study=$data["months_of_study"];
$note=$data["note"];

//добавляем запись в архив
$query="INSERT INTO `history_of_study` (`id_history_of_study`, `id_students_groups`,  `id_study_status`, `note`) VALUES (NULL, $id_students_groups, '2', '".$note."')";

if ($result=save_data($query))
{
	//меняем months_of_study
	$new_month=$data["months_of_study"];
	if ($new_month!="") $new_month.=",";
	$new_month.=implode(",",get_months_between($month_begin,5));
	update_months_of_study($id_students_groups,$new_month);  
}

echo $result;
 ?>