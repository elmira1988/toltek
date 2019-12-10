<?php
	session_name('toltek');
	session_start();
	session_destroy();

	 header("Location: http://admin.toltekplus.ru/"); 
?>