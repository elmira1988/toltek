<?php 

require_once("functions.php");

$data=json_decode($_POST['data'],true);

//print_r($data);

$id_teachers=$data["id_teachers"];
$note=$data["note"];

//добавляем запись в архив
$query="INSERT INTO `teachers__job_status` (`id_teachers`,  `id_job_status`, `note`) VALUES ($id_teachers, '2', '".$note."')";

echo save_data($query);

 ?>