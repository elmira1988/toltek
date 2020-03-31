<?php

	require_once("functions.php");

	$data=json_decode($_POST["data"],true);
	$arr_id_students=$data["arr_id_students"];
	if (isset($data["arr_id_parents"])) {$arr_id_parents=$data["arr_id_parents"];}
	
	//print_r($data);
	

	$arr=array();
	foreach ($arr_id_students as $key => $id_students) {

		$parents=get_parents(array("id_students" => array($id_students)));

		foreach ($parents as $key => $parent) 
		{
			if ((!isset($arr_id_parents)) || (!(array_search($parent["id_parents"],$arr_id_parents)===FALSE)))
			{
					//данные представителей
				$key=md5(time().$parent["id_parents"]);
				
				//добавляем ключ к родителю, либо обновляем его
				$query="INSERT INTO `parents_key`(`id_parents_key`, `id_parents`, `key`) VALUES (NULL,'".$parent["id_parents"]."','$key') ON DUPLICATE KEY UPDATE `key`='".$key."'";

				//Ключ успешно добавлен/обновлен
				$id_parents_key=save_data($query);
				
				$header="Доступ в личный кабинет представителя обучающегося Технопарка Толтек СФБашГУ";
				$text="<p><b>Уважаемый(ая), ".$parent["surname"]." ".$parent["name"]." ".$parent["patronymic"]."!</b></p>";
				$text.="<p> Для доступа к информации касаемо обучения Вашего ребенка в Технопарке Толтек СФБашГУ организован личный кабинет родителя/представителя.</p>";
				$text.="<p>В личном кабинете организован доступ к данным группы (групп) которые посещает ребенок, расписание и посещаемость занятий, а также организована возможность онлайн оплаты обучения банковской картой. <b>Инструкцию по оплате прикрепляем в письме.</b></p>";
				$text.="<p>Присоединяйтесь к новостному чату Технопарка </p>"; 
				$text.="<img src='cid:my-attach' style='max-width:400px;width:90%'>";
				$text.="<br><b>Пожалуйста, нажмите на кнопку ниже для того, чтобы продолжить регистрацию (сохранить свои логин и пароль доступа к личному кабинету).</b>"; 
				$text.="<br><br><a href='http://".$_SERVER["SERVER_NAME"]."/parents.php?key=".$key."' style='text-decoration:none;background-color: #1f759e;float: left; padding: 10px;border-radius: 3px;color: white;'>пройти регистрацию</a>";

				$text.="<br><br><br><br>------------<br>С уважением, Технопарк Толтек СФБашГУ!<br><br><br><br>";
				$text.='<span style="font-size:12px;font-style:italic;">Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него — мы не получим ваш вопрос и не сможем помочь. Свяжитесь с нами по телефону 8917-807-44-33.</span>';

				$res=send_mail($parent['email'],$header,$text,$_SERVER['DOCUMENT_ROOT']."/files/Pamyatka_po_oplate.pdf",array('filename' =>$_SERVER['DOCUMENT_ROOT'].'/files/WatsApp.jpg',
					'my-attach' => 'my-attach', 'name'=> 'WatsApp.jpg'));    

				$user_res=array("email" => $parent['email'], "result" => $res["result"], "msg" => $res["msg"]);
				array_push($arr, $user_res); 
			}
			
		}
	}
	
	
	echo json_encode($arr,true); 
?>