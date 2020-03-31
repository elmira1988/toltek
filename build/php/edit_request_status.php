<?php 

	require_once("functions.php");
	
	$id_request_status=edit_request_status($_POST["id_requests"]);

	if ($id_request_status) {
		echo get_color($id_request_status);
	}
	else
	{
		echo false;
	}
 ?>