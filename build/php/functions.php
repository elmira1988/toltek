<?php  
   // Файлы phpmailer
 use PHPMailer\PHPMailer\PHPMailer;
 require 'vendor/autoload.php'; 
 include_once("connection.php");
 include_once("constants.php"); 

    //авторизация
  function authorization_check($login,$password,$id_roles) 
  {
    global $mysqli;
    
    $bool=false;//аторизация прошла безуспешно
    
    //admin,paymasters
    if ($id_roles==1)
    {
      $query='SELECT * FROM (SELECT * FROM  `users` WHERE  `login` =  "'.$login.'") AS t ';
      $query.=' INNER JOIN  `roles_of_users` ON  `roles_of_users`.`id_users` = t.`id_users`';
    }

     //parents
    if ($id_roles==4)
    {
      $query="SELECT `parents`.*, `parents`.`id_parents` AS `id_users`, 4 AS `id_roles`,tt.`pas` AS `password`  FROM (SELECT * FROM (SELECT `parents_key`.*,`parents_log_pas`.`log`,`parents_log_pas`.`pas` FROM `parents_key` INNER JOIN `parents_log_pas` ON `parents_key`.`id_parents_key`=`parents_log_pas`.`id_parents_key`) AS t WHERE `log`='".$login."') AS tt INNER JOIN `parents` ON `parents`.`id_parents`=tt.`id_parents`";
    }
    

    $user=get_raw($query);
    
    if (count($user)==1)
    {
      //если совпадают и пароли
      if (password_verify($password, $user[0]['password']))
      {
        $bool=true;
      }
    }
    
    if ($bool)
    {
      return array('error'=>0,'id_users'=>$user[0]['id_users'], 'name'=>$user[0]['name'], 'id_roles'=>$user[0]['id_roles']);
    }
    else
    {
      return array('error'=>1,'count'=> count($user));
    }

    return $query;
  }

  //вернуть все направления
  function get_all_direction($tutor)
  {
    $query="SELECT * FROM `directions` WHERE `tutor`=".$tutor;
  
    return get_raw($query);
  }

 //печать курсов на запись, читаемых у определенного класса у определенного направления
 function get_courses($id_directions,$class_number)
 {

 	$query="SELECT `courses`.`id_courses`,`courses`.`name_of_course`,`courses`.`description` FROM ";
 		$query.="(SELECT * FROM `courses_and_classis` WHERE `class_number`=".$class_number.") AS t1 INNER JOIN `courses` ON `courses`.`id_courses`=`t1`.`id_courses`WHERE `courses`.open_for_request=1 AND `courses`.`id_directions`=".$id_directions;
 	
 	return get_raw($query);
 }

 function get_price_of_course($id_courses)
 {
  $query="SELECT *  FROM `courses` WHERE `id_courses` = ".$id_courses;
  
  return get_raw($query)[0]["amount"];
 }

 //получаем номера классов у которых читается указанный курс
 function get_class_number_of_course($id_courses) 
 {
  $query="SELECT GROUP_CONCAT(`class_number`) as `class_number` FROM `courses_and_classis` WHERE `id_courses`=".$id_courses;
  
  $res=get_raw($query);
  if (count($res)>0)
  {
    return $res[0]["class_number"]; 
  }
  else
  {
    return "";
  }
 }

 function get_all_class_by_direction($id_directions) 
 {
  $query="SELECT `class_number` FROM `courses_and_classis` WHERE `id_courses` IN (SELECT `id_courses` FROM `courses` WHERE `id_directions`=$id_directions) GROUP BY `class_number` ORDER BY `class_number`";
  return $res=get_raw($query);
 }

  //печать курсов у определенного направления
 function get_courses_of_direction($id_directions)
 {

  $query="SELECT `courses`.`id_courses`,`courses`.`name_of_course`, `courses`.`level`,`courses`.`description` FROM `courses` WHERE `courses`.open_for_request=1 AND `courses`.`id_directions`=".$id_directions." ORDER BY `level` ASC";
  
  return get_raw($query);
 }

 //печать данных по курсу
 function get_courses_info($id_courses,$info) 
 {
  $query="SELECT `courses`.`".$info."` FROM `courses` WHERE `id_courses`=".$id_courses;

  return get_raw($query)[0][$info];
 }

 //возвращаем все группы курса
 function get_groups_of_course($id_courses)
 {
 	$query="SELECT `id_groups` FROM `groups` WHERE `id_courses`=".$id_courses;

 	return get_raw($query);
 }

 //возвращаем расписание группы
 function get_time_table_of_group($id_groups)
 {
 	$query="SELECT * FROM `time_table` WHERE `id_groups`=".$id_groups." ORDER by `day`";

 	return get_raw($query);
  }

  //возвращаем время в расписании в печатном виде
  function get_printable_time($time)
  {
  	settype($time,string);
  	$str=$time;
  	$arr=explode('.',$str);
  	$h=$arr[0];
  	$m=$arr[1];
  	settype($m,integer);
  	if (strlen($arr[1])<2) {$m=$m*10;}
  	return $h."<sup>".($m==0?'00':$m)."</sup>";
  }


  //сохраняем данные в базе и возвращаем id
  //INSERT запрос
  function save_data($query)
  {
    global $mysqli;

    $res=$mysqli->query($query);
    
    if ($res)    
    {
      return $mysqli->insert_id;
    }
    else
    {
      return NULL;
    }

  }

  //$id_request - число, $id_courses - массив
  function save_courses_of_request($id_request,$id_courses) 
  {
    for ($i=0;$i<count($id_courses);$i++)
    {

      $query="INSERT INTO `requests_on_courses` (`id_requests_on_courses`, `id_requests`, `id_courses`) VALUES (NULL,".$id_request.",".$id_courses[$i].")";
      $id_requests_on_courses=save_data($query);

    }

    return $id_requests_on_courses;
  }

  //Сохраняем запись в группу
  function save_selected_time($id_groups,$id_requests_on_courses)
  {
    $arr=explode(",",$id_groups);

    for ($i=0;$i<count($arr);$i++)
    {
       $query="INSERT INTO `selected_time` (`id_selected_time`, `id_groups`, `id_request_on_courses`) VALUES (NULL, '".$arr[$i]."', '".$id_requests_on_courses."');";
        $id_selected_time=save_data($query);
    }
    
    return $id_selected_time;

  }

  //возврщаем все заявки с использованием фильтра или без
  function get_all_requests($arr=array())
  {
        $str='';
    if (count($arr)!=0)
    {
      $str=" WHERE ";
      foreach ($arr as $key => $value)
      {

        if ($str!=" WHERE ") $str.=" AND ";

        $s="";
        foreach ($value as $k => $v) 
        {
          if ($s!="") $s.=",";
          $s.=$v;
        }

        if ($key!="id_courses")
        {
          $str.="`".$key."` IN (".$s.")";
        }
        else
        {
          $str.=" `id_requests` IN (SELECT `id_requests` FROM `requests_on_courses` WHERE `id_courses` IN (".$s."))";
        }

      }         

         if ($str===" WHERE ") $str="";
                                  
    }


    $query="SELECT * FROM  `requests` ".$str."ORDER BY `surname`,`name`,`patronymic`";

    return get_raw($query);
  } 

  //возвращаем количество заявок по фильтру "новая" или "старая"
  function get_count_of_requests($id_courses)
  {
    $str="";
   for ($k=1;$k<=11;$k++)
    {
      $str.=", sum(`requests`.`class_number`=$k) as '".$k."'";
    }

    $query="SELECT sum(`requests`.`attend`=1) AS attend, sum(`requests`.`attend`=0) AS not_attend ".$str." FROM `requests_on_courses` INNER JOIN `requests` ON `requests_on_courses`.`id_requests`=`requests`.`id_requests`  WHERE `requests_on_courses`.`id_courses` = $id_courses";

    return get_raw($query)[0]; 
  }


  //возвращаем все курсы заявки
  function get_all_courses_of_request($id_requests,$directions=array()) 
  {
    $query="SELECT `tt`.`id_courses`,`tt`.`name_of_course`,`dir`.`name_of_directions` FROM ";
      $query.=" (SELECT `courses`.`id_courses`, `courses`.`name_of_course`,`courses`.`id_directions` FROM ";
        $query.=" (SELECT * FROM `requests_on_courses` WHERE `id_requests`=".$id_requests.") AS t INNER JOIN `courses` ON `courses`.`id_courses`=`t`.`id_courses`) AS tt INNER JOIN (SELECT * FROM `directions` ";
            if (count($directions)!=0)
            {
               $query.=" WHERE `id_directions` IN (".implode(",",$directions).")";
            }
           
          $query.=") AS `dir` ON `dir`.`id_directions`=`tt`.`id_directions`";

    return get_raw($query);
  }

  //конвертируем дату 2019-05-11 в 11.05.2019
  function get_time($time,$type) 
  {
    $month=$GLOBALS["month"];

    $date=explode(' ',$time);

    $arr=explode('-',$date[0]);

    $str='';

    if ($arr[0]!='0000') 
        {
          switch ($type) {
              case 0://   2019/09/22
                  $str=$arr[0].'/'.$arr[1].'/'.$arr[2]; 
                  break;
              case 1://   22 сен 2019г<br>02:02:03
                  $str=$arr[2].' '.$month[(integer)$arr[1]].' '.$arr[0].'г.';
                  if (count($date[1])!='') { $str.='<br>'.$date[1];}
                  break;
              case 2://   <div titile="02:02:03">22 сен 2019г</div>
                  $str=$arr[2].' '.$month[(integer)$arr[1]].' '.$arr[0].'г.';
                  if (count($date[1])!='') {$str='<div title="'.$date[1].'">'.$str.'</div>';}
                  break;
              case 3://22 окт. 2019г 
                  $str=$arr[2].' '.$month[(integer)$arr[1]].' '.$arr[0].'г.';     
                  break;
              case 4://22.10.2019
                  $str=$arr[2].'.'.$arr[1].'.'.$arr[0];    
                  break;
              case 5://22.10.2019 12:01
                  $str=$arr[2].'.'.$arr[1].'.'.$arr[0].' '.$date[1];        
                  break;
          }
        }
    
      return $str;
    
  } 

  //возвращаем данные статуса заяки из таблицы `request_status`
  function get_request_status($arr=array())
  {
    $str='';
    if (count($arr)!=0)
    {
      $str=" WHERE ";
      foreach ($arr as $key => $value) {
          if ($str!=" WHERE ") $str.=" AND ";
          $str.="`".$key."` IN (";
          $s="";
          foreach ($value as $k => $v) {
            if ($s!="") $s.=",";
            $s.=$v;
          }
          $str.=$s.") ";
      }

      if ($str===" WHERE ") $str="";
    }

    $query="SELECT * FROM `request_status` ".$str."ORDER BY `id_request_status`";

    return get_raw($query);
    //return $query;
  }

  //возвращаем цвет статуса
  function get_color($id_request_status)
  {
    $request_status=get_request_status(array('id_request_status' => array($id_request_status)));

    return $request_status[0]["color"];
  }

  //редактируем статус заявки
  function edit_request_status($id_requests)
  {
    global $mysqli;

    $id_request_status=get_all_requests(array('id_requests' => array($id_requests)))[0]["id_request_status"];

    $id_request_status+=1;

    if ($id_request_status==4) $id_request_status=1;

    $query="UPDATE  `toltekplus_adminnew`.`requests` SET  `id_request_status` =  '$id_request_status' WHERE  `requests`.`id_requests` =$id_requests";

    if ($mysqli->query($query))
    {
      return $id_request_status;
    }
    else
    {
       return false;
    }
   
  }


  function update_request($data)
  {
    global $mysqli;
    $str='';

    foreach ($data as $key => $value) {

      switch ($key) {
        case 'id_courses':
          break;

        case 'id_requests':
          $where=" WHERE `id_requests`='".$value."'";
          break;  
        
        default:
          if ($str!="") $str.=",";
          $str.="`".$key."`="."'".$value."'";
          break;
      }
    }

    $query="UPDATE `requests` SET ".$str.$where;

    //обновляем данные записи
    if ($mysqli->query($query))
    {
      //Удаляем ненужные курсы
      $query="DELETE FROM `requests_on_courses` WHERE `id_requests` = ".$data['id_requests']." AND `id_courses` NOT IN (".implode(",",$data["id_courses"]).")";

      if ($mysqli->query($query))
      {
          //Добавляяем нужные курсы, не дублируя запись (если такая комбинация есть, то ничего не делаем)
          $str='';
          foreach ($data["id_courses"] as $key => $value) {
            if ($str!="") $str.=",";
            $str.="(".$data["id_requests"].",".$value.")";
          }

          $query="INSERT IGNORE INTO  `requests_on_courses` (`id_requests`, `id_courses`) VALUES ".$str;
          
          if ($mysqli->query($query))
          {
            return true;
            exit();
          }
      }      
    }
      return false;
    
  }

  //Сохраняем ключ заявки
  function save_key($id_requests) 
  {
    global $mysqli;
    $key=md5(md5($id_requests));

    $query="INSERT IGNORE INTO `requests_key` (`id_requests_key`, `id_requests`, `key`, `followed`) VALUES (NULL, '".$id_requests."', '".$key."', '0');";

    return $mysqli->query($query);
  }

  //Возвращаем индентификатор записи по ключу
  function get_requests_key($arr=array())
  {
    $str='';
    if (count($arr)!=0)
    {
      $str=" WHERE ";
      foreach ($arr as $key => $value) {
          if ($str!=" WHERE ") $str.=" AND ";
          $str.="`".$key."` IN (";
          $s="";
          foreach ($value as $k => $v) {
            if ($s!="") $s.=",";
            $s.=$v;
          }
          $str.=$s.") ";
      }

      if ($str===" WHERE ") $str="";
    }

     $query="SELECT * FROM `requests_key` ".$str;
     $res=get_raw($query);
     return $res;  

  }

  //Обновляем данные просмотра статуса заявки
  function update_request_key($id_requests, $followed)
  {
     global $mysqli; 
     $query="UPDATE  `requests_key` SET  `followed` =  '".$followed."' WHERE  `id_requests` =".$id_requests;
     return $mysqli->query($query);
  }

  //печать пробела если это "0"
  function pr_n($n)
  {
    if (($n==0) || ($n==""))
      {
       return ""; 
      }
      else
      {
        return $n;
      }
  }

  //$key = true выводим массив с ключами, совпадающими с id записей
  function get_groups($arr=array(),$key=false)
  {
      $query ="SELECT t.* ,  `directions`.`name_of_directions` ,  `directions`.`tutor`"; 
      $query.="  FROM (";
      $query.=" SELECT  `groups`.* , `courses`.`amount`, `courses`.`name_of_course` , `courses`.`id_directions`,`courses`.`level` ";
      $query.=" FROM  `groups` ";
      $query.=" INNER JOIN  `courses` ON  `courses`.`id_courses` =  `groups`.`id_courses`";
      $query.=" ) AS t";
      $query.=" INNER JOIN  `directions` ON  `directions`.`id_directions` = t.`id_directions`"; 

      if (count($arr)!=0)
      {
        $str="";
        
        if (array_key_exists("id_directions",$arr)) 
        {
          $str.=" t.`id_directions` IN (".implode(",",$arr["id_directions"]).") ";
        }

        if (array_key_exists("id_groups",$arr))
        {
          if ($str!="") $str.=" AND ";
          $str.=" t.`id_groups` IN (".implode(",",$arr["id_groups"]).") ";
        }

        if (array_key_exists("id_courses",$arr))
        {
          if ($str!="") $str.=" AND ";
          $str.=" t.`id_courses` IN (".implode(",",$arr["id_courses"]).") ";
        }


        if ($str!="") $str=" WHERE ".$str;

        $query.=$str; 
      }

      $query.=" ORDER BY `level` "; 
      
      if(!$key)
      {
        return get_raw($query);
      }
      else
      {
        return get_raw_with_id($query,'id_groups');
      }
        
  }


  function update_group($data)
  {
    global $mysqli;
    $str='';

    foreach ($data as $key => $value) {

      switch ($key) {

        case 'id_groups':
          $where=" WHERE `id_groups`='".$value."'";
          break;  
        
        default:
          if ($str!="") $str.=",";
          $str.="`".$key."`="."'".$value."'";
          break;
      }
    }

    $query="UPDATE `groups` SET ".$str.$where;

    //обновляем данные записи
       return $mysqli->query($query);    
    }



 //печать родстенных связей
 function get_kinship($id_kinship=null)
 {
  if ($id_kinship==null)
  {
    $query="SELECT * FROM `kinship`";
    return get_raw($query);
  }
  else
  {
    $query="SELECT * FROM `kinship` WHERE `id_kinship`=".$id_kinship;
    return get_raw($query)[0]["kinship"];
  }
 }


 //печать всех родстенных связей
 function get_type_of_doc($id_type_of_doc=null) 
 {

  $query="SELECT * FROM `type_of_doc`".(($id_type_of_doc!=null)?" WHERE `id_type_of_doc`=".$id_type_of_doc:"");
  
  return get_raw($query);
 }

 //разбить объект на ключ - значение
 function get_array_key_value($obj)
 {
  $array_key=array();
  $array_val=array();

  foreach ($obj as $key => $value) {
      array_push($array_key,"`".$key."`");
      array_push($array_val,"'".$value."'");  
    }

    return array($array_key,$array_val);
 }


 //получаем список студентов согласно фильтру
 function get_students($arr=array())
 {
    $mas=array();
    $achive="All";

    foreach ($arr as $key => $value) {
      $arr=get_array_key_value($value);
      if (count($arr)>0)
        {
          if ($str!="") $str.=" AND ";
          switch ($key) {
            case 'id_groups':
                array_push($mas," `id_students` IN (SELECT `id_students`  FROM `students_groups` WHERE `id_groups` IN (".implode(",",$arr[1])."))");
            break;  
            case 'id_parents':
                array_push($mas," `id_students` IN (SELECT `id_students`  FROM `parents` WHERE `id_parents` IN (".implode(",",$arr[1])."))");
            break;
            case 'achive':
                  if ($value[0]=="true") {$achive=" ";} else {$achive=" NOT ";}
              break;
            default:
                array_push($mas," `".$key."` IN (".implode(",",$arr[1]).")");
              break;
          }
        }
      unset($arr);
    }

      if ($achive!="All") 
        {
          array_push($mas,get_condition_of_achive($achive,'id_students'));
        }

      //вывод записей
      $query="SELECT t.*,`type_of_doc`.`doc` FROM (SELECT * FROM `students` ";
      
      if (count($mas)!=0) 
      {
        $query.=" WHERE ".implode(" AND ",$mas);
      }
      $query.=") AS t ";
        $query.=" INNER JOIN `type_of_doc` ON `type_of_doc`.`id_type_of_doc`=`t`.`type_of_doc` ORDER BY `surname`, `name`"; 

      return get_raw($query);
 }


 function get_students_groups($id_students_groups)
 {
   $query.="SELECT *  FROM `students_groups` WHERE `id_students_groups` = ".$id_students_groups;
   return get_raw($query);
 }

