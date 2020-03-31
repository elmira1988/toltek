<?php 

	require_once("functions.php");

	//разбираем массив с номерами
	$data=json_decode($_POST["data"],true);
	$arr_id_users=$data["arr_id_students"]; 
	$str='<div class="jumbotron small"><p>Отмеченные ниже <b>родители/представители получат пиьсма на указанный email со <u>ссылкой</u> на добавление или сброс (в том случае, если аккаунт уже был создан ранее) логина и пароля от личного кабинета представителя обучающегося Толтек СФБашГУ</b></p></div>';

	$str.='<div class="row">';
	foreach ($arr_id_users as $key => $id_users) {
		//данные обучающегося
		$student=get_students(array("id_students" => array($id_users)))[0];
		//данные представителей
		$parents=get_parents(array("id_students" => array($id_users)));
		
			$str.='<div class="col-lg-6 col-md-6 col-sm-12">'; 
				$str.='<div class="x_panel">';
					//x-title
					$str.='<div class="x_title">'.$student["surname"].' '.$student['name'].' '.$student['patronymic'];
		            	$str.='<div class="clearfix"></div>';
		            $str.='</div>';
		            //x-title
			        $str.='<div class="x_content">';
				        $str.='<div class="btn-group w-100" data-toggle="buttons">';
				        foreach ($parents as $k => $parent) {
				        	$kinship=get_kinship($parent["id_kinship"]);	        	
					        	$str.='<label class="btn btn-default col-lg-12 col-md-12 col-sm-12'.(($k==0)?' active ':'').'" data-toggle="tooltip" data-placement="right" title="" data-original-title="" data_id_parents="'.$parent["id_parents"].'" data_id_students="'.$parent["id_students"].'">';
						        	$str.='<input type="radio" name="phone">';
						        		$str.="<div style='text-align:left;'>".$parent["surname"].' '.$parent["name"].' '.$parent["patronymic"];
						        			$str.="<i class='fa fa fa-paper-plane'></i>"; 
						        		$str.="</div>"; 

					 					$str.="<small class='pull-left'>".$kinship."</small>";
					 					$str.="<small class='pull-right' data-email='".$parent["email"]."' data-who='".$kinship."'>".$parent["email"]."</small>";
						       	 $str.='</label>';		       	 
					        }
					     $str.='</div>';//btn-group
				     $str.='</div>';//x_content
		        $str.='</div>';//x-panel
	        $str.='</div>';//col-lg-6
	}
	$str.='</div>';//row
	echo $str;

?>