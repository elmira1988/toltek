  <?php 
  require_once("functions.php");
  
  $str='<h4>Восстановить обучение в группе</h4>';

  $students_groups=get_students_groups($_POST['id_students_groups']);
  $group=get_groups(array('id_groups'=>array($students_groups[0]['id_groups'])))[0];
  $months=$GLOBALS["month_study"];//все учебные месяцы
  $students_groups=get_history_of_study(false,$_POST['id_students_groups']);
  $pay_months=get_payments(array("payment"=> array("Receiving"),
                                            "id_students_groups"=>array($_POST['id_students_groups'])
                                          ))[0]["goodmonths"];
  $students_groups[0]["payments"]=$pay_months;
  //print_r($students_groups);
  $str.='<div class="row">';

    $str.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
      $str.='<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">';
      foreach ($students_groups as $key => $val) 
           {
            $str.='<input type="hidden" name="months_of_study" value="'.$pay_months.'">'; 
            $str.='<input type="hidden" name="id_students_groups" value="'.$_POST['id_students_groups'].'">'; 
            $str.=print_history_of_students_groups($key,$val);
           }
      $str.='</div>';
    $str.='</div>';

    $str.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;">';
      $str.='<label>На период обучения с месяца:<label>';
    $str.='</div>';

    $str.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
    $months=get_months_between((integer)(date(m)),5);
    foreach ($months as $key => $value) {
      $str.='<label class="col-lg-1 col-md-1 col-sm-2 col-xs-3">';
        $str.='<input type="radio" class="flat" name="month" value="'.$value.'"'.(($key==0)?' checked ':' ').'> '.$GLOBALS["month"][$value];
      $str.='</label>';
    }
    $str.='</div>';

    

  $str.='</div>';

  $str.='<div class="row" style="margin-top:20px;">';
    $str.='<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Комментарий</label>';
    $str.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><textarea class="form-control" name="note" style="margin-bottom: 10px;"></textarea></div>';
  ;

  echo $str;

  
   ?>
  
 
    

      
      
   