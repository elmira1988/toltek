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
   //Modal Модальное окно для редактирования группы
   include "build/blocks/edit_group_block.html"; 

   //Modal Модальное окно для вывода состава группы
   include "build/blocks/modal_group_structure.php"; 
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
                <h3>Все группы</h3>
              </div>
              <div class="title_right">
                <button type="button" class="btn btn-default pull-right" style="color: inherit;" onclick="export_excel()">
                  <span class="fa fa-file-excel-o" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>экспорт</button>
                  <a class="btn btn-app pull-right" id="open-filter">
                  <i class="fa fa-filter"></i> фильтры
                </a>
              </div>
            </div>


            <div class="clearfix"></div>

            <?php 
              //блок с фильтрами
               include "build/blocks/filter_all_group_block.php";
             ?>

           <div id="table_block"></div>
           <?php
           }
           else
           {
            include("build/blocks/access_is_denied.html"); 
           } 
            ?>
        </div>
        <!-- /page content -->

<?php 
 $script="../build/js/all_groups.js";
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>