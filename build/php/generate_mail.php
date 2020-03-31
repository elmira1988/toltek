<?php 
 require_once("functions.php");

//$email="Toltekplus@mail.ru";//elmira.sharapova@yandex.ru";
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php'; 

$requests=get_raw("SELECT *  FROM `requests` WHERE `id_requests` >= 215 LIMIT 110, 10");    

/* 
use \Mpdf\Mpdf;

$mpdf = new \Mpdf\Mpdf();
//Договор (образец)
$html=file_get_contents("contract.html");   
$mpdf->WriteHTML($html); 
$contract = $mpdf->Output("Договор.pdf",'S');

unset($mpdf);
$mpdf = new \Mpdf\Mpdf();
//Согласие на обработку персональынх данных
$html=file_get_contents("consent.html");   
$mpdf->WriteHTML($html); 
$consent = $mpdf->Output("Согласие.pdf",'S');
*/

// Настройки

for ($i=0;$i<count($requests);$i++) 
{
	
echo $requests[$i]['email'].'<br>';
$email=$requests[$i]['email'];
//$email="elmira.sharapova@yandex.ru";

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
$header='Толтек СФБашГУ. Приглашаем на собеседование.';
$text='<p><em><strong>Добрый день!</strong></em></p>
<p>Собеседование по вашей заявке будет проходить &nbsp;<strong>24.08.2019 (суббота) с 10:00 до 12:00 в Технопарке Толтек СФ БашГУ</strong>, расположенному по адресу:&nbsp;<span class="js-extracted-address" data-address="г. Стерлитамак, пр. Ленина 49" data-address-query="город стерлитамак пр ленина 49" data-ids="170010885933248983">г. Стерлитамак, пр. Ленина 49</span>, вход с правого торца. С собой нужно принести документы (можно копии), которые понадобятся для заключения договора:</p>
<ul>
<li>паспорт родителя, на которого будет заключаться договор об обучении;</li>
<li>паспорт обучающегося (ребенка), если нет &ndash; свидетельство&nbsp;о рождении;</li>
</ul>
<p>Вопросы можно задать администраторам по тел.:&nbsp;<strong><span class="wmi-callto">8917-807-44-33</span>,&nbsp;<span class="wmi-callto">8917-795-35-63</span></strong></p>
<br><br><br>------------<br>С уважением, Технопарк Толтек СФБашГУ!
<br><br><br><br>
<span style="font-size:12px;font-style:italic;>Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него — мы не получим ваш вопрос и не сможем помочь. Свяжитесь с нами по телефону 8917-807-44-33.</span>';



// Письмо
//$mail->isHTML(true); 
$mail->Subject = $header; // Заголовок письма
//$mail->Body = $text;//Текст письма
$mail->msgHTML($text);

//$mail->addStringAttachment($contract,'Договор.pdf','base64', 'application/pdf');//,'attachment'
//$mail->addStringAttachment($consent,'Согласие.pdf','base64', 'application/pdf');//,'attachment'

//$mail->send();

//Результат
/*
if(!$mail->send()) {
 echo 'Message could not be sent.';
 echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
 echo 'ok';
} 

echo "<br><br><br>";
unset($mail);
*/
}

 /*
 //$requests=get_all_requests();

 //print_r($requests);

 //Генерируем ключи

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