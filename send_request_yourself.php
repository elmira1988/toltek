<?php 

  session_name('toltek');
  session_start();

  if (isset($_SESSION['id_users']))
  {
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
            <?php
              if (page_status(explode('.php',basename(__FILE__))[0]))
              { ?>
              <!--page-title BEGIN-->
              <div class="page-title">
                <div class="title_left">
                  <h3>Добавить заявку на обучение</h3>
                </div>
              </div>
               <!--page-title END-->
              <div class="clearfix"></div> 
              <?php
                //блок с формой для отправки заявки
                 include "build/blocks/form_of_request.php";
               }
               else
               {
                include("build/blocks/access_is_denied.html"); 
               }
               ?>
          </div> <!-- /page content -->  
    <?php 
      $script="../build/js/send_requist.js";
      include "footer_main.php";
  }
  else 
  {
    header("Location: http://admin.toltekplus.ru/"); 
  } 
   ?>