<?php 
require_once("functions.php");

$payments=get_payments(array("payment"=>array("allPay")));
//print_r($payments);

for ($i=0;$i<count($payments);$i++)
{
	$id_students_groups=$payments[$i]["id_students_groups"];
	$amount=get_groups(array("id_groups"=>array($payments[$i]["id_groups"])))[0]["amount"];
	$id_parents=get_parents($payments[$i]["id_students"])[0]["id_parents"];
	$query="INSERT INTO `payment` (`id_payment`, `id_students_groups`, `amount`, `id_parents`, `months`, `year`, `paint`, `note`, `date_of_entry`, `id_users`, `date_of_receiving`) VALUES (NULL, '".$id_students_groups."', '".$amount."', '".$id_parents."', '9', '2019', '', '', CURRENT_TIMESTAMP, '2', '');";
    //echo $id_payment=save_data($query)."<br>";
}

 

/*
//сохранеяем данные 
if ($id_payment=save_data($query)) 
{
	echo true;
}
else
{
	echo false;
}

SELECT SUM(amount) AS value_sum FROM payment
*/

 ?>