<?php 
 require_once("functions.php");

//$email="Toltekplus@mail.ru";//elmira.sharapova@yandex.ru"; 
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php'; 
//АРХИВНИКОВ НЕ НАДО ДОБАВЛЯТЬ!!!
//$parents=get_raw("SELECT `email` FROM `parents` WHERE `id_students` IN (SELECT `id_students` FROM `students_groups` WHERE `id_students_groups` NOT IN (SELECT `id_students_groups`  FROM `payment` WHERE `months` LIKE '11')) LIMIT 280,20");    
$query="SELECT `email` FROM `parents` WHERE `id_students` IN (SELECT `id_students` FROM `students_groups` WHERE `id_students_groups` IN (SELECT `id_students_groups` FROM `students_groups` WHERE ".get_condition_of_achive(' NOT ','id_students_groups').")) LIMIT 280, 20";  

$parents=get_raw($query);
 
//echo $query;
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

for ($i=0;$i<count($parents);$i++) 
{
	
echo ($i+1).' '.$parents[$i]['email'].'<br>';
$email=$parents[$i]['email'];
//$email="elmira.sharapova@yandex.ru"; 

$mail = new PHPMailer;
 
$mail->isSMTP(); 
$mail->SMTPDebug = false;
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
$header='Толтек СФБашГУ. Оплата обучения.'; 
$text='<p><em><strong>Добрый день, родители и обучающиеся Технопарка Толтек СФ БашГУ!</strong></em></p>
<p>Напоминаем Вам, что оплату за образовательные услуги необходимо производить строго до 5 числа!</p>
<p>В декабре оплату необходимо произвести <b>за месяцы декабрь и январь до 5 декабря</b>!</p>
<p>Дополнительная информация у администратора по телефону <b>8-917-807-44-33!</b></p>
<br><br><br>------------<br>С уважением, Технопарк Толтек СФБашГУ!
<br><br><br>
<p style="font-size:12px;font-style:italic;">Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него — мы не получим ваш вопрос и не сможем помочь. Свяжитесь с нами по телефону 8917-807-44-33.</p>';



// Письмо
$mail->isHTML(true); 
$mail->Subject = $header; // Заголовок письма
$mail->Body = $text;//Текст письма
//$mail->msgHTML($text);

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

 ?>