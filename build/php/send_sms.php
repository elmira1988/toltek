<?php 
	require_once("functions.php");

	$data=json_decode($_POST["data"],true);
	$addressee=$data["users"];
	$text=$data["text"];
	$type=$data["type"];

	//print_r($addressee);

	$arr_phone=array();

	foreach ($addressee as $key => $val) {
		array_push($arr_phone,$val["phone"]);
	}

	//print_r(implode(",",$arr_phone)); 
	
	$ch = curl_init("https://sms.ru/sms/send");

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
	    "api_id" => "CD461E87-3C18-B886-0F78-CA47EFF2AE7C", //наш секретный код
	    "to" => implode(",",$arr_phone), // До 100 штук за раз
	    //"msg" => iconv("windows-1251", "utf-8", "Привет!"), // Если приходят крякозябры, то уберите iconv и оставьте только "Привет!",
	    "msg" => $text, // Если приходят крякозябры, то уберите iconv и оставьте только "Привет!",
	    
	    // Если вы хотите отправлять разные тексты на разные номера, воспользуйтесь этим кодом. В этом случае to и msg нужно убрать.
	    //"multi" => array( // до 100 штук за раз
	    //    "79178074433"=> iconv("windows-1251", "utf-8", "Привет 1"), // Если приходят крякозябры, то уберите iconv и оставьте только "Привет!",
	    //    "74993221627"=> iconv("windows-1251", "utf-8", "Привет 2") 
	    //),
	    
	    "json" => 1 // Для получения более развернутого ответа от сервера
	)));

	$str = curl_exec($ch);
	curl_close($ch);
	
	//$json = json_decode($body);
	
	//$str='{"status": "OK","status_code": 100, "sms": 
	//		{"79178659658": {"status": "OK", "status_code": 100,"sms_id": "000000-10000000"},
	//       "79874589658": {
	//            "status": "ERROR",
	//            "status_code": 207,
	//            "status_text": "На этот номер (или один из номеров) нельзя отправлять сообщения, либо указано более 100 номеров в списке получателей"
	 //       }} , "balance": 4122.56 }';
       
	$sms_answer = json_decode($str,true); 

	if ($sms_answer) { // Получен ответ от сервера
	    if ($sms_answer["status"] == "OK") 
	    { // Запрос выполнился
	    	foreach ($addressee as $key => $val) 
	    	{
			//если сообщение было успешно отправлено, то формируем массив для дальнейшего сохранения в базе
			if ($sms_answer["sms"][$val["phone"]]["status_code"]==100)
				{
					$addressee[$key]["status"]=$sms_answer["sms"][$val["phone"]]["status"];
					$addressee[$key]["status_code"]=$sms_answer["sms"][$val["phone"]]["status_code"];
					$addressee[$key]["status_text"]=$sms_answer["sms"][$val["phone"]]["status_text"];
					$addressee[$key]["sms_id"]=$sms_answer["sms"][$val["phone"]]["sms_id"];
					$addressee[$key]["text"]=$text;

					$id_user=$addressee[$key]["id_user"];
					unset($addressee[$key]["id_user"]);

					$arr=get_array_key_value($addressee[$key]);
					
					//сохраняем статус смс
					$query="INSERT INTO `sms` (".implode(",",$arr[0]).") VALUES (".implode(",",$arr[1]).")";
					$id_sms=save_data($query); 

					//сохраняем адресата
					$query="INSERT INTO `sms__".$type."s` (`id_".$type."s`,`id_sms`) VALUES ('".$id_user."','".$id_sms."')";
					$result=save_data($query);
				}
			
			}
	    } 
	} 

    echo $str; 
?>

	
