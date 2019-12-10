  <?php 
  require_once("functions.php");
 	
 	if (isset($_POST["data"]))
 	{
 		$arr=json_decode($_POST["data"]);
 		$requests=get_all_requests($arr);
 	}
 	else
 	{
 		$requests=get_all_requests();
 	}

 ?>

  <!--Таблица с данными -->
  	<h2 style="margin:0px" class="pull-right"><small>найдено записей:  <?php echo count($requests) ?></small></h2>
          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">                 
                 
                  <div class="x_content">
                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Ф.И.О.</th>
                          <th>Д. р.</th>
                          <th>Класс</th>
                          <th>Курс(ы)</th>                          
                          <th>Контакты</th>
                          <th>Дата</th>                           
                        </tr>
                      </thead>

                      <tbody>
                        <?php  
                          for ($i=0;$i<count($requests);$i++)
                          {
                            ?>
                            <tr>
                              <td>
                              	<span onclick="edit_request_status(this,<?php echo $requests[$i]['id_requests'];?>)" style="cursor:pointer;">
                              		<i class="fa fa-star<?php echo (($requests[$i]['attend'])?'':'-o');?>" style="font-weight:bold;color:<?php echo get_color($requests[$i]['id_request_status']);?>"></i> </span>
                              		<?php echo $requests[$i]['surname'].' '.$requests[$i]['name'].' '.$requests[$i]['patronymic'];?>
                              	
                              </br>
                              <span class="edit_note" onclick=get_data_request("<?php echo $requests[$i]["id_requests"]?>")><i class="fa fa-edit"></i>редактировать</span>
                              </td>
                              
                              <td style="max-width: 100px;"><?php  echo get_time($requests[$i]['birth'],0); ?></td>
                              
                              <td style="max-width: 100px;"><?php echo $requests[$i]['class_number'];?></td>
                              <td>
                                <?php 
                                  $courses=get_all_courses_of_request($requests[$i]['id_requests']);
                                  
                                  for ($n=0;$n<count($courses);$n++)
                                  {
                                     if ($n>0) echo '<br><br>';
                                     echo '<i>'.$courses[$n]['name_of_directions'].'</i><br><b> '.$courses[$n]['name_of_course'].'</b>';
                                  }
                                 ?>
                              </td>
                              
                              <td style="max-width: 200px;">
                                <?php echo '<i>Представитель:</i><br><span class="fa fa-user"></span> '.$requests[$i]['parent']
                                            .'<br><span class="fa fa-envelope-o"></span> '.$requests[$i]['email']
                                            .'<br><span class="fa fa-mobile-phone"></span>  '.$requests[$i]['phone'];

                                if ($requests[$i]['note_of_user']!='')
                                  echo '<br><b><i>Комментарий:</i> '.$requests[$i]['note_of_user'].'</b>';
                                 if ($requests[$i]['note_of_user']!='')
                                  echo '<br><b><i>Комментарий админ-ра:</i> '.$requests[$i]['note'].'</b>';
                                ?>
                                
                              </td>

                              <td style="max-width: 100px;"><?php echo get_time($requests[$i]['date'],0)?></td>
                              
                            </tr>
                            <?php
                          } 

                        ?>
                      </tbody>
                    </table>
                  </div>
                </div><!--x-panel-->
              </div><!--col-lg-->
            </div><!--Таблица с данными END-->

