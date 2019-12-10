<?php

$GLOBALS["year"]=2019;
 
$month=array('1'=>'янв', '2'=>'фев', '3'=>'мар', '4'=>'апр', '5'=>'май', '6'=>'июн',
			 '7'=>'июл', '8'=>'авг', '9'=>'сен', '10'=>'окт', '11'=>'ноя', '12'=>'дек' );

$GLOBALS["month"]=$month;
$GLOBALS["month_study"]=array(9,10,11,12,1,2,3,4,5); 

//администратор
$arr=[];
$arr[1]=[];
$arr[1]["start_page"]="payment_history.php";
$arr[1]["open"]=[];
$arr[1]["closed"]=["payment"];

//кассир
$arr[2]=[];
$arr[2]["start_page"]="payment.php";
$arr[2]["open"]=["payment","payment_history"];
$arr[2]["closed"]=[];

//старший кассир
$arr[3]=[];
$arr[3]["start_page"]="payment_history.php";
$arr[3]["open"]=["payment_statistic","payment_history"];
$arr[3]["closed"]=[]; 

$GLOBALS["arr"]=$arr;


//МЕНЮ
$ArrNav=[];

//Заявки
$ArrNav["requests"]=[]; 
$ArrNav["requests"]["icon"]="fa fa-envelope-o";
$ArrNav["requests"]["name"]="Заявки";
$ArrNav["requests"]["span"]='<span class="fa fa-chevron-down"></span>';

$ArrNav["requests"]["child_menu"]=[];

$ArrNav["requests"]["child_menu"]["send_request_yourself"]=[];
$ArrNav["requests"]["child_menu"]["send_request_yourself"]["href"]="send_request_yourself.php";
$ArrNav["requests"]["child_menu"]["send_request_yourself"]["name"]="Добавить заявку";

$ArrNav["requests"]["child_menu"]["all_request"]=[];
$ArrNav["requests"]["child_menu"]["all_request"]["href"]="all_request.php";
$ArrNav["requests"]["child_menu"]["all_request"]["name"]="Все заявки";

$ArrNav["requests"]["child_menu"]["request_statistic"]=[];
$ArrNav["requests"]["child_menu"]["request_statistic"]["href"]="request_statistic.php";
$ArrNav["requests"]["child_menu"]["request_statistic"]["name"]="Статистика";


//Курсы
$ArrNav["courses"]=[];
$ArrNav["courses"]["icon"]="fa fa-bookmark-o";
$ArrNav["courses"]["name"]="Курсы";
$ArrNav["courses"]["span"]='<span class="fa fa-chevron-down"></span>';

$ArrNav["courses"]["child_menu"]=[];

$ArrNav["courses"]["child_menu"]["add_courses"]=[];
$ArrNav["courses"]["child_menu"]["add_courses"]["href"]="add_courses.php";
$ArrNav["courses"]["child_menu"]["add_courses"]["name"]="Добавить курс";

$ArrNav["courses"]["child_menu"]["all_courses"]=[];
$ArrNav["courses"]["child_menu"]["all_courses"]["href"]="all_courses.php";
$ArrNav["courses"]["child_menu"]["all_courses"]["name"]="Все куры";


//Группы
$ArrNav["groups"]=[];
$ArrNav["courses"]["icon"]="fa fa-child";
$ArrNav["courses"]["name"]="Группы";
$ArrNav["courses"]["span"]='<span class="fa fa-chevron-down"></span>';

$ArrNav["courses"]["child_menu"]=[];

$ArrNav["courses"]["child_menu"]["add_groups"]=[];
$ArrNav["courses"]["child_menu"]["add_groups"]["href"]="add_groups.php";
$ArrNav["courses"]["child_menu"]["add_groups"]["name"]="Добавить";

$ArrNav["courses"]["child_menu"]["all_groups"]=[];
$ArrNav["courses"]["child_menu"]["all_groups"]["href"]="all_groups.php";
$ArrNav["courses"]["child_menu"]["all_groups"]["name"]="Все группы";

//Обучающиеся
$ArrNav["groups"]=[];
$ArrNav["groups"]["icon"]="fa fa-group";
$ArrNav["groups"]["name"]="Обучающиеся";
$ArrNav["groups"]["span"]='<span class="fa fa-chevron-down"></span>';

$ArrNav["groups"]["child_menu"]=[];

