  <?php 
  require_once("functions.php");
  //print_r($_POST);
  $students=get_students(array("id_groups" => array($_POST["id_groups"]), "achive" => array("false")));
  //print_r($students);

  $str="";

  if (count($students)>0)
  {
	  $str.='<table class="table table-striped">';
	  	$str.='<thead>';
	  		$str.='<tr>';
	  			$str.='<th>№</th>';
	  			$str.='<th>Ф.И.О.</th>';
	  			$str.='<th>Класс</th>';
	  			$str.='<th>Телефон</th>';
	  		$str.='</tr>';
	  	$str.='</thead>';
	  	$str.='<tbody>';

	  	foreach ($students as $k => $student) {
	  		$str.='<tr>';
	  			$str.='<td>'.($k+1).'</td>';
	  			$str.='<td>'.$student["surname"].' '.$student["name"].' '.$student["patronymic"].'</td>';
	  			$str.='<td>'.$student["class_number"].'</td>';
	  			$str.='<td>'.$student["phone"].'</td>';
	  		$str.='</tr>';
	  	}

	  	$str.='</tbody>';
	  $str.='</table>';
  }
  else
  {
  	$str.='<div class="alert alert-info" role="alert">За группой пока никто не закреплен!</div>';
  }

  echo $str;

  ?>