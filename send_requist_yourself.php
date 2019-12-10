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
   include "build/blocks/edit_request_block.html"; 
   ?>

    <div class="container body">
      <div class="main_container">

      <?php
      include "menu.php"; 
      include "top_navigation.php";  
      $requests=get_all_requests();
      ?>

        <!-- page content -->
         <div class="right_col" role="main">
            <!--page-title BEGIN-->
            <div class="page-title">
              <div class="title_left">
                <h3>Заявки на обучение</h3>
              </div>
              <div class="title_right">
                <button type="button" class="btn btn-default pull-right" style="color: inherit;" onclick="export_excel()">
                  <span class="fa fa-file-excel-o" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>экспорт
                </button> 
                <a class="btn btn-app pull-right" id="open-filter">
                  <i class="fa fa-filter"></i> фильтры
                </a>
              </div>
            </div>
             <!--page-title END-->

            <div class="clearfix"></div>
 
            <?php 
              //блок с фильтрами
               include "build/blocks/filter_all_request_block.html";
             ?>

           <div id="table_block"></div>
          
          

        </div> <!-- /page content -->
       

<?php 
  $script="../build/js/all_requist.js";
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>