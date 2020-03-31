  <?php 
  require_once("functions.php");
 	
  $arr=json_decode($_POST["data"],true);
  
  $id_roles = $arr["id_roles"][0];
  unset($arr["id_roles"]);

/*  if (count($arr)!=0)
 	{
 	  //print_r($arr); 
 		$students=get_students($arr);
 	}
 	else
 	{
    $students=get_students();
 	}
*/
  $students=get_students($arr);

  //print_r($students);  
 ?>

  <!--Таблица с данными -->
  <h2 style="margin:0px" class="pull-right"><small>найдено записей:  <span id="count_note"></span></small></h2>
  <div class="row">
     <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
     
      <div class="x_content">
        <table id="datatable-fixed-header" class="table "><!--table-striped table-bordered-->
          <thead>
            <tr>
              <th style="width:20px;"><input type="checkbox" id="check-all" class="flat"></th>
              <th style="width:25%">Фамилия И.О.</th>
              <th>Группа</th>
              <th>Контакты</th> 
              <th style="width:25%;">Представители</th>   
              <th style="width:120px;"></th>                           
            </tr>
          </thead>
          <tbody>
            <?php 
            $count=0;

              for ($i=0;$i<count($students);$i++)
              {
                $groups=get_students_group($students[$i]['id_students'],$arr["achive"][0],$arr['id_groups']);
                  //print_r($groups);
                if (count($groups)>0)
                {
                  $count++;
                ?>
              <tr>
                <td><input type="checkbox" name="selected" class="flat"></td>
                <td>
                  <!--Фото-->
                  <div class="left col-lg-3 col-md-12 col-sm-12 col-xs-12 text-center">
                    <?php 
                    if (!($students[$i]['photo']===""))
                    {
                        $src="photo/".$students[$i]['photo'];
                    }
                    else
                    {
                        $src="images/people-icon.png";
                    }
                     ?>
                      <img src="<?php echo $src;?>" alt="" style="max-height:80px;">
                  </div>

                  <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <!--ФИО-->
                    <b>
                     <span id="student" data-id-students="<?php echo  $students[$i]["id_students"]; ?>">
                      <?php echo $name=$students[$i]['surname'].' '.$students[$i]['name'].' '.$students[$i]['patronymic']?>
                     </span>
                    </b>
                    <br>
                    
                      <!--Дата рождения-->
                      <i class="fa fa-calendar"></i> <?php echo  get_time($students[$i]['birth'],1)?>
                      <br>
                      <!--Документ-->
                      <a data-toggle="collapse" href="#doc_student_<?php echo $students[$i]['id_students']?>" aria-expanded="false" aria-controls="doc_student_<?php echo $students[$i]['id_students']?>"><i class="fa fa-file-text-o"></i> документ</a>
                      <div class="collapse" id="doc_student_<?php echo $students[$i]['id_students']?>">
                        <div class="card card-block">
                          <i><?php echo $students[$i]['doc'] ?></i>: 
                          <?php echo ' '.$students[$i]['series'].' '.$students[$i]['number'];
                            if (!($students[$i]['passport_who']===''))
                            { 
                              echo "<br>".get_time($students[$i]['passport_date'],1).', <br>'.$students[$i]['passport_who'];
                            }
                           ?>
                        </div>
                      </div>
                      <br>

                      <!--Класс-->
                      <i class="fa fa-bell"></i> <?php echo $students[$i]['class_number']?> кл.
                    
                  </div>
                </td>
                <td>
                  <!--Группы-->
                  <?php 
                  

                  for ($n=0;$n<count($groups);$n++)
                  {
                    $data=get_groups(array('id_groups'=>array($groups[$n]['id_groups'])));
                    echo '<p><i class="fa fa-child"></i> '.$data[0]['name_of_group'];

                    if($id_roles==1)
                    {
                      if ($arr["achive"][0]=="false")
                      {
                        echo '<button id="add_restore_from_achive" type="button" class="btn btn-default btn-xs pull-right" title="добавить в архив" onclick="modal_add_to_achive(\''.$name.'\','.$groups[$n]["id_students_groups"].')"><i class="fa fa-close"></i>
                            </button>';
                      }
                      else
                      {
                        echo '<button id="add_restore_from_achive" type="button" class="btn btn-default btn-xs pull-right" title="восстановить из архива" onclick="modal_restore_from_achive(\''.$name.'\','.$groups[$n]["id_students_groups"].')"><i class="fa fa-share-square-o"></i>
                            </button>';
                      }
                    }
                    
                    echo '<br>'.$data[0]['name_of_directions']."</p><br>";
                    unset($data);                  
                   ?>
                     
                  <?php } ?>

                   <i><?php echo $students[$i]['note']; ?></i>
                </td>

                <!--Адрес и телефон--> 
                <td><i class="fa fa-building-o"></i> 
                  <?php echo $students[$i]['adress']?><br>
                  <i class="fa fa-mobile-phone"></i>  <?php echo $students[$i]['phone']?>
                </td>

                <!--Представители-->
                <td>
                  <?php 
                  $parents=get_parents(array("id_students" => array($students[$i]['id_students'])));
                  //print_r($parents);
                  for ($n=0;$n<count($parents);$n++)
                  {
                  ?>
                    <!--Родство-->
                    <i class="fa fa-user"></i> <i><?php echo $parents[$n]['kinship'] ?></i>
                    <!--Спойлер-->
                    <a style="color:#C5C7CB"  class="spoiler collapsed" data-toggle="collapse" href="#info_parent_<?php echo $parents[$n]['id_parents']?>" aria-expanded="false" aria-controls="info_parent_<?php echo $parents[$n]['id_parents']?>"></a>
                    <br>
                    <!--Ф.И.О.-->
                     <?php echo $parents[$n]['surname'].' '.$parents[$n]['name'].' '.$parents[$n]['patronymic'];?>
                    <br>
                    <!--Телефон-->
                    <i class='fa fa-mobile-phone'></i> <?php echo $parents[$n]['phone'] ?><br>
                    <!--Email-->
                    <i class='fa fa-envelope-o'></i> <?php echo $parents[$n]['email']?>
                    
                    <!--Подробные данные-->
                    <div class="collapse" id="info_parent_<?php echo $parents[$n]['id_parents']?>" aria-expanded="true">
                        <div class="card card-block">
                          <!--Дата рождения-->
                          <i class="fa fa-calendar"></i> <i>Дата рождения: </i><?php echo  get_time($parents[$n]['birth'],1)?><br>
                          <i class="fa fa-file-text-o"></i> <i>паспорт</i>
                          <!--Паспортные данные-->
                          <?php echo $parents[$n]['series'].' '.$parents[$n]['number']; 
                                echo "<br>".get_time($parents[$n]['passport_date'],1).', <br> '.$parents[$n]['passport_who'];
                          ?>
                          <br>
                          <!--Адрес-->
                          <i class="fa fa-building-o"></i> <?php echo $parents[$n]['adress']?>
                          <br>
                          <!--Место работы-->
                          <?php 
                          if ($parents[$n]['place_of_work']!='')
                          {
                            echo '<i class="fa fa-gavel"></i> '; 
                            echo $parents[$n]['place_of_work'].(($parents[$n]['post']!="")?' ('.$parents[$n]['post'].')':'');
                          }
                           ?> 
                        </div>
                    </div>
                    <br><br>
                   <?php 
                    }
                     ?>
              </td>
              <td>

                <?php 

                if($id_roles==1)
                {
                  ?>

                  <div class="btn-group" style="color:inherit">
                     <button type="button" class="btn btn-primary btn-xs" title="редактировать данные" onclick="get_data_student(<?php echo $students[$i]["id_students"]; ?>)">
                        <i class="fa fa-edit"></i>
                      </button>

                      <button type="button" class="btn btn-success btn-xs" title="добавить в группу" onclick="modal_add_to_groups(<?php echo $students[$i]["id_students"].',\''.$name.'\''; ?>)">  
                        <i class="fa fa-plus"></i>
                      </button>
                </div>
                
                  <?php

                }

                 ?>
                
                

                <div class="btn-group" style="color:inherit">
                      <button type="button" class="btn btn-info btn-xs" title="история обучения" onclick="modal_history(<?php echo $students[$i]["id_students"].',\''.$name.'\''; ?>)"> 
                        <i class="fa fa-clock-o"></i>
                      </button>
                </div>

                <div class="btn-group" >
                      <button type="button" class="btn btn-default btn-xs" style="color:#5cb85c;" title="история СМС-сообщений" onclick="modal_history_sms(<?php echo $students[$i]["id_students"].',\''.$name.'\',\'student\''; ?>)"><i class="fa fa-envelope"></i></button>
                </div>

                <br><br>
                <div class="btn-group">
                  <button  data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle" type="button"> <i class="fa fa-print"></i> Договор <span class="caret"></span> </button>
                  <ul class="dropdown-menu">
                    <?php 
                     for ($n=0;$n<count($parents);$n++)
                      {
                        $name = mb_substr($parents[$n]['name'], 0, 1);
                        $patr = mb_substr($parents[$n]['patronymic'], 0, 1);
                        $name = $parents[$n]['surname'].' '.$name.'. '.$patr;
                        echo "<li onclick='print_contract(".$parents[$n]['id_parents'].",\"".$name."\"".")'><a href='#'>".$name.".</a></li>";
                      }
                     ?>
                </ul>
                </div>
                
              </td>    
            </tr>

            <?php
              }

              }
             ?>                        
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <input type="hidden" name="count_note" value="<?php echo $count ?>">
  </div>
 