$ArrNav["groups"]["child_menu"]["id"]=[];
$ArrNav["groups"]["child_menu"]["id"]["id"]="add_students";
$ArrNav["groups"]["child_menu"]["id"]["href"]="add_students.php";
$ArrNav["groups"]["child_menu"]["id"]["name"]="Добавить";

$ArrNav["groups"]["child_menu"]["all_students"]=[];
$ArrNav["groups"]["child_menu"]["all_students"]["href"]="all_students.php";
$ArrNav["groups"]["child_menu"]["all_students"]["name"]="Все обучающиеся";

$ArrNav["groups"]["child_menu"]["payment"]=[];
$ArrNav["groups"]["child_menu"]["payment"]["href"]="payment.php";
$ArrNav["groups"]["child_menu"]["payment"]["name"]="Внести оплату";

$ArrNav["groups"]["child_menu"]["payment_history"]=[];
$ArrNav["groups"]["child_menu"]["payment_history"]["href"]="payment_history.php";
$ArrNav["groups"]["child_menu"]["payment_history"]["name"]="История выплат";

$ArrNav["groups"]["child_menu"]["payment_statistic"]=[];
$ArrNav["groups"]["child_menu"]["payment_statistic"]["href"]="payment_statistic.php";
$ArrNav["groups"]["child_menu"]["payment_statistic"]["name"]="Статистика по выплатам";


//Преподаватели
$ArrNav["teachers"]=[];
$ArrNav["teachers"]["icon"]="fa fa-group";
$ArrNav["teachers"]["name"]="Преподаватели";
$ArrNav["teachers"]["span"]='<span class="fa fa-chevron-down"></span>';

$ArrNav["teachers"]["child_menu"]=[];

$ArrNav["teachers"]["child_menu"]["add_teacher"]=[];
$ArrNav["teachers"]["child_menu"]["add_teacher"]["href"]="add_teacher.php";
$ArrNav["teachers"]["child_menu"]["add_teacher"]["name"]="Добавить";

$ArrNav["teachers"]["child_menu"]["all_teachers"]=[];
$ArrNav["teachers"]["child_menu"]["all_teachers"]["href"]="all_teachers.php";
$ArrNav["teachers"]["child_menu"]["all_teachers"]["name"]="Все преподаватели";


$ArrNav["teachers"]["child_menu"]["load"]=[];
$ArrNav["teachers"]["child_menu"]["load"]["href"]="#";
$ArrNav["teachers"]["child_menu"]["load"]["name"]="Нагрузка";


//Расписание
$ArrNav["timetable"]=[];
$ArrNav["timetable"]["icon"]="fa fa-calendar";
$ArrNav["timetable"]["name"]="Расписание";
$ArrNav["timetable"]["span"]='<span class="fa fa-chevron-down"></span>';

$ArrNav["timetable"]["child_menu"]=[];

$ArrNav["timetable"]["child_menu"]["constructor"]=[];
$ArrNav["timetable"]["child_menu"]["constructor"]["href"]="constructor.php";
$ArrNav["timetable"]["child_menu"]["constructor"]["name"]="Конструктор расписания";

$ArrNav["timetable"]["child_menu"]["rasp"]=[];
$ArrNav["timetable"]["child_menu"]["rasp"]["href"]="rasp.php";
$ArrNav["timetable"]["child_menu"]["rasp"]["name"]="Просмотр расписания";


//Статистика
$ArrNav["statistic"]=[];
$ArrNav["statistic"]["icon"]="fa fa-line-chart";
$ArrNav["statistic"]["name"]="Статистика";
$ArrNav["statistic"]["span"]='<span class="fa fa-chevron-down"></span>';

$ArrNav["statistic"]["child_menu"]=[];

$ArrNav["statistic"]["child_menu"]["stat1"]=[];
$ArrNav["statistic"]["child_menu"]["stat1"]["href"]="stat1.php";
$ArrNav["statistic"]["child_menu"]["stat1"]["name"]="Статистика по годам";

$ArrNav["timetable"]["child_menu"]["stat2"]=[];
$ArrNav["timetable"]["child_menu"]["stat2"]["href"]="stat2.php";
$ArrNav["timetable"]["child_menu"]["stat2"]["name"]="Статистика по месяцам";

$GLOBALS["ArrNav"]=$ArrNav;

 ?>