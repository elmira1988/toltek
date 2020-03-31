<?php
	session_name('toltek');
	session_start();
	$url='';
	if (in_array($_SESSION["id_roles"], array(1,6)) )
	{
		$url="admin";
	}
	
	session_destroy();

	header("Location: /".$url); 
?>