/*
 //получаем список представителей студента
 function get_parents($id_students=null,$id_parents=null)
 {
    $arr=array();  
    
    if ($id_students!=null)   { array_push($arr," `id_students` = $id_students ");}

    if ($id_parents!=null)  { array_push($arr," `id_parents` = $id_parents "); }

    $query="SELECT `t`.*,`kinship`.`kinship` FROM (SELECT *  FROM `parents`".((count($arr))?" WHERE ".implode(" AND ",$arr):"").") AS t INNER JOIN `kinship` ON `kinship`.`id_kinship`=`t`.`id_kinship`";
      return get_raw($query);
 }
*/

 //получаем все группы, в которые ходит студент
  function get_students_group($id_students,$achive="false",$id_groups=array())
  {
    $query="SELECT  `courses`.`id_courses` , $achive AS `achive`, `courses`.`name_of_course` ,  `courses`.`id_directions` , groups . * ";
      $query.=" FROM  `courses` ";
      $query.=" INNER JOIN ( ";
      $query.=" SELECT  t.`id_students_groups`,t.`months_of_study`, `groups`.`id_groups` ,  `groups`.`name_of_group` ,  `groups`.`id_courses` ";
      $query.=" FROM (";
      $query.=" SELECT * ";
      $query.=" FROM  `students_groups`"; 
      $query.=" WHERE  ";
      if (count($id_groups)>0)
      {
        $query.=" `id_groups` IN (".implode(",",$id_groups).")";
        $query.=" AND ";
      }
      
      $query.=" `id_students` =$id_students ";
      $str_achive=" NOT ";
      if ($achive=="true")
      {
        $str_achive=" ";
      }
      $query.=" AND `id_students_groups` ".$str_achive." IN (SELECT `id_students_groups` FROM `history_of_study` WHERE `id_history_of_study` IN (SELECT MAX(`id_history_of_study`) AS `id_history_of_study` FROM `history_of_study` GROUP BY `id_students_groups`) AND `id_study_status`=1)";
      $query.=") AS t ";
      $query.=" INNER JOIN  `groups` ON  `groups`.`id_groups` =  `t`.`id_groups` ";
      $query.=") AS groups ON courses.`id_courses` = groups.`id_courses` ";

  return get_raw($query);
    //return $query;
  }

  //поиск заявки по фамилии обучающегося
  function find_request($surname) 
  {

    $query="SELECT t.*,`request_status`.`color` FROM (SELECT * FROM  `requests` WHERE  `surname` LIKE  '%".$surname."%') AS t ";
      $query.=" INNER JOIN `request_status` ON `request_status`.`id_request_status`=`t`.`id_request_status`";

    return get_raw($query);

  }

  //получаем данные родителя и ребенка
  function get_info_parents($id_parents)
  {
      $query="SELECT * FROM `parents` WHERE `id_parents`=$id_parents";

      return get_raw($query);
  }

  //врзращаем строку типа 'key_1'='value_1','key_2'='value_2','key_3'='value_3',
  //$mas - ассоциативный массив
  function get_set_string($mas, $exceptions) 
  {
    $arr=get_array_key_value($mas); 

    $set="";
    for ($i=0;$i<count($arr[0]);$i++)
    {
      if (!in_array($arr[0][$i],$exceptions)) 
      {
        if ($set!="") $set.=", ";
      $set.=$arr[0][$i]." = ".$arr[1][$i];
      }
      
    }

    return $set;

  }


