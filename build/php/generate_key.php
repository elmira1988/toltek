<?php 
 require_once("functions.php");

 $requests=get_all_requests();

 //print_r($requests);

 //Генерируем ключи
 /*
 foreach ($requests as $key => $value) {
 	echo $value["id_requests"];
 	$key=md5(md5($value["id_requests"]));
 	echo " - ".$key."<br>";

 	$query="INSERT IGNORE INTO `toltekplus_adminnew`.`requests_key` (`id_requests_key`, `id_requests`, `key`, `followed`) VALUES (NULL, '".$value["id_requests"]."', '$key', '0');";

 	echo $query."<br>";
 	global $mysqli;

    $res=$mysqli->query($query);

 	echo "Результат ".$res."<br><br><br>";
 } 
 */
/*
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';  

for ($i=60;$i<count($requests);$i++) 
{ 
	$email=$requests[$i]["email"];
	$request_key=get_requests_key(array("id_requests" => array($requests[$i]["id_requests"])))[0]["key"];
	//print_r($request_key);
// Файлы phpmailer


// Настройки
$mail = new PHPMailer;

$mail->isSMTP(); 
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.jino.ru'; 
$mail->SMTPAuth = true; 
$mail->Username = 'no-reply@toltekplus.ru'; // Ваш логин в Яндексе. Именно логин, без @yandex.ru
$mail->Password = 'njkntr1987!'; // Ваш пароль
$mail->CharSet = 'UTF-8';
$mail->SMTPSecure = 'ssl'; 
$mail->Port = 465; 
 
$mail->SMTPKeepAlive = true;   
$mail->Mailer = "smtp"; // don't change the quotes!

$mail->setFrom('no-reply@toltekplus.ru'); // Ваш Email 

$mail->addAddress($email); // Email получателя
$header='Толтек СФБашГУ. Статус заявки на обучение.';
$text='Здравствуйте! <br>Пройдите по <a href="http://admin.toltekplus.ru/info.php?key='.$request_key.'">ссылке</a>, чтобы отследить статус заявки, отправленной ранее в Толтек СФБашГУ. <br>Статус заявки может обновляться с течением времени.
<br><br><br>------------<br>С уважением, Технопарк Толтек СФБашГУ!
<br><br><br><br>
<span style="font-size:12px;font-style:italic;">Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него — мы не получим ваш вопрос и не сможем помочь. Свяжитесь с нами по телефону 8917-807-44-33.</span>';


// Письмо
$mail->isHTML(true); 
$mail->Subject = $header; // Заголовок письма
$mail->Body = $text;//Текст письма

//$mail->send();

//Результат
if(!$mail->send()) {
 echo 'Message could not be sent.';
 echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
 echo 'ok';
}

echo "<br><br><br>";
}

*/
 ?>