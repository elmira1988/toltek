<?php
require_once("functions.php");

//$email="Toltekplus@mail.ru";//elmira.sharapova@yandex.ru"; 
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';
//АРХИВНИКОВ НЕ НАДО ДОБАВЛЯТЬ!!!
//$parents=get_raw("SELECT `email` FROM `parents` WHERE `id_students` IN (SELECT `id_students` FROM `students_groups` WHERE `id_students_groups` NOT IN (SELECT `id_students_groups`  FROM `payment` WHERE `months` LIKE '11')) LIMIT 280,20");    
//$query="SELECT `email` FROM `parents` WHERE `id_students` IN (SELECT `id_students` FROM `students_groups` WHERE `id_students_groups` IN (SELECT `id_students_groups` FROM `students_groups` WHERE ".get_condition_of_achive(' NOT ','id_students_groups').")) LIMIT 280, 20";  

// $query="SELECT `email` FROM `parents` WHERE `id_students` IN (SELECT `id_students` FROM `students_groups` WHERE `id_students_groups` IN (SELECT `id_students_groups` FROM `students_groups` WHERE `id_students_groups` IN (SELECT `id_students_groups` FROM `students_groups` WHERE `id_students_groups` NOT IN (SELECT `id_students_groups` FROM `history_of_study` WHERE `id_history_of_study` IN (SELECT MAX(`id_history_of_study`) AS `id_history_of_study` FROM `history_of_study` GROUP BY `id_students_groups`) AND `id_study_status`=1)))) AND `id_students` IN (SELECT `id_students` FROM `students_groups` WHERE `id_students_groups` NOT IN (SELECT `id_students_groups` FROM `payment` WHERE `id_payment` IN (SELECT `id_payment` FROM `payment_detail` WHERE `month`=1)))
// ORDER BY `parents`.`surname` ASC LIMIT 0, 20";  


$query = "SELECT `email` FROM `parents` WHERE `id_students` IN (SELECT `id_students` FROM `students_groups` WHERE `id_groups` IN (SELECT `id_groups` FROM `groups` WHERE `id_groups` IN (53,26,30,48,6,32,9,42,59,31,29)) AND `id_students_groups` IN (SELECT `id_students_groups` FROM `students_groups` WHERE `id_students_groups` IN (SELECT `id_students_groups` FROM `students_groups` WHERE `id_students_groups` NOT IN (SELECT `id_students_groups` FROM `history_of_study` WHERE `id_history_of_study` IN (SELECT MAX(`id_history_of_study`) AS `id_history_of_study` FROM `history_of_study` GROUP BY `id_students_groups`) AND `id_study_status`=1)))) ORDER BY `parents`.`surname` ASC LIMIT 0, 20";
$parents = get_raw($query);

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

//$count=count($parents);
$count = 1;

for ($i = 0; $i < $count; $i++) {


//$email=$parents[$i]['email'];
//$email="elmira.sharapova@yandex.ru"; 
    $email = "alkhamovroman@gmail.com";
    echo ($i + 1) . ' ' . $email . '<br>';

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->SMTPDebug = false;
    $mail->Host = 'smtp.jino.ru';
    $mail->SMTPAuth = true;
    $mail->Username = 'no-reply@toltekplus.ru'; // Ваш логин в Яндексе. Именно логин, без @yandex.ru
    $mail->Password = '$nep8JdrZYwr'; // Ваш пароль
    $mail->CharSet = 'UTF-8';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->SMTPKeepAlive = true;
    $mail->Mailer = "smtp"; // don't change the quotes!

    $mail->setFrom('no-reply@toltekplus.ru'); // Ваш Email

    $mail->addAddress($email); // Email получателя

    $header = 'Толтек СФБашГУ. Выходной день.';
    $text = '<p><em><strong>Уважаемые родители/представители и обучающиеся!</strong></em></p>
<p>Уведомляем Вас о том, что 24 февраля (понедельник) в Технопарке Толтек СФ БашГУ выходной день!</p>
<p>23 февраля выпадает на воскресенье, поэтому переносится на будний день.</p>
<p><strong>С наступающим Днем Защитника Отечества!</strong></p>
<p><strong>Всего Вам доброго!</strong></p>
<br>
<p>Дополнительная информация у администратора по телефону <b>8-917-807-44-33!</b></p>
<br><br><br>------------<br>С уважением, Технопарк Толтек СФБашГУ!
<br><br><br>
<p style="font-size:12px;font-style:italic;">Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него — мы не получим ваш вопрос и не сможем помочь. Свяжитесь с нами по телефону 8917-807-44-33.</p>';

    /*$header='Толтек СФБашГУ. "Оплата обучения".';
    $text='<p><em><strong>Добрый день, Уважаемые родители и обучающиеся Технопарка Толтек СФ БашГУ! </strong></em></p>
    <p><b>Поздравляем Вас с наступающим Новым 2020 годом!</b> Желаем Вам счастья, здоровья, удачи, успехов и исполнения всех желаний в предстоящем году!</p>
    <p>Новогодние каникулы в Технопарке будут с 31 декабря по 8 января! Занятия начинаются с 9 января соответственно!
    Также напоминаем Вам о необходимости внесения оплаты за образовательные услуги в январе месяце!</p>
    <p>Оплату необходимо будет внести сегодня (26.12), в пятницу (27.12), а также в субботу (28.12) с 9:00 до 15:00, а также в понедельник (30.12) в течение рабочего дня. Понедельник - последний день сдачи денег за образовательные услуги в январе месяце!</p>
    <p>Всего доброго Вам и с наступающим Новым годом!</p>
    <br>
    <p>Дополнительная информация у администратора по телефону <b>8-917-807-44-33!</b></p>
    <br><br><br>------------<br>С уважением, Технопарк Толтек СФБашГУ!
    <br><br><br>
    <p style="font-size:12px;font-style:italic;">Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него — мы не получим ваш вопрос и не сможем помочь. Свяжитесь с нами по телефону 8917-807-44-33.</p>';*/


// Письмо
    $mail->isHTML(true);
    $mail->Subject = $header; // Заголовок письма
    $mail->Body = $text;//Текст письма
//$mail->msgHTML($text);

//$mail->addStringAttachment($contract,'Договор.pdf','base64', 'application/pdf');//,'attachment'
//$mail->addStringAttachment($consent,'Согласие.pdf','base64', 'application/pdf');//,'attachment'

//$mail->send();

//Результат

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'ok';
    }

    echo "<br><br><br>";
    unset($mail);

}

?>