<?php 
 require_once("functions.php");

$payment=get_raw("SELECT * FROM `payment`");

foreach ($payment as $key => $val) {
	$id_payment=$val["id_payment"];
	$months=$val["months"];
	$amount=$val["amount"];
	$date_of_receiving=$val["date_of_receiving"];

	$query="INSERT INTO `payment_detail` (`id_payment_detail`, `id_payment`, `month`, `amount`, `date_of_receiving`) VALUES (NULL, '$id_payment', '$months', '$amount', '$date_of_receiving')";

	//echo $query.'<br>';
	//save_data($query);    
}

 ?>