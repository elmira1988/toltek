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
   <div class="container body">
      <div class="main_container">
        <?php
        include "menu.php"; 
        include "top_navigation.php";  
        ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="page-title">
              <div class="title_left">
                <h3>Посещаемость обучающихся</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 alert alert-warning alert-dismissible" role="alert">
              <p>В разработке!</p>
            </div>
        </div>
        <!-- /page content -->

<?php 
  $script="../build/js/all_students.js";
  include "footer_main.php";
}
else {
    header("Location: /"); 
 } ?>