<?php 

require_once("functions.php");

//разбираем массив с номерами
$data=json_decode($_POST["data"],true);
$arr_id_users=$data["arr_id_users"];
$type=$data['id'];

$str.="<h4>Получатели ".(($type=='student')?"<small>обучающиеся/представители</small>":"")."<small class='pull-right'>всего:".count($arr_id_users)."</small></h4>"; 
$str.="<input type='hidden' name='type' value='".$type."'>";
$str.="<ul class='ul-sms'>";

foreach ($arr_id_users as $key => $id_users) { 

	if ($type=='student')
	{
		//данные обучающегося
		$student=get_students(array("id_students" => array($id_users)))[0];
		//данные представителей
		$parents=get_parents(array("id_students" => array($id_users)));

		$str.="<li>";
	 		$str.='<div class="btn-group w-100" data-toggle="buttons">';

	 			$str.='<label class="btn btn-default col-lg-4" data-toggle="tooltip" data-placement="right" title="" data-original-title="" data-id-user="'.$student["id_students"].'">';
		        	$str.='<input type="radio" name="phone">';
		        		$str.="<div style='text-align:left;'>".$student["surname"].' '.$student["name"].' '.$student["patronymic"];
		        			$str.="<i class='fa fa-envelope-square'></i>";//статус доставки
		        		$str.="</div>";
	 					$str.="<small class='pull-left'>".$student["class_number"]."кл.</small>";
	 					$str.="<small class='pull-right'  id='phone' data-phone-sms='".clear_phone_for_sms($student["phone"])."' data-who='обучающийся'>".$student["phone"]."</small>";
		        $str.='</label>'; 

		        foreach ($parents as $k => $parent) {
		        	$kinship=get_kinship($parent["id_kinship"]);
		        	$str.='<label class="btn btn-default col-lg-4'.(($k==0)?' active ':'').'" data-toggle="tooltip" data-placement="right" title="" data-original-title="" data-id-user="'.$student["id_students"].'">';
			        	$str.='<input type="radio" name="phone">';
			        		$str.="<div style='text-align:left;'>".$parent["surname"].' '.$parent["name"].' '.$parent["patronymic"];
			        			$str.="<i class='fa fa-envelope-square'></i>";
			        		$str.="</div>";

		 					$str.="<small class='pull-left'>".$kinship."</small>";
		 					$str.="<small class='pull-right' id='phone' data-phone-sms='".clear_phone_for_sms($parent["phone"])."' data-who='".$kinship."'>".$parent["phone"]."</small>";
		        $str.='</label>';
		        }
	 		$str.="<div>";
 		$str.="</li>";
	}

	if ($type=='teacher')
	{
		//данные преподавателя
		$teacher=get_teachers(array("id_teachers" => array($id_users)))[0];
		$str.="<li>";
	 		$str.='<div class="btn-group w-100" data-toggle="buttons">';
	 			$str.='<label class="btn btn-default col-lg-4 active" data-toggle="tooltip" data-placement="right" title="" data-original-title="" data-id-user="'.$teacher["id_teachers"].'">';
		        	$str.='<input type="radio" name="phone">';
		        		$str.="<div style='text-align:left;'>".$teacher["surname"].' '.$teacher["name"].' '.$teacher["patronymic"];
		        			$str.="<i class='fa fa-envelope-square'></i>";//статус доставки
		        		$str.="</div>";
	 					$str.="<small class='pull-left'  id='phone' data-phone-sms='".clear_phone_for_sms($teacher["phone"])."' data-who='преподаватель'>".$teacher["phone"]."</small>";
		        $str.='</label>'; 
	 		$str.="<div>";
 		$str.="</li>";
	}
}
$str.="</ul>";

$str.='<h4 style="margin-top:20px;margin-bottom:0px;">';
	$str.='Текст <small>длина: <b id="length">0</b> / ост. <b id="Lleft">70</b> симв · <b id="sms_count">0</b> смс </small>';
$str.='</h4>';
$str.='<textarea id="message" required="required" class="form-control" name="message"></textarea>';

echo $str;

 ?> 