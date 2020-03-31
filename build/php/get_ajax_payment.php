<?php 
  session_name('toltek');
  session_start();  

  require_once("functions.php");
 	
  $arr=json_decode($_POST["data"],true);

  if (count($arr)!=0)
 	{
 		$payments=get_payments($arr);
 	}
 	else
 	{
    $payments=get_payments(); 
 	}

  //print_r($payments); 

 $mas=array();
 $summ=0;

 foreach ($payments as $k => $v) 
  {
       
        $vmas=array();
        $student=get_students(array("id_students"=>array($v["id_students"])))[0];
        $group=get_groups(array("id_groups"=>array($v["id_groups"])))[0];//информацию по группе
        $parent=get_parents(array("id_students" => array($v["id_students"])))[0];
        $name=$student["surname"].' '.$student["name"].' '.$student["patronymic"];
        $sms_in_month=get_history_sms(array("id_user" => array($student["id_students"]),"months" => array(date('m')))); 

        //ФОРМИРУЕМ СТРОКУ

        //Checkbox
        array_push($vmas,'<td><input type="checkbox" name="selected" class="flat"></td>');//checkbox

        //Данные студента
        $str='';
        if (count($sms_in_month)>0)
        {
           $str.='<div class="fa fa-envelope last_sms" data-toggle="tooltip" data-placement="top" title="'.get_time($sms_in_month[count($sms_in_month)-1]["date"],5).'"></div>';
        }
       
        $str.='<span id="student" title="'.$v["id_students"].'" data-id-students="'.$v["id_students"].'" onclick="modal_history('.$v["id_students"].',\''.$name.'\')">'.$name.'</span>'; 
        $str.='<br><i class="fa fa-child"></i> '.$group['name_of_group'].' / <small>'.$group["name_of_course"].'</small>';
        $str.='<br><h2 style="margin:0px;"><small><i class="fa fa-mobile-phone"></i> '.$parent['phone'];
        $str.='<br><i class="fa fa-envelope-o"></i> '.$parent['email'].'</small></h2>';

        array_push($vmas,$str);

        //Описание оплаченных периодов
        $str="";
        $p=0;  
        if (count($v["payments"]))
        { 
               
          foreach ($v["payments"] as $key => $val)
           {
             if ($p>0) $str.='<div style="margin:5px 0px;width:100%;border-top:1px solid #ddd;"></div>';
          
             $parent=get_info_parents($val["id_parents"])[0];//представитель
             $date_of_receiving=get_time($val["date_of_receiving"],2);//дата списания платежа
             $paymaster=get_paymasters(array("id_users"=>array($val["id_users"])))[0];//кассир


             $str.="<div class='row' style='margin:0px;margin-top:5px;'>"; 
               //Месяц
               $str.='<div class="col-lg-1 col-md-4" id="block_with_months">'.print_months_study_payment(array($val["month"]),$v["months_of_study"],$v["goodmonths"]).'</div>';
               //Сумма
               $str.='<div class="col-lg-1 col-md-4" style="text-align:center;height:25px;" ';
               if ($date_of_receiving=="")
                $str.=" amount='notreceiving' payment='".$val['id_payment']."'";  
                $str.='>'.$val["amount"].'</div>'; 
                $summ+=$val["amount"]; 
                //Дата оплаты
               $str.='<div class="col-lg-2 col-md-4" style="height:25px;">'.get_time($val["date_of_entry"],2).'</div>';
                //Плательщик
                $str.='<div class="col-lg-3 col-md-4" style="height:25px;">'; 
                $str.='<span style="line-height: 14px;" '.(($val["id_users"]!=6)?' onclick="print_payment_info(this)" paint="paint/'.$val['paint'].'"':' orderId="'.get_orderid($val["id_payment"]).'" ').' surname="'.$parent['surname'].' '.$parent['name'].' '.$parent['patronymic'].'">'.get_inic($parent['surname'],$parent['name'],$parent['patronymic']).'</span>';
               $str.='</div>';                
               //Кассир
               $str.='<div class="col-lg-3 col-md-4" style="height:25px;">'.get_inic($paymaster["surname"],$paymaster['name'],$paymaster['patronymic']);
               if ($val["note"]!="")
               {
                $str.="<br><i>".$val["note"]."</i>"; 
               }
               $str.='</div>';
               //Дата списания
               $str.='<div class="col-lg-2 col-md-4" style="height:25px;>'.$date_of_receiving.'</div>';
             $str.='</div>';
             $p++;
            } 
        }
      

    array_push($vmas,$str);

    //ПЕРИОДЫ ОПЛАТЫ 
    array_push($vmas,print_months_study_payment($GLOBALS['month_study'],$v["months_of_study"],$v["goodmonths"]));
    //ИТОГО СТРОКА
    array_push($mas,$vmas);
    unset($vmas);
    unset($student);
  }

	$obj= new stdClass;
	$obj->count = count($payments);
	$obj->summa = $summ;
	$obj->data = $mas;

  print_r(json_encode($obj));
  
 ?>