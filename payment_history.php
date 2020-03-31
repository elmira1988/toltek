<?php 
    session_name('toltek');
    session_start();
    
    if (isset($_SESSION['id_users']))
    {
      include "header_main.php";
      require_once("build/php/functions.php");
 ?>

  <body class="nav-md">
    <input type="hidden" name="role" value="<?php echo $_SESSION['id_roles']; ?>">
    <?php 

      //Окно c росписью плательщика
      include "build/blocks/modal_with_payment_paint_block.html";

      //Окно c историей обучениы
      include "build/blocks/modal_history_of_study.php"; 

      //Окно для списания денежных средств
      include "build/blocks/modal_receiving_block.html"; 
    
      //Окно для отправки смс сообщения
      include "build/blocks/modal_send_sms.php"; 

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
                <h3>История выплат</h3>
              </div>

              <?php 

              if($_SESSION["id_roles"]==1)
              {
                ?>
              <div class="title_right">
                <div class="d-flex justify-content-end">
                  
                  <button type="button" class="btn btn-default" style="color: inherit;" onclick="send_sms('student','data-id-students')"> 
                   <span class="fa fa-envelope-square" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>отправить смс
                  </button>
                
                </div>
                <!--
                <a class="btn btn-app pull-right" id="open-filter">
                  <i class="fa fa-filter"></i> фильтры
                </a>
                  -->
              </div>
                <?php
              }
               ?>
              


            </div>

            <div class="clearfix"></div>

            <?php 
              //блок с фильтрами
               include "build/blocks/filter_payment_history_block.php";
             ?>

             <!--Сама таблица-->
            <div id="table_block" class="dataTables_wrapper form-inline dt-bootstrap no-footer"> 
               <?php 
               if ($_SESSION["id_roles"]==3)
               {
                ?>
                <button id="receiving_button" type="button" class="btn btn-default btn-sm pull-right" onclick="open_receiving_block()">
                <i class="fa fa-check-square-o"></i> списать
              </button>
                <?php
               }
                ?>
               
              
                <!--Таблица с данными -->
                <h2 style="margin:0px" class="pull-right">
                  <small>записей</small> <span id="count_pay"></span>
                  <span id="summa"></span>
                </h2>
                  <!--<i class="fa fa-check"></i> <i class="fa fa-ruble"></i>-->
                <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                        <div class="x_content">
                          <table id="datatable-fixed-header" class="table dataTable table-bordered payments" style="width:100%">
                            <thead>
                              <tr>
                                <th rowspan="2" data-orderable="false" style="width:20px;"><input type="checkbox" id="check-all" class="flat"></th>            
                                <th rowspan="2" style="width:20%;max-width:240px;">Ф.И.О./ Группа/ Курс</th>
                                <th data-orderable="false" style="text-align: center;">Оплачено</th>
                                <th rowspan="2" data-orderable="false" style="text-align: center;width:120px;">Не оплачено</th>
                              </tr>
                              <tr>
                                <th style="padding:0px;border-right: 1px solid #dddddd;" data-orderable="false">
                                  <div class="col-lg-1 col-md-2">Период</div>
                                  <div class="col-lg-1 col-md-2" style="text-align:center;">Сумма</div>
                                  <div class="col-lg-2 col-md-2">Дата оплаты</div>
                                  <div class="col-lg-3 col-md-2">Плат-к</div>
                                  <div class="col-lg-3 col-md-2">Кассир</div>
                                  <div class="col-lg-2 col-md-2">Дата спис-я</div>
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- <tr><td colspan="4"><img src="images/preloader.gif" style="margin-left:45%;"></td></tr> -->
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

            </div>

            <?php 
              
            }//id_user!=4
            else
            {
              //у родителей
              ?>
               <div class="page-title">
                <div class="title_left">
                  <h3>История выплат</h3>
                </div>
               </div>

            <div class="clearfix"></div>
            <div class="info_content">
              <?php
                $parent=get_parents(array("id_parents" => array($_SESSION["id_users"])))[0];
                $students=get_students(array("id_parents" => array($_SESSION["id_users"])));
                $par=get_parents(array("surname"=> array($parent["surname"]),"email" => array($parent["email"])));
                $st=array();
                foreach ($par as $key => $p) {array_push($st,$p["id_parents"]);}
                //поиск у этого родителя еще детей (поиск осуществляется по Фамилии и по по почтовому ящику)
                $students=get_students(array("id_parents" =>$st));

                foreach ($students as $key => $student) {
                ?>
                <br>
                <div class="x_panel">
                  <div class="x_title"><?php echo $student["surname"].' '.$student["name"].' '.$student["patronymic"] ?></div>

                  <div class="x_content">
                    <?php

                    $actual=get_students_group($student["id_students"],"false");
                    $achive=get_students_group($student["id_students"],"true");

                    if ($actual==NULL) { $actual=array();}
                    if ($achive==NULL) { $achive=array();}
                    
                    $students_groups=array_merge($actual,$achive);
                    //print_r($students_groups);
                    if (count($students_groups))
                    {
                      foreach ($students_groups as $key => $group) {
                        $payment=get_payments(array("id_students_groups" => array($group["id_students_groups"]), "achive" => array("All"), "payment" => array("allPay")));
                      //print_r($payment);
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

                      <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                          <p style="text-align: left;"><b>Период обучения/ <br>неоплаченные месяцы</b></p> 
                        </div>
                        <div id="block_with_months" class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="text-align: left;">
                         <?php echo print_months_study_payment($GLOBALS['month_study'],$payment[0]["months_of_study"],$payment[0]["goodmonths"]); ?>
                        </div>
                      </div>
                      <br><br>
                      <div class="row">
                        <div class="col-lg-12 col-md-12 d-sm-none">
                          <table class="table table-hover">
                            <thead>
                              <tr >
                                <th style="text-align: center;">Период</th>
                                <th style="text-align: center;">Сумма</th>
                                <th style="text-align: center;">Дата платежа</th>
                                <th style="text-align: center;">Плательщик</th>                                
                                <th style="text-align: center;">Способ оплаты</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              foreach ($payment[0]["payments"] as $key => $val) {
                                 $parent=get_info_parents($val["id_parents"])[0];//представитель
                                 $date_of_receiving=get_time($val["date_of_receiving"],2);//дата списания платежа
                                 $paymaster=get_paymasters(array("id_users"=>array($val["id_users"])))[0];//кассир
                                 ?>
                                 <tr>
                                  <td id="block_with_months"><?php echo print_months_study_payment(array($val["month"]),$payment[0]["months_of_study"],$payment[0]["goodmonths"]) ?></td>
                                  <td><?php echo $val["amount"]; ?></td>
                                  <td><?php echo $parent['surname'].' '.substr($parent['name'], 0, 2).'. '.substr($parent['patronymic'], 0, 2); ?></td>
                                  <td><?php echo get_time($val["date_of_entry"],2); ?></td>
                                  <td><?php echo (($val["id_users"]==6)?"безналичный":"наличный"); ?></td>
                                </tr> 
                                <?php
                              }
                               ?>
                                                               
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="d-lg-none d-md-none"> 
                        <?php 
                        foreach ($payment[0]["payments"] as $key => $val) {
                                 $parent=get_info_parents($val["id_parents"])[0];//представитель
                                 $date_of_receiving=get_time($val["date_of_receiving"],2);//дата списания платежа
                                 $paymaster=get_paymasters(array("id_users"=>array($val["id_users"])))[0];//кассир
                                 ?>
                                 <div class="row">
                                   <div class="col-sm-4 col-xs-6" style="text-align: left;">Период</div>
                                   <div class="col-sm-8 col-xs-6" id="block_with_months"  style="text-align: left;"><?php echo print_months_study_payment(array($val["month"]),$payment[0]["months_of_study"],$payment[0]["goodmonths"]) ?>                                     
                                   </div>
                                 </div>

                                 <div class="row">
                                   <div class="col-sm-4 col-xs-6" style="text-align: left;">Сумма</div>
                                   <div class="col-sm-8 col-xs-6" style="text-align: left;"><?php echo $val["amount"]; ?></div>
                                 </div>

                                 <div class="row">
                                   <div class="col-sm-4 col-xs-6" style="text-align: left;">Плательщик</div>
                                   <div class="col-sm-8 col-xs-6" style="text-align: left;"><?php echo $parent['surname'].' '.substr($parent['name'], 0, 2).'. '.substr($parent['patronymic'], 0, 2); ?></div>
                                 </div>

                                 <div class="row">
                                   <div class="col-sm-4 col-xs-6" style="text-align: left;">Дата платежа</div>
                                   <div class="col-sm-8 col-xs-6" style="text-align: left;"><?php echo get_time($val["date_of_entry"],2); ?></div>
                                 </div>

                                 <div class="row">
                                   <div class="col-sm-4 col-xs-6" style="text-align: left;">Способ оплаты</div>
                                   <div class="col-sm-8 col-xs-6" style="text-align: left;"><?php echo (($val["id_users"]==6)?"безналичный":"наличный"); ?></div>
                                 </div>

                                 <hr>

                                <?php
                              }
                         ?>
                         
                        </div>
                      <br>
                      <?php
                      }
                    }
                    ?>
                  </div>
                </div>

              <?php
                }//foreach
                ?>
              </div>
                <?php
            }//else у родителей
            }
            else 
            {
              include("build/blocks/access_is_denied.html");
            } ?>
        </div>
        <!-- /page content -->

<?php 
  if ($_SESSION["id_roles"]!=4)
  {
    $script="../build/js/payment_history.js?".rand(5,15);
  }
  
  include "footer_main.php";
}
else {
    header("Location: /"); 
 } ?>