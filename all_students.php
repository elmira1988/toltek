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
          { ?>
            <div class="page-title">

              <div class="title_left">
                <h3>Все обучающиеся</h3>
              </div>

              <div class="title_right">
                <div class="d-flex justify-content-end">
                  
                  <button type="button" class="btn btn-default" style="color: inherit;" onclick="send_sms('student','data-id-students')">  
                   <span class="fa fa-envelope-square" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>отправить смс
                  </button>

                  <button type="button" class="btn btn-default" style="color: inherit;" onclick="export_excel()">
                   <span class="fa fa-file-excel-o" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>экспорт
                  </button>
                
                </div>
                
                <!--
                <a class="btn btn-app pull-right" id="open-filter">
                  <i class="fa fa-filter"></i> фильтры
                </a>
                -->
              </div>

            </div>

            
            <?php 
              //блок с фильтрами
               include "build/blocks/filter_all_student_block.php";
             ?>
          
              <div class="clearfix"></div>

            

             <!--Сама таблица-->
            <div id="table_block">
            <img src="images/preloader.gif" style="margin-left:45%;">
            </div>

          <?php }
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
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>