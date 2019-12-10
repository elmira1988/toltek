<?php 

include 'functions.php';
// Файлы phpmailer
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php'; 

$user=json_decode($_POST['val'],true);

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
if ($_POST['for_email']=='user')
{
	$request_key=get_requests_key(array("id_requests" => array($_POST["id_requests"])))[0]["key"]; 
	$mail->addAddress($user['email']); // Email получателя
	$header='Толтек СФБашГУ. Заявка на обучение.';
	$text='Здравствуйте!<br> <b>Ваша заявка успешно принята!</b><br>
	Благодарим за проявленный интерес к изучению технических наук!<br>
	Это уверенный шаг в профессиональное будущее ваших детей!<br><br>
	В ближайшее время мы свяжемся с Вами для уточнения даты и времени проведения собеседования.<br>
	Статус заявки Вы можете отслеживать, пройдя по <a href="http://admin.toltekplus.ru/info.php?key='.$request_key.'">ссылке</a>
	<br><br><br>------------<br>С уважением, Технопарк Толтек СФБашГУ!
	<br><br><br><br>
	<span style="font-size:12px;font-style:italic;">Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него — мы не получим ваш вопрос и не сможем помочь. Свяжитесь с нами по телефону 8917-807-44-33.</span>';
}
else
{
	$mail->addAddress('admin@toltekplus.ru'); // Email получателя
	$header='Толтек СФБашГУ. Новая заявка на обучение.';
	$text='Здравствуйте!<br> <b>Поступила новая заявка, пожалуйста, ознакомьтесь с ней в личном кабинете!</b><br><br>
	Ученик:<br>'.$user['surname'].' '.$user['name'].' '.$user['patronymic'].', '.get_time($user['birth'],0).' г.р.,'.$user['class_number'].' класс<br><br>
	Представитель:<br>'.$user['parent'].', '.$user['email'].', '.$user['phone'].'<br><br> Выбраны курсы:<br><b>';

	for ($i=0;$i<count($user['id_courses']);$i++)
	{
		if ($i!=0) $text.=', '; 
		$text.=get_courses_info($user['id_courses'][$i],'name_of_course');
	}

	$text.='</b>';
}

// Письмо
$mail->isHTML(true); 
$mail->Subject = $header; // Заголовок письма
$mail->Body = $text;//Текст письма

$mail->send();

//Результат
//if(!$mail->send()) {
// echo 'Message could not be sent.';
// echo 'Mailer Error: ' . $mail->ErrorInfo;
//} else {
// echo 'ok';
//}

?>