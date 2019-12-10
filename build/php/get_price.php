<?php 

require_once("functions.php");

$data=json_decode($_POST["data"],true);

$students_groups=get_students_groups($data["id_students_groups"])[0];
$group=get_groups(array("id_groups"=>array($students_groups["id_groups"])))[0];

$months=get_months_between($data['month_begin'],$data['month_end']);

echo ($group["amount"]*count($months));
 ?> 