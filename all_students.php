<?php 
    session_name('toltek');
    session_start();

    if (isset($_SESSION['id_users']))
    {
      //$css=array("../build/css/all_requist.css");//,"../vendors/bootstrap/dist/css/less/modals.less"
      include "header_main.php";
      require_once("build/php/functions.php");
 ?>

  <body class="nav-md">
  <?php 
    if ($_SESSION["id_roles"]!=4)
    {
      //Окно для редактирования записи
      include "build/blocks/edit_student_block.html";

      //Окно c историей обучениы
      include "build/blocks/modal_history.php"; 

      //Окно для добавления в группу
      include "build/blocks/modal_add_to_group.php"; 

      //Окно для переноса в архив
      include "build/blocks/modal_add_to_achive.php"; 

      //Окно для восстановления из архива
      include "build/blocks/modal_restore_from_achive.php"; 

      //Окно для отправки смс сообщения
      include "build/blocks/modal_send_sms.php"; 
      
      //Окно для отображения истории смс сообщений
      include "build/blocks/modal_history_sms.php"; 

      //Окно для выбора пользователей, которым нужно отправить письмо на email 
      //с ключом доступа для создания логина и пароля
      include "build/blocks/modal_send_email_with_access_to_acoount.php"; 
    }

   ?>   

    <div class="container body">
      <div class="main_container">
        <?php
        include "menu.php"; 
        include "top_navigation.php";  
        ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <?php
          if (page_status(explode('.php',basename(__FILE__))[0]))
          { 
            if ($_SESSION["id_roles"]!=4)
            {
            ?>
            <div class="page-title">

              <div class="title_left">
                <h3>Все обучающиеся</h3>
              </div>

              <div class="title_right">
                <div class="d-flex justify-content-end">
                   
                   <?php 

                    if($_SESSION["id_roles"]==1)
                    {

                      ?>
                      <button id="access_to_account" type="button" class="btn btn-default" style="color: inherit;" onclick="access_to_account()">  
                       <span class="fa fa-user" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>доступ к ЛК
                      </button>

                      <button type="button" class="btn btn-default" style="color: inherit;" onclick="send_sms('student','data-id-students')">  
                       <span class="fa fa-envelope-square" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>отправить смс
                      </button>
                      <?php
                    }
                    ?>
                  <button type="button" class="btn btn-default" style="color: inherit;" onclick="export_excel()">
                   <span class="fa fa-file-excel-o" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>экспорт
                  </button>
                
                </div>
              </div>

            </div>
            <div id="filter-block" class="row" style="display: block"> 
              <input type="hidden" name="id_roles" value="<?php echo $_SESSION["id_roles"]?>">
            <?php 

              //блок с фильтрами
               include "build/blocks/filter_all_student_block.php";
             ?>
            </div> <!--filter-block-->
              <div class="clearfix"></div>
             <!--Сама таблица-->
              <div id="table_block">
              <img src="images/preloader.gif" style="margin-left:45%;">
              </div>

          <?php 
            }
            else
            {
              
                //родителям
                $parent=get_parents(array("id_parents" => array($_SESSION["id_users"])))[0];
                $students=get_students(array("id_parents" => array($_SESSION["id_users"])));
                $par=get_parents(array("surname"=> array($parent["surname"]),"email" => array($parent["email"])));
                $st=array();
                foreach ($par as $key => $p) {array_push($st,$p["id_parents"]);}
                //поиск у этого родителя еще детей (поиск осуществляется по Фамилии и по по почтовому ящику)
                $students=get_students(array("id_parents" =>$st));

                //print_r($students);
                if (count($students))
                  {
                  ?>
                    <div class="page-title">
                      <div class="title_left" >
                        <h3>Обучающиеся</h3>
                      </div>
                    </div>

                    <div class="info_content">
                    <?php
                      foreach ($students as $key => $student) {
                      ?>
                      <br>
                      <div class="x_panel">
                        <div class="x_title">Данные ребенка</div>

                        <div class="x_content">
                          <!--photo-block-->
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <div id="photo_block">
                                <div id="myphoto">
                                  <img src="<?php if ($student["photo"]=="") { echo "images/people-icon.png";} else { echo $student["photo"];}?>"  class="img-responsive">
                                </div>
                              </div>
                            </div><!--photo-block-->

                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                              <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" required="required" name="surname" readonly="readonly" placeholder="Фамилия" value="<?php echo $student["surname"]; ?>">
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left" required="required" name="name" readonly="readonly" placeholder="Имя" value="<?php echo $student["name"]; ?>">
                                  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left" name="patronymic" placeholder="Отчество"  readonly="readonly" value="<?php echo $student["patronymic"]; ?>">
                                  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                  <input type="date" class="date form-control has-feedback-left" name="birth" required="required" readonly="readonly" placeholder="Дата рождения" style="padding-right: 5px;" value="<?php echo $student["birth"]; ?>">
                                  <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group">
                                    <input class="form-control" type="text" readonly="readonly" value="<?php echo $student["class_number"]." класс"; ?>">
                                </div>
                              </div>
                        
                              <p style="text-align: left;margin:0px">
                                <small><?php echo $student["doc"];?></small>
                              </p>
                          
                              <div class="row">
                               <!--Серия-->
                                <div class="type_1 col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group">
                                    <input type="text" class=" form-control" name="series" value="<?php echo $student["series"];?>">
                                </div>
                                <!--Номер-->
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group" >
                                  <input type="text" class="form-control" name="number" value="<?php echo $student["number"];?>">
                                </div> 

                                <?php 
                                if ($student["type_of_doc"]==2)
                                {
                                  ?>
                                  <!--Дата выдачи паспорта и кем выдан-->
                                <div class="type_2 display_none col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group">
                                    <input type="date" class="date form-control has-feedback-left" value="<?php echo $student["passport_date"];?>">
                                    <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                </div> 

                                <div class="type_2 display_none col-lg-8 col-md-6 col-sm-6 col-xs-12 form-group">
                                    <input type="text" class=" form-control " value="<?php echo $student["passport_who"];?>">
                                </div>
                                  <?php
                                }
                                 ?>
                              </div>
                      
                              <div class="row">
                              <!--Телефон-->
                              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" value="<?php echo $student["phone"];?>">
                                <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                              </div>

                              <!--Адрес-->
                               <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" value="<?php echo $student["adress"];?>">
                                <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                              </div>
                              </div>
                        </div><!-- right from photo-->
                    </div><!-- x -content -->
                  </div><!-- x-panel-->
                  <?php 
                    $parent=get_parents(array("id_parents" => array($_SESSION["id_users"])))[0];
                  ?>                 

                  <div class="x_panel">
                    <div class="x_title">Данные представителя</div>
                      
                      <div class="x_content">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" style="padding-right: 3px;" value="<?php echo $parent["surname"]; ?>">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" style="padding-right: 3px;" value="<?php echo $parent["name"]; ?>">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" style="padding-right: 3px;" value="<?php echo $parent["patronymic"]; ?>">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <!--Родственные связи (представитель)-->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" value="<?php echo get_kinship($parent["id_kinship"]);?>"/>
                        </div>

                        <!--Дата рождения (представитель)-->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback item form-group"> 
                           <input type="date" class="date form-control has-feedback-left" value="<?php echo get_kinship($parent["birth"]);?>">
                            <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" value="<?php echo $parent["phone"]; ?>">
                          <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left"  name="email" value="<?php echo $parent["email"]; ?>">
                          <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        </div>

                           <!--Адрес (представитель)-->
                        <div class="col-lg-8 col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control has-feedback-left" value="<?php echo $parent["adress"]; ?>">
                          <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      

                      <p class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: left">
                        <small>Паспортные данные</small>
                      </p>
                      <div class="row">
                        <!--Серия и номер паспорта (представитель)-->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback item form-group"> 
                          <input type="text" class="form-control" value="<?php echo $parent["series"].' '.$parent["number"]; ?>">
                        </div>

                        <!--Дата выдачи паспорта (представитель)-->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group has-feedback item form-group"> 
                           <input type="date" class="date form-control has-feedback-left"  value="<?php echo $parent["passport_date"]; ?>">
                            <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>              
                        </div>

                        <!--Кем выдан паспорт (представитель)-->
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                          <input type="text" class="form-control" value="<?php echo $parent["passport_who"]; ?>">
                        </div>
                      </div>
                     
                      <div class="row">
                          <!--Место работы (представитель)-->
                          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" value="<?php echo $parent["place_of_work"]; ?>">
                            <span class="fa fa-gavel form-control-feedback left" aria-hidden="true"></span>
                          </div>

                          <!--Должность (представитель)-->
                          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" value="<?php echo $parent["post"]; ?>">
                            <span class="fa fa-gavel form-control-feedback left" aria-hidden="true"></span>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="x_panel">
                    <div class="x_title">Курсы</div>
                      <div class="x_content">
                        <?php 
                        $actual=get_students_group($student["id_students"],"false");
                        $achive=get_students_group($student["id_students"],"true");
                        if ($actual==NULL) {$actual=array();}
                        if ($achive==NULL) {$achive=array();}
                        
                        $students_groups=array_merge($actual,$achive);

                        if (count($students_groups))
                        {
                          foreach ($students_groups as $key => $group) {
                          ?>
                          <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <p style="text-align: left;"><b>Направление</b></p> 
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                              <p style="text-align: left;"><?php echo $group["name_of_course"]; ?></p>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <p style="text-align: left;"><b>Группа</b></p> 
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                              <p style="text-align: left;"><?php echo $group["name_of_group"]; ?></p>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <p style="text-align: left;"><b>Статус</b></p> 
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                              <p style="text-align: left;">
                                <?php if ($group["achive"]==0) { echo "зачислен";}
                                else {
                                  echo "отчислен";
                                } ?></p>
                            </div>
                          </div>
                          <br>
                          <?php
                          }
                        }
                        ?>
                      </div>
                  </div>

                  <br><br>
               <?php
              }//foreach
              ?>
            </div><!-- info - content -->
              <?php
            }//если массив students Не пустой
           }//родителям

        }
          else
          {
            include("build/blocks/access_is_denied.html"); 
          } ?>
        </div>
        <!-- /page content -->

<?php 
  $script="../build/js/all_students.js";
  include "footer_main.php";
}
else {
    header("Location: /"); 
 } ?>