function get_name_of_direction($id_directions)
{
  $query='SELECT *  FROM `directions` WHERE `id_directions` = '.$id_directions;

  return $res=get_raw($query)[0]["name_of_directions"];
}
 
   //поиск студента по фамилии 
  function find_student($surname) 
  {

    $query="SELECT * FROM (SELECT st.*,`groups`.`name_of_group`,`groups`.`id_courses`  FROM ";
      $query.=" (SELECT `students_groups`.`id_groups`,`students_groups`.`id_students_groups`,`s`.* FROM `students_groups`  INNER JOIN ";
      $query.=" (SELECT * FROM `students`  WHERE  `surname` LIKE  '%".$surname."%%') AS s ON ";
        $query.=" `students_groups`.`id_students`=`s`.`id_students`) AS st ";
          $query.=" INNER JOIN `groups` ON `groups`.`id_groups`=`st`.`id_groups`) AS st_gr ";
            $query.=" INNER JOIN `courses` ON `courses`.`id_courses`=`st_gr`.`id_courses`";
              $query.=" WHERE ".get_condition_of_achive(" NOT ","id_students_groups");

    //$query="SELECT * FROM  `students` WHERE  `surname` LIKE  '%".$surname."%'";

    return get_raw($query);

  }

  //поиск родителя/ представителя по фамилии
  function find_parent($id_students_groups)   
  {
    
    if ($id_students_groups)
    {
      $query="SELECT * FROM `parents` WHERE `id_students` IN (SELECT `id_students` FROM `students_groups` WHERE `id_students_groups`=$id_students_groups)";

      return get_raw($query); 
    }
    else
    {
      return [];
    }
    
  }


 //получаем список кассиров
 //$key=true - вывод массива с ключом, совпадающим с id записи
 function get_paymasters($arr=array(),$key=false)
 {
    $str='';
    
    foreach ($arr as $key => $value) {
      $arr=get_array_key_value($value);
      if (count($arr)>0)
        {
          if ($str!="") $str.=" AND ";
          switch ($key) {
            case 'id_users':
                  $str.=" `id_users` IN (".implode(",",$arr[1]).") ";
              break;  
            
            default:
                //$str.=" `".$key."` IN (".implode(",",$arr[1]).")";
              break;
          }
        }
      unset($arr);
    }  

    if ($str!="") {$str=" AND ".$str;};
    //2 - кассир, 5 - Робокасса
    $query="SELECT `users`.`id_users`,`users`.`surname`, `users`.`name`, `users`.`patronymic` FROM `users` WHERE `id_users` IN (SELECT `id_users` FROM `roles_of_users` WHERE `id_roles` IN (2,5) ".$str.") ORDER BY `surname`";
    
    if(!$key)
    {
      return get_raw($query); 
    }
    else
    {
      return get_raw_with_id($query,'id_users'); 
    }
    
    
 }


 //получаем все выплаты
 //$count_raw необходимость выводить общее количество строк
 function get_payments($arr=array(),$count_raw = false) 
 {
    $str='';
    $students_groups=array(); //массив с условиями (группа, ученик, все ученики определенной группы)
    $notReceiving=array();//массив с условиями (оплачено и списано или оплачено и не списано)
    $month_begin="";
    $month_end="";
    $delete_id=array();//удаляемые элементы 

    $page=1;
    $count_page=$GLOBALS["chunk_size"];

    foreach ($arr as $key => $value) {
      $mas=get_array_key_value($value);
      if (count($mas)>0)
        {
          if ($str!="") $str.=" AND ";
          switch ($key) {
            case 'id_students':
                  array_push($students_groups,'`students_groups`.`id_students` IN ('.implode(",",$mas[1]).')');
              break;
            case 'id_groups':
                  array_push($students_groups," `students_groups`.`id_groups` IN (".implode(",",$mas[1]).") ");
            break;  
            case 'id_students_groups':
                  array_push($students_groups," `students_groups`.`id_students_groups` IN (".implode(",",$mas[1]).") ");
            break;  
            case 'month_begin':
                  $month_begin=$value[0]; 
              break;  
            case 'month_end':
                  $month_end=$value[0];
              break;  
            case 'id_users': 
                 array_push($notReceiving," `payment`.`id_users` IN (".implode(",",$mas[1]).")"); 
              break;
            case 'payment':
                  $paystatus=$value[0]; 
                  switch ($paystatus) {
                    case 'notReceiving':
                       array_push($notReceiving," `payment_detail`.`date_of_receiving`='0000-00-00 00:00:00' "); 
                      break;
                    case 'Receiving':
                       array_push($notReceiving," `payment_detail`.`date_of_receiving`<>'0000-00-00 00:00:00' "); 
                      break;  
                    default:
                      break;
                  }
              break;
            case 'achive':
                  $achive="All";
                  if ($value[0]=="actual") {$achive=" NOT ";} 
                  if ($value[0]=="achive") {$achive=" ";}
              break;

            case 'page':
                  $page=($value[0]-1);
              break;

            default:
              break;
          }
        }
        unset($mas);
    }


    $arrTime=get_months_between($month_begin,$month_end); //возвращаем номера месяцев между $month_begin и $month_end

   //Все, либо без оплаты совсем
   if (in_array($paystatus,array("allPay","notPay"))) 
   {
        //Берем всех обучающихся и "присоединяем" к ним таблицу с оплатой, прописываем все условия по фильтру
       $query="SELECT `main1`.*, `parents`.`id_parents`, `parents`.`email`, `parents`.`phone` FROM (SELECT `main`.*,`students`.`surname`,`students`.`name`,`students`.`patronymic` FROM (SELECT `students_groups`.`id_students_groups`,`students_groups`.`id_students`,`students_groups`.`id_groups`, `students_groups`.`months_of_study`,  p.`goodmonths`, p.`badmonths`  FROM  (SELECT * FROM `students_groups` ".(($achive!="All")?" WHERE ".get_condition_of_achive($achive,'id_students_groups'): "").") AS `students_groups` LEFT JOIN  (SELECT `pay`.`id_students_groups`, GROUP_CONCAT(`pay`.`month`) AS `goodmonths`, '' AS `badmonths` FROM (SELECT `payment_detail`.*, `payment`.`id_students_groups` FROM `payment` INNER JOIN `payment_detail` ON `payment`.`id_payment` = `payment_detail`.`id_payment`) AS `pay`  WHERE `id_payment` NOT IN (SELECT `id_payment` FROM `payment_online` WHERE `result`=0) GROUP BY `id_students_groups`) AS `p` ON  `students_groups`.`id_students_groups`=`p`.`id_students_groups` ".((count($students_groups))?  " WHERE ".implode(" AND ",$students_groups): "").') AS `main` INNER JOIN `students` ON `main`.`id_students`=`students`.`id_students`) AS `main1` INNER JOIN `parents` ON `main1`.`id_students`=`parents`.`id_students`  ORDER BY `main1`.`surname`,`main1`.`name`';

       
       $mas=get_raw($query);  //." LIMIT $start_page,$count_page"
       $count=count($mas);
       for ($i=0;$i<$count;$i++)
        { 
          //badmonths - неоплаченные месяцы 
          $mas[$i]["badmonths"]=implode(",",array_diff(explode(",",$mas[$i]["months_of_study"]),explode(",",$mas[$i]["goodmonths"])));  
          
          //Детализация платежей
          $mas[$i]["payments"]=get_raw("SELECT `payment_detail`.*, `year`,`id_parents`,`id_users`,`paint`,`date_of_entry` FROM `payment` INNER JOIN `payment_detail` ON `payment`.`id_payment` = `payment_detail`.`id_payment` WHERE `id_students_groups`=".$mas[$i]['id_students_groups'].(($mas[$i]["goodmonths"]!='')?" AND `month` IN (".$mas[$i]["goodmonths"].")":"").' AND `payment`.`id_payment` NOT IN (SELECT `id_payment` FROM `payment_online` WHERE `result`=0)');

         if ($mas[$i]["payments"]==NULL) $mas[$i]["payments"]=array();

          //необходимо отобразить только тех обучающихся, которые не опатили обучение
          if ($paystatus=="notPay")
          {
            if ($mas[$i]["badmonths"]=='')//все уплачено, значит, отображать не нужно
            {
              array_push($delete_id,$i);  
            }
            else
            {
              if (count($arrTime)!=0) if (count(array_intersect($arrTime,explode(",",$mas[$i]["badmonths"])))==0) 
              {
                 array_push($delete_id,$i);   
              }
            }
         
          } 
           
        }
        
   }



   //С оплатой (списано или нет)
   if (in_array($paystatus,array("notReceiving","Receiving")))
   { 
      //собираем данные с таблицы по оплате
      $query="SELECT `main1`.*, `parents`.`id_parents`, `parents`.`email`, `parents`.`phone` FROM (SELECT `main`.*,`students`.`surname`,`students`.`name`,`students`.`patronymic` FROM (SELECT p.*, `students_groups`.`id_students` ,`students_groups`.`months_of_study`,`students_groups`.`id_groups` FROM (SELECT `pay`.`id_students_groups`, GROUP_CONCAT(`pay`.`month`) AS `goodmonths`, '' AS `badmonths` FROM  (SELECT `payment_detail`.*, `payment`.`id_students_groups` FROM `payment` INNER JOIN `payment_detail` ON `payment`.`id_payment` = `payment_detail`.`id_payment` ) AS `pay` WHERE `id_payment` NOT IN (SELECT `id_payment` FROM `payment_online` WHERE `result`=0) GROUP BY `id_students_groups`) as p INNER JOIN  (SELECT * FROM `students_groups`".((count($students_groups)) ? " WHERE ".implode(" AND ",$students_groups): "").") AS students_groups ON `p`.`id_students_groups`=`students_groups`.`id_students_groups`)  AS `main` INNER JOIN `students` ON `main`.`id_students`=`students`.`id_students`) AS `main1` INNER JOIN `parents` ON `main1`.`id_students`=`parents`.`id_students`  ORDER BY `main1`.`surname`,`main1`.`name`";
      
      $mas=get_raw($query);  
      //Детализация платежей
       for ($i=0;$i<count($mas);$i++)
        {
          $mas[$i]["badmonths"]=implode(",",array_diff(explode(",",$mas[$i]["months_of_study"]),explode(",",$mas[$i]["goodmonths"])));  
          $mas[$i]["payments"]=get_raw("SELECT `payment_detail`.*, `year`,`id_parents`,`id_users`,`paint`,`date_of_entry` FROM `payment` INNER JOIN `payment_detail` ON `payment`.`id_payment` = `payment_detail`.`id_payment` WHERE `id_students_groups`=".$mas[$i]['id_students_groups']." AND ".implode(" AND ",$notReceiving).(count($arrTime)? " AND `payment_detail`.`month` IN (".implode(",",$arrTime).") ":"").(($mas[$i]["goodmonths"]!='')?" AND `month` IN (".$mas[$i]["goodmonths"].")":"").' AND `payment`.`id_payment` NOT IN (SELECT `id_payment` FROM `payment_online` WHERE `result`=0)');  

          if (count($mas[$i]["payments"])==0) {
            array_push($delete_id,$i);   
          }
 
        }
          
     }

    foreach ($delete_id as $key => $i) { 
      unset($mas[$i]);      
    }

    if ($mas==NULL) $mas=array();
    
    if($count_raw)
    {
      $count_raw =count($mas);// выведет число строк

      $summ = 0;//общая сумма
      foreach ($mas as $key => $v) {
        foreach ($v["payments"] as $k => $pay) {
         $summ+=$pay['amount'];
        }
      }
      $arr['payments']=array_chunk($mas, $count_page)[$page];
      $arr['count_raw']=$count_raw;//общее колчиство записей
      $arr['query']=$query;
      $arr['summ']=$summ;//общая сумма
    }
    else
    {
      $arr=$mas;
    }

    return $arr;  
    
 }


 //возвращаем номера месяцев между ($month_begin,$month_end) 
 function get_months_between($month_begin,$month_end)
 { 
    $n=0;
    $arrTime=array();

    while ($n<9)
    {
      if ($GLOBALS["month_study"][$n]==$month_begin)
      {
       while ($n<9)
        {
          array_push($arrTime,$GLOBALS["month_study"][$n]);
          if ($GLOBALS["month_study"][$n]==$month_end) {$n=9;}
          $n++;
        }
      }
      $n++;
    } 

    return $arrTime;  
 }

 function receiving_money($id_payments)
 {
    global $mysqli;

    $query="UPDATE `payment_detail` SET `date_of_receiving` = '".date("Y-m-d h:m:s")."' WHERE `id_payment` IN (".implode(",",$id_payments).")";
    
    return $mysqli->query($query);
 }


 function get_history_of_study($id_students=false,$id_students_groups=false)
 {
   global $mysqli;

   $arr=array();

   if ($id_students!=false)
   {
    array_push($arr,"`id_students`=".$id_students); 
   }

   if ($id_students_groups!=false)
   {
    array_push($arr,"`id_students_groups`=".$id_students_groups); 
   }

   $str="";
   $str.=implode(" AND ",$arr);
   if ($str!="") $str=" WHERE ".$str;


   $query="SELECT *  FROM `students_groups`".$str; 
    
   $students_groups=get_raw($query);

   foreach ($students_groups as $key => $val) {
     $id_students_groups=$val["id_students_groups"];
     $students_groups[$key]["history"]=get_raw("SELECT * FROM `history_of_study` WHERE `id_students_groups`=".$id_students_groups." ORDER BY `id_history_of_study`");
   }
   return $students_groups; 
 }


 function get_study_status($id_study_status)
 {
   $query="SELECT *  FROM `study_status` WHERE `id_study_status` = ".$id_study_status;

   return get_raw($query)[0]["study_status"];
 }

 //меняем период обучения в группе
 function update_months_of_study($id_students_groups,$months_of_study)
 {
    global $mysqli; 
    $query="UPDATE `students_groups` SET `months_of_study` = '".$months_of_study."' WHERE `id_students_groups` =$id_students_groups";
    return $mysqli->query($query);
 }


 //печать истории обучения в группе
 function print_history_of_students_groups($key,$students_groups)
 {
    $group=get_groups(array('id_groups'=>array($students_groups['id_groups'])))[0];
    $months=$GLOBALS["month_study"];//все учебные месяцы
    $months_of_study=$students_groups["months_of_study"];//период обучения
    $payment_months=$students_groups["payments"];//оплаченные месяцы

    $status="";

    if (count($students_groups["history"])>0) if (end($students_groups["history"])["id_study_status"]==1) $status='id="group_block"';

    $str='<div  '.$status.'class="panel">'; 
       $str.='<a class="panel-heading collapsed" role="tab" id="heading'.$key.'" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$key.'" aria-expanded="true" aria-controls="collapse'.$key.'">';
            
            $str.='<div class="row">';
              $str.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                $str.='<i class="fa fa-child"></i> '.$group['name_of_group'].'<span class="pull-right">'.$group['name_of_directions'].'</span></div>';
            $str.="</div>";

            //Период обучения
            $str.='<div class="row" id="block_with_months">';
              $str.='<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 " style="color:#777;line-height:25px;">период обучения</div>';
              $str.="<div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 '>";
                
                $str.=print_months_study_payment($months,$months_of_study,$payment_months);

                $str.="</div>";
              $str.="</div>";
             $str.='</a>';

           $str.='<div id="collapse'.$key.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$key.'">';
                 $str.='<div class="panel-body" style="padding:0px;">';
                    $str.='<table class="table" style="margin:0px;">
                          <tbody>';

                           $str.='<tr>';
                              $str.='<td title="'.get_time($students_groups["date_add"],1).'" style="cursor:pointer;padding-left:20px;">'.get_time($students_groups["date_add"],2).'</td>';
                              $str.='<td>добавлен в группу</td>';
                              $str.='<td></td>';
                            $str.='</tr>';

                        for ($i=0;$i<count($students_groups["history"]);$i++)
                          {
                            $str.='<tr>';
                              $str.='<td title="'.get_time($students_groups["history"][$i]["date"],1).'" style="cursor:pointer;padding-left:20px;">'.get_time($students_groups["history"][$i]["date"],2).'</td>';
                              $str.='<td>'.get_study_status($students_groups["history"][$i]["id_study_status"]).'</td>';
                              $str.='<td><i>'.$students_groups["history"][$i]["note"].'</i></td>';
                            $str.='</tr>';
                          }
                          $str.='</tbody>
                        </table>';
                  $str.='</div>';
           $str.='</div>';
        $str.='</div>';

  return $str;
 }


