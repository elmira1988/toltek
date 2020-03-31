<?php 

require_once("functions.php");

$data=json_decode($_POST['data'],true);


$id_students=$data["id_students"];
$id_groups=$data["id_groups"];

//закрепляем студента за группами
for ($i=0;$i<count($id_groups);$i++) 
{
	$result=save_data("INSERT INTO `students_groups` (`id_students`,`id_groups`,`year`,`months_of_study`) VALUE ($id_students,$id_groups[$i],".$GLOBALS['year'].",'".implode(",",get_months_between($data['month_begin'],$data['month_end']))."')"); 
}

echo $result;
 ?>