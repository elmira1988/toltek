  <?php 
  require_once("functions.php");

  $all_sms=get_history_sms(array("id_user" => array($_POST["id_user"])),$_POST["type"]);

   $str='<h4>Истрия СМС-сообщений</h4>';

  if (count($all_sms)>0)
  {
	  $str.='<table class="table table-striped">';
	  	$str.='<thead>';
	  		$str.='<tr>';
	  			$str.='<th>Дата</th>';
	  			$str.='<th>Сообщение</th>';
	  			$str.='<th>Телефон</th>';
	  		$str.='</tr>';
	  	$str.='</thead>';
	  	$str.='<tbody>';

	  	foreach ($all_sms as $k => $sms) {
	  		$str.='<tr>';
	  			$str.='<td>'.get_time($sms["date"],1).'</td>';
	  			$str.='<td>'.$sms["text"].'</td>';
	  			$str.='<td>'.$sms["phone"].'<br>'.$sms["who"].'</td>';
	  		$str.='</tr>';
	  	}

	  	$str.='</tbody>';
	  $str.='</table>';
  }
  else
  {
  	$str.='<div class="alert alert-info" role="alert">Пока СМС-сообщения не отправлялись!</div>';
  }


  echo $str;
  
  ?>