//условие для выборки студентов $achive="" - это архивные записи, $achive=" NOT " - это неархивные записи
//Отображаем id_students
 function get_condition_of_achive($achive,$name)
 {
  $condition='`'.$name.'` IN (SELECT `'.$name.'` FROM `students_groups` WHERE `id_students_groups` '.$achive.' IN (SELECT `id_students_groups` FROM `history_of_study` WHERE `id_history_of_study` IN (SELECT MAX(`id_history_of_study`) AS `id_history_of_study` FROM `history_of_study` GROUP BY `id_students_groups`) AND `id_study_status`=1)) ';
  return $condition;
 }


 function print_months_study_payment($months,$months_of_study,$payment_months)
 {

    $str='';

    for ($i=0;$i<count($months);$i++)
    {
        $label='label-non-month';
        $title='';

        if (in_array($months[$i],explode(",",$months_of_study)))
        {
          $label='label-success';
          $title=' оплачено ';

          if (!in_array($months[$i],explode(",",$payment_months)))
          {
            $label.=' label-not-payment '; 
            $title=' не оплачено ';
          }
        }
          $str.="<span class='label ".$label."' title='".$title."'>".$GLOBALS["month"][$months[$i]]."</span> ";
      
    }

    return $str;
 }

 function clear_phone_for_sms($phone)
 {
  $phone=str_replace("(","",$phone);
  $phone=str_replace(")","",$phone);
  $phone=str_replace("-","",$phone);
  $phone=str_replace(" ","",$phone);
  $phone=substr($phone,1);
  return '7'.$phone;
 }


 //получаем историю СМС-сообщений
 function get_history_sms($mas=array(),$type='student')
 {
    $conditions=array();
    
    foreach ($mas as $key => $value) {
      $arr=get_array_key_value($value);
      if (count($arr)>0)
        {
         switch ($key) {
            case 'id_user':
                  array_push($conditions," `id_sms` IN (SELECT `id_sms` FROM `sms__".$type."s` WHERE `id_".$type."s` IN (".implode(",",$arr[1]).")) "); 

              break;  
            case 'months':
                  array_push($conditions," MONTH(date) IN (".implode(",",$arr[1]).") ");
              break;  
            
            default:
              break;
          }
        }
      unset($arr);
    }

    $str='';
    if (count($conditions)>0)
    {
      $str=" WHERE ".implode(" AND ",$conditions);
    }
    
 
    $query="SELECT * FROM `sms` ".$str." ORDER BY `date` DESC";
    return get_raw($query); 
  }

 //получаем список студентов согласно фильтру
 function get_teachers($arr=array())
 {
  
    $mas=array();
    $achive="All";

    foreach ($arr as $key => $value) {
      $arr=get_array_key_value($value);
      if (count($arr)>0)
        {
          if ($str!="") $str.=" AND ";
          switch ($key) {
            case 'achive':
                  if ($value[0]=="true") {$achive=" ";} else {$achive=" NOT ";}
              break;
            default:
                array_push($mas," `".$key."` IN (".implode(",",$arr[1]).")");
              break;
          }
        }
      unset($arr);
    }

    if ($achive!="All") 
      {
        array_push($mas,get_condition_of_achive_teacher($achive,'id_teachers'));
      }

    //вывод записей
    $query="SELECT * FROM `teachers` ";
    
    if (count($mas)!=0) 
    {
      $query.=" WHERE ".implode(" AND ",$mas);
    }

    $query.=" ORDER BY `surname`,`name` ";
    return get_raw($query);
 }


 //формируем запрос для выявления преподавателей работающих и архивных
 function get_condition_of_achive_teacher($achive,$name)
 {
   $query=" `".$name."` ".$achive." IN  (SELECT `".$name."` FROM `teachers__job_status` WHERE `id_teachers__job_status` IN (SELECT MAX(`id_teachers__job_status`) FROM `teachers__job_status` GROUP BY `id_teachers`) AND `id_job_status`=1)";

   return $query;
 }

 //история деятельности преподавателя
  function get_history_of_job($id_teachers)
 {
   $query="SELECT *  FROM `teachers__job_status` WHERE `id_teachers`=".$id_teachers." ORDER BY `id_teachers__job_status` ASC"; 

   return get_raw($query); 
 }

 function get_job_status($id_job_status)
 {
   $query="SELECT `job_status`  FROM `job_status` WHERE `id_job_status`=".$id_job_status; 

   $res=get_raw($query); 

   if (count($res)>0)
    {
      return $res[0]['job_status'];
    }
    else
    {
      return false;
    }
 }

 //возращает статус "открыт" или "закрыт" для просмотра данным пользователем
 function page_status($page)
 {
    $open=false; //по умолчанию доступ к странице закрыт
    $close_page=$GLOBALS["arr"][$_SESSION['id_roles']]["closed"];//массив закрытых страниц для текущего пользователя
    $open_page=$GLOBALS["arr"][$_SESSION['id_roles']]["open"];//массив открытых страниц для текущего пользователя

    //Если все страницы закрыты, кроме как страницы указанные в массиве $open_page, причем наша текущая страница там есть, то доступ открываем
    if (count($close_page)==0) if ((count($open_page)!=0) && (in_array($page,$open_page))) {$open=true;}

    //Если все страницы открыты, кроме как страницы указанные в массиве $close_page, причем нашей текущей страницы там нет, то доступ открываем
    if (count($open_page)==0) if ((count($close_page)!=0) && (!in_array($page,$close_page))) {$open=true;}

    return $open;
 }


 //отправка письма
 function send_mail($email,$header,$text,$file=false,$img = array())
 {
  // Настройки
  $mail = new PHPMailer;

  $mail->isSMTP(); 
  $mail->SMTPDebug = 0;
  $mail->Host = 'smtp.jino.ru'; 
  $mail->SMTPAuth = true; 
  $mail->Username = 'no-reply@toltekplus.ru';
  $mail->Password = '$nep8JdrZYwr'; // Ваш пароль  
  $mail->CharSet = 'UTF-8';
  $mail->SMTPSecure = 'ssl'; 
  $mail->Port = 465;   
   
  $mail->SMTPKeepAlive = true;   
  $mail->Mailer = "smtp"; // don't change the quotes!

  $mail->setFrom('no-reply@toltekplus.ru'); // Ваш Email
  $mail->addAddress($email);//Email получателя 
  $mail->isHTML(true); 
  $mail->Subject = $header; // Заголовок письма
  $mail->Body = $text;//Текст письма
  if($file)
    {
      $mail->AddAttachment($file); // pdf file path
    }

  if(count($img)>0)  
  {
    $mail->AddEmbeddedImage($img['filename'], $img['my-attach'], $img['name']);
  }
 
  if (!$mail->send())  
  {
    return array("result" => "error","msg" => $mail->ErrorInfo);
  } 
  else 
  { 
    return array("result" => "ok","msg" => 'Письмо успешно отправлено');
  } 
 }


 //возвращаем данные таблицы parents_key
 function get_data_parents_key($arr)
 {
    $mas=array();

      foreach ($arr as $key => $value) {
      $arr=get_array_key_value($value);
      if (count($arr)>0)
        {
          array_push($mas," `".$key."` IN (".implode(",",$arr[1]).")");
        }
      unset($arr);
    }

    $query="SELECT * FROM `parents_key` ".((count($mas))?" WHERE ".implode(" AND ",$mas):"");

    return get_raw($query);
 }

 //создан ли были ранее логин и пароль пользователю id_parents
 function has_log_pas($key)
 {
  $query="SELECT * FROM `parents_log_pas` WHERE `id_parents_key` IN ";
    $query.=" (SELECT `id_parents_key` FROM `parents_key` WHERE `key` LIKE '".$key."')";
  $res=get_raw($query);

  if ($res)
  {
    return $res[0]["id_parents_log_pas"];
  } 
  else
  {
    return 0;
  }

 }


  //получаем список родителей согласно фильтру
 function get_parents($arr=array())
 {
    $mas=array();

    foreach ($arr as $key => $value) {
      $arr=get_array_key_value($value);
      if (count($arr)>0)
        {
          array_push($mas," `".$key."` IN (".implode(",",$arr[1]).")");
        }
      unset($arr);
    }

    //вывод записей
    return get_raw("SELECT * FROM `parents` ".((count($mas))?" WHERE ".implode(" AND ",$mas):""));
 }

  function file_get_contents_curl($url,$post_data)
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    //Устанавливаем параметр, чтобы curl возвращал данные, вместо того, чтобы выводить их в браузер.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    // указываем, что у нас POST запрос
    curl_setopt($ch, CURLOPT_POST, 1);
    // добавляем переменные
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
  }
 
 //Возращаем текущие настройки
 function get_settings()
 {
   return get_raw("SELECT * FROM `settings`")[0];
 }


 function save_payment($data)
 {
    $amount=$data["amount"];
    unset($data["amount"]); 
    $month_begin=$data["month_begin"];
    $month_end=$data["month_end"];
    unset($data["month_begin"]);
    unset($data["month_end"]);
    unset($data["email"]);

    $fileName="''";

    if (isset($data["paint"]))
    {
      //Сохраняем роспись
      $paint=$data["paint"];
      list($type, $paint) = explode(';', $paint);
      list(, $paint)      = explode(',', $paint);
      $paint = base64_decode($paint);
      $fileName=time();

      $handle = fopen($_SERVER['DOCUMENT_ROOT']."/paint/".$fileName.".png", "w");
      fwrite($handle,$paint);
      fclose($handle); 
      unset($data["paint"]);

      $fileName="'".$fileName.".png'";
    }
    
    $arr=get_array_key_value($data);  

    array_push($arr[0],"`paint`");
    array_push($arr[1],$fileName);

    array_push($arr[0],"`year`");
    array_push($arr[1],"'".$GLOBALS["year"]."'");

    if ($_SESSION["id_roles"]!=4)
    {
      array_push($arr[0],"`id_users`");
      array_push($arr[1],"'".$_SESSION["id_users"]."'");
    }
    else
    {
      
      array_push($arr[0],"`id_users`");
      array_push($arr[1],"'6'");//Робокасса
      
    }
    
     
    $query="INSERT INTO `payment` (".implode(",",$arr[0]).") VALUES (".implode(",",$arr[1]).")";


    //сохранеяем данные 
    if ($id_payment=save_data($query)) 
    {
      $months=get_months_between($month_begin,$month_end);
      $amount=$amount/count($months);

      $id_payment_detail=0;
      foreach ($months as $key => $month) {
        $query="INSERT INTO `payment_detail` (`id_payment_detail`, `id_payment`, `month`, `amount`) VALUES (NULL, '$id_payment', '$month', '$amount')";
        $id_payment_detail=save_data($query);
      }

      if ($id_payment_detail) { return $id_payment;} else {return false;}
    }
    else
    {
      return false;
    }
    
 }


 function get_inic($surname,$name,$patronymic)
 {
  return $surname.' '.(($name!='')?substr($name, 0, 2).'. ':"").(($name!='')?substr($patronymic, 0, 2).'.':"");
 }


 function get_orderid($id_payment)
 {
  $query="SELECT `orderId` FROM `payment_online` WHERE `id_payment`='".$id_payment."'";

  $res=get_raw($query);

  if ($res)
  {
    return $res[0]["orderId"];
  }
  else
  {
    return false;
  }

 }
?>