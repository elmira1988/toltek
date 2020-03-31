  <?php 
  require_once("functions.php");
 
  $student=get_students(array("id_students" => array($_POST["id_students"])))[0];
  $history=get_history_of_study($_POST["id_students"]);
  //print_r($history);

  $table=array();

  foreach ($history as $key => $val) {

    if (!array_key_exists($val["year"],$table))
    $table[$val["year"]]=array();//разделение по учбному году

    if (!array_key_exists($val["id_students_groups"],$table[$val["year"]]))
    $table[$val["year"]][$val["id_students_groups"]]=array();//группа

    $table[$val["year"]][$val["id_students_groups"]]["date_add"]=$val["date_add"];
    $table[$val["year"]][$val["id_students_groups"]]["id_groups"]=$val["id_groups"];
    $table[$val["year"]][$val["id_students_groups"]]["months_of_study"]=$val["months_of_study"];

    //$pay_months=
    $table[$val["year"]][$val["id_students_groups"]]["payments"]=get_payments(array("payment"=> array("Receiving"),
                                            "id_students_groups"=>array($val["id_students_groups"])
                                          ))[0]["goodmonths"];

    $table[$val["year"]][$val["id_students_groups"]]["history"]=$val["history"];
  }

  $str="<h4>История обучения</h4>"; 

  $str.='<div class="row">';
    $str.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        
      foreach ($table as $year => $students_groups) 
      {
        $str.="<h5>".$year."-".($year+1)." уч. год</h5>";
        $str.='<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">';
         foreach ($students_groups as $key => $val) 
         {
          $str.=print_history_of_students_groups($key,$val);
         }
        $str.='</div>';
      }

    $str.='</div>'; 
  $str.='</div>';

  echo $str;
  
   ?>
  
 
    

      
      
   