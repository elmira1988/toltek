  <?php 
  require_once("functions.php");
  
  $teacher=get_teachers(array("id_teachers" => array($_POST["id_teachers"])))[0];
  //print_r($teacher);
  $history=get_history_of_job($_POST["id_teachers"]);

  $str="<h4>История деятельности</h4>";  

  
      $str.='<table class="table" style="margin:0px;">';
      $str.='<tbody>';
       $str.='<tr>';
          $str.='<td title="'.get_time($teacher["date_of_creation"],1).'" style="cursor:pointer;">';
            $str.=get_time($teacher["date_of_creation"],2);
          $str.='</td>';
          $str.='<td>добавлен в базу</td>';
          $str.='<td></td>';
         $str.='</tr>';
         if (count($history)>0)
          {
            foreach ($history as $key => $value) {
               $str.='<tr>';
                $str.='<td title="'.get_time($value["date"],1).'" style="cursor:pointer;">';
                  $str.=get_time($value["date"],2);
                $str.='</td>';
                $str.='<td>'.get_job_status($value["id_job_status"]).'</td>';
                $str.='<td><i>'.$value["note"].'</i></td>';
               $str.='</tr>';
            }
        }
      $str.='</tbody>';
    $str.='</table>';



  echo $str;
  
   ?>
   