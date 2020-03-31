<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ТОЛТЕК. Отправить заявку</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress 
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">-->
    
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!--PNotify-->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <link href="../build/css/my_dop.css" rel="stylesheet">

  </head>

  <body class="nav-md" style="background: white;">
        <!-- page content -->
  
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background: #005dab; color: white;">

    <h1 style="text-align:center;">Заявка на посещение <?php echo ((isset($_GET['tutor']))?' учебного центра ':' курсов ') ?> в 2019-2020 учебном году</h1>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background: linear-gradient(to top, #ffffff, #005dab);">
   <center> <img src="<?php echo ((isset($_GET['tutor']))?'../images/Tekhnopark_logo.png':'../images/Tekhnopark_logo.png') ?>" style="height:120px"></center>
  </div>

    <?php include("build/blocks/form_of_request.php");?> 
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress 
    <script src="../vendors/nprogress/nprogress.js"></script>-->
    <!-- jQuery Smart Wizard -->
    <script src="../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- jquery.inputmask -->
    <script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script> 
  
    <!-- validator 
    <script src="../vendors/validator/validator.js"></script>-->

    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.js"></script>

    <script src="../vendors/iCheck/icheck.min.js" type="text/javascript"></script>

    <!--PNotify-->
    <script src="../vendors/pnotify/dist/pnotify.js" type="text/javascript"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js" type="text/javascript"></script>

    <!-- Custom Theme Scripts --> 
    <script src="../build/js/custom.js"></script>
    
    <!-- My Scripts -->
    <script src="../build/js/send_requist.js"></script>

    <style text="text/css">

    .actionBar
    {
      text-align: unset;
      border-top: 0px solid #ddd;
    }

    .actionBar .buttonNext.btn.btn-success, .buttonValidate.btn.btn-success
    {
      float: right
    }

    .actionBar .buttonNext.btn.btn-success
    {
      display: none;
    }

    .select_class 
    {
      padding-left: 0px;
    }

    .select_class span
    {
      margin-left: 15px;
      position: relative;
    }

    .select_class div
    {
      display: inline-block;
      margin-bottom: 5px;
    }

    .form-horizontal .checkbox 
    {
      padding-top: 2px;
    }

    .buttonFinish
    {
      float: right;
    }
        
    </style>
  </body>
</html>