  <?php 
  require_once("functions.php");
 	
  $arr=json_decode($_POST["data"],true);
  
  if (count($arr)!=0)
 	{
 	  //print_r($arr); 
 		$teachers=get_teachers($arr);
 	}
 	else
 	{
    $teachers=get_teachers();  
 	}

 //print_r($teachers);
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
              <th><i class="fa fa-calendar"></i> Дата рождения</th>
              <th><i class="fa fa-phone"></i> Телефон</th> 
              <th><i class="fa fa-envelope"></i> Email</th>   
              <th><i class="fa fa-building-o"></i> Адрес</th>   
              <th></th>                        
            </tr>
          </thead>
          <tbody>
            <?php 
            $count=0;

              for ($i=0;$i<count($teachers);$i++)
              {$count++;
                ?>
              <tr>
                <td><input type="checkbox" name="selected" class="flat"></td>
                <td>
                  <!--Фото-->
                  <div class="left col-lg-3 col-md-12 col-sm-12 col-xs-12 text-center">
                    <?php 
                    if (!($teachers[$i]['photo']===""))
                    {
                        $src="photo/".$teachers[$i]['photo'];
                    }
                    else
                    {
                        $src="images/Teacher-female-icon.png";
                    }
                     ?>
                      <img src="<?php echo $src;?>" alt="" style="max-height:80px;">
                  </div>

                  <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <!--ФИО-->
                    
                     <span id="teacher" data-id-teacher="<?php echo  $teachers[$i]["id_teachers"]; ?>">
                      <?php echo '<b>'.$name=$teachers[$i]['surname'].' '.$teachers[$i]['name'].' '.$teachers[$i]['patronymic'].'</b>'?>
                     </span>
                    
                     <br><i><?php echo $teachers[$i]['note'] ?></i>
                  </div>
                </td>
                <td>
                <!--Дата рождения-->
                <?php echo  get_time($teachers[$i]['birth'],1)?>
                </td>

                <!--Телефон--> 
                <td>
                <?php echo $teachers[$i]['phone']?>
                </td>

                <!--Email--> 
                <td>
                  <?php echo $teachers[$i]['email']?>
                </td>

                <!--Адрес--> 
                <td>
                  <?php echo $teachers[$i]['adress']?><br>
                </td>
              <td>

                <!-- редактировать данные -->
                <div class="btn-group" style="color:inherit">
                     <button type="button" class="btn btn-primary btn-xs" title="редактировать данные" onclick="get_data_teacher(<?php echo $teachers[$i]["id_teachers"]; ?>)">
                        <i class="fa fa-edit"></i>
                      </button>
                </div>
                
                <!-- история деятельности -->
                <div class="btn-group" style="color:inherit">
                      <button type="button" class="btn btn-info btn-xs" title="история деятельности" onclick="modal_history_teacher(<?php echo $teachers[$i]["id_teachers"].',\''.$name.'\''; ?>)">
                        <i class="fa fa-clock-o"></i>
                      </button>
                </div>

               <!-- история смс сообщений -->
                <div class="btn-group" >
                      <button type="button" class="btn btn-default btn-xs" style="color:#5cb85c;" title="история СМС-сообщений" onclick="modal_history_sms(<?php echo $teachers[$i]["id_teachers"].',\''.$name.'\',\'teacher\''; ?>)">
                        <i class="fa fa-envelope"></i>
                      </button>
                </div>

                <!--добавить или восстановить из архива -->
                <div class="btn-group" >
                  <?php
                  if ($arr["achive"][0]=="false")
                    {
                      echo '<button id="add_restore_from_achive" type="button" class="btn btn-default btn-xs pull-right" title="добавить в архив" onclick="modal_add_to_achive(\''.$name.'\','.$teachers[$i]["id_teachers"].')">
                      <i class="fa fa-close"></i></button>';
                    }
                    else
                    {
                      echo '<button id="add_restore_from_achive" type="button" class="btn btn-default btn-xs pull-right" title="восстановить из архива" onclick="modal_restore_from_achive(\''.$name.'\','.$teachers[$i]["id_teachers"].')"><i class="fa fa-share-square-o"></i>
                          </button>';
                    }
                  ?>
                    
                </div>

              </td>    
            </tr>

            <?php
              }
             ?>                        
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <input type="hidden" name="count_note" value="<?php echo $count ?>">
  </div>
 

