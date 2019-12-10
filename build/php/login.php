<?php 
	 include "functions.php";

	$response=authorization_check($_POST['login'],$_POST['password']);
	 
	 
	 if ($response['error']==0)
	 {
		 session_name('toltek');
		 session_start();
		
		 $_SESSION['id_users']	= $response['id_users'];
		 $_SESSION['name'] 		= $response['name'];
		 $_SESSION['id_roles'] = $response['id_roles'];

		 $_SESSION['start_page']=$GLOBALS["arr"][$response['id_roles']]["start_page"];
		 $response['start_page']=$_SESSION['start_page'];
			
		 session_write_close(); 
	 }

	 echo json_encode($response);
	
 ?>