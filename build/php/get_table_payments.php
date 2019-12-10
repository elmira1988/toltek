  <?php 
  session_name('toltek');
  session_start(); 

  require_once("functions.php");
 	
  $arr=json_decode($_POST["data"],true);
  
  if (count($arr)!=0)
 	{
 	  //print_r($arr); 
 		$payments=get_payments($arr);

 	}
 	else
 	{
    $payments=get_payments();
 	}

  //print_r($payments[0]); 

 ?>

  <!--Таблица с данными -->
  <h2 style="margin:0px" class="pull-right"><small>записей</small> <?php echo count($payments) ?>
    <span id="summa"></span></h2>
    <!--<i class="fa fa-check"></i> <i class="fa fa-ruble"></i>-->
  <div class="row">
     <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <table id="datatable-fixed-header" class="table table-bordered " style="width:100%"><!--table-striped table-bordered--> 
            <thead>
              <tr>
                <?php 
                  //if ($_SESSION["id_roles"]==3)
                  //{
                ?>
                <th rowspan="2" data-orderable="false" style="width:20px;"><input type="checkbox" id="check-all" class="flat"></th>
                    <?php
                 // }
                 ?>                
                <th rowspan="2" style="width:20%;max-width:240px;">Ф.И.О./ Группа/ Курс</th>
                <th data-orderable="false" style="text-align: center;">Оплачено</th>
                <th rowspan="2" data-orderable="false" style="text-align: center;width:120px;">Не оплачено</th>
              </tr>
              <tr>
                <th style="padding:0px;border-right: 1px solid #dddddd;" data-orderable="false">
                  <div class="col-lg-2 col-md-2">Период</div>
                  <div class="col-lg-2 col-md-2" style="text-align:center;">Сумма (руб.)</div>
                  <div class="col-lg-2 col-md-2">Плательщик</div>
                  <div class="col-lg-2 col-md-2">Дата оплаты</div>
                  <div class="col-lg-2 col-md-2">Кассир</div>
                  <div class="col-lg-2 col-md-2">Дата списания</div>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $str='';
              $summ=0;
               foreach ($payments as $k => $v) 
                {
                  $student=get_students(array("id_students"=>array($v["id_students"])))[0];
                  $group=get_groups(array("id_groups"=>array($v["id_groups"])))[0];//информацию по группе
                  $parent=get_parents($v["id_students"])[0];
                  $name=$student["surname"].' '.$student["name"].' '.$student["patronymic"];
                  $sms_in_month=get_history_sms(array("id_user" => array($student["id_students"]),"months" => array(date('m')))); 
                  /*ФИО обучащегося, группа, курс*/
                  $str.="<tr>";
                  //if ($_SESSION["id_roles"]==3)
                  //{
                    $str.='<td><input type="checkbox" name="selected" class="flat"></td>';
                  //} 
                    $str.='<td style="border-bottom: 2px solid #dddddd;position:relative;">'; 
                          if (count($sms_in_month)>0)
                          {
                             $str.='<div class="fa fa-envelope last_sms" data-toggle="tooltip" data-placement="top" title="'.get_time($sms_in_month[count($sms_in_month)-1]["date"],5).'"></div>';
                          }
                         
                          $str.='<span id="student" title="'.$v["id_students"].'" data-id-students="'.$v["id_students"].'" onclick="modal_history('.$v["id_students"].',\''.$name.'\')">'.$name.'</span>'; 
                          $str.='<br><i class="fa fa-child"></i> '.$group['name_of_group'].' / <small>'.$group["name_of_course"].'</small>';
                          $str.='<br><h2 style="margin:0px;"><small><i class="fa fa-mobile-phone"></i> '.$parent['phone'];
                          $str.='<br><i class="fa fa-envelope-o"></i> '.$parent['email'].'</small></h2>';
                    $str.='</td>';
                  $str.='<td style="border-bottom: 2px solid #dddddd;padding:0px;">';

                  /*Описание оплаченных периодов*/

                  $p=0;
                   foreach ($v["payments"] as $key => $val)
                   {
                     if ($p>0) $str.='<div style="margin:5px 0px;width:100%;border-top:1px solid #ddd;"></div>';
                 
                     $parent=get_info_parents($val["id_parents"])[0];//представитель
                     $date_of_receiving=get_time($val["date_of_receiving"],2);//дата списания платежа
                     $paymaster=get_paymasters(array("id_users"=>array($val["id_users"])))[0];
                     
                     $str.="<div class='row' style='margin:0px;margin-top:5px;'>";
                     //print_this_months($val['months'])
                       $str.='<div class="col-lg-2 col-md-2" id="block_with_months">'.print_months_study_payment(explode(",",$val['months']),$v["months_of_study"],$v["goodmonths"]).'</div>';
                       $str.='<div class="col-lg-2 col-md-2" style="text-align:center;" ';
                       if ($date_of_receiving=="")
                        $str.=" amount='notreceiving' payment='".$val['id_payment']."'"; 
                        $str.='>'.$val["amount"].'</div>';
                        $summ+=$val["amount"];
                        $str.='<div class="col-lg-2 col-md-2">'; 
                        $str.='<span style="line-height: 14px;" onclick="print_payment_info(this)" paint="paint/'.$val['paint'].'" surname="'.$parent['surname'].' '.$parent['name'].' '.$parent['patronymic'].'">'.$parent['surname'].' '.substr($parent['name'], 0, 2).'. '.substr($parent['patronymic'], 0, 2).'.</span>';
                       $str.='</div>'; 
                       $str.='<div class="col-lg-2 col-md-2">'.get_time($val["date_of_entry"],2).'</div>';
                       $str.='<div class="col-lg-2 col-md-2">'.$paymaster["surname"].' '.substr($paymaster['name'], 0, 2).'. '.substr($paymaster['patronymic'], 0, 2).'.';
                       if ($val["note"]!="")
                       {
                        $str.="<br><i>".$val["note"]."</i>";
                       }
                       $str.='</div>';
                       $str.='<div class="col-lg-2 col-md-2">'.$date_of_receiving.'</div>';
                     $str.='</div>';
                     $p++;
                  } 
                  //print_this_months($v["badmonths"])
                   $str.='<td style="border-bottom: 2px solid #dddddd;" id="block_with_months">';
                   $str.=print_months_study_payment($GLOBALS['month_study'],$v["months_of_study"],$v["goodmonths"]).'</td>';
                   $str.='</tr>'; 

                   unset($student);
                }

                echo $str; 
               ?>
               
            </tbody>
          </table>
          </div>
    </div>
  </div>
  <input type="hidden" name="summa" value="<?php echo $summ; ?>"/>
  </div>
 

