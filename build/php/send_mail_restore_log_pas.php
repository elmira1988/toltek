<?php 
require_once("functions.php");


$parents=get_parents(array("email" => array($_POST["email"])));

if (count($parents)==1)
{
	$header="Восстановление доступа к учетной записи";
	$text="<h4>Здравствуйте, ".$parents[0]["surname"]." ".$parents[0]["name"]." ".$parents[0]["patronymic"]."!</h4>";
	$text.="<p>От Вас поступил запрос на восстановление логина и пароля к личному кабинету родителя/представителя обучающегося Технопарка Толтек СФБашГУ.</p>";
	$text.="<p>Для создания нового логина и пароля нажмите на кнопку</p>";
	$text.="<a href='http://".$_SERVER["SERVER_NAME"]."/restore_log_pas.php?key=".get_data_parents_key(array("id_parents" => array($parents[0]["id_parents"])))[0]["key"]."' style='text-decoration:none;background-color: #1f759e;float: left; padding: 10px;border-radius: 3px;color: white;'>Создать новый логин/пароль</a>";

	$text.="<br><br><br><br>------------<br>С уважением, Технопарк Толтек СФБашГУ!<br><br><br><br>";
				$text.='<span style="font-size:12px;font-style:italic;">Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него — мы не получим ваш вопрос и не сможем помочь. Свяжитесь с нами по телефону 8917-807-44-33.</span>';
	
	echo json_encode(send_mail($_POST["email"],$header,$text)); 

}
else
{
	echo json_encode(array("res" => "error", "msg" => "Аккаунта, привязанного к данному почтовому ящику не существует. <br> Обратитесь к администратору за уточнением своих данных!"));
}


?>