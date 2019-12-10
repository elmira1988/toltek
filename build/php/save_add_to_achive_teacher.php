<?php 

require_once("functions.php");

$data=json_decode($_POST['data'],true);


$id_teachers=$data["id_teachers"];
$note=$data["note"];

//добавляем запись в архив
$query="INSERT INTO `teachers__job_status` (`id_teachers`,  `id_job_status`, `note`) VALUES ($id_teachers, '1', '".$note."')";

//echo $query;
echo save_data($query); 

 ?>