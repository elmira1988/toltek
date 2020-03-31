<?php 
//Отправка письма пользователю с подтверждение м получения заявки на обучение
include 'functions.php';

$user=json_decode($_POST['val'],true);
if ($_POST['for_email']=='user')
{
	//Письмо пользователю
	$request_key=get_requests_key(array("id_requests" => array($_POST["id_requests"])))[0]["key"]; 
	$email=$user['email']; // Email получателя
	$header='Толтек СФБашГУ. Заявка на обучение.';
	$text='Здравствуйте!<br> <b>Ваша заявка успешно принята!</b><br>
	Благодарим за проявленный интерес к изучению технических наук!<br>
	Это уверенный шаг в профессиональное будущее ваших детей!<br><br>
	В ближайшее время мы свяжемся с Вами для уточнения даты и времени проведения собеседования.<br>
	Статус заявки Вы можете отслеживать, пройдя по <a href="http://'.$_SERVER["SERVER_NAME"].'/info.php?key='.$request_key.'">ссылке</a>
	<br><br><br>------------<br>С уважением, Технопарк Толтек СФБашГУ!
	<br><br><br><br>
	<span style="font-size:12px;font-style:italic;">Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него — мы не получим ваш вопрос и не сможем помочь. Свяжитесь с нами по телефону 8917-807-44-33.</span>';

}
else
{
	//Письмо администратору
	$email='admin@toltekplus.ru'; // Email получателя
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

print_r(send_mail($email,$header,$text));

?>