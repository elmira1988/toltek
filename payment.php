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
        <div class="right_col" role="main" style="opacity:0;">
            
            <div class="page-title">
              <div class="title_left">
                <h3>Оплата</h3>
              </div>
            </div>

            <div class="clearfix"></div>
            
            <div class="row">
                <div class="col-md-12 col-xs-12">
                  <div class="x_panel">
                    <div id="payment_block" class="x_content">
                        
                        <div class="row">
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12" >
                            <label>Ф.И.О. обучающегося/ Группа/ Курс</label>
                            <input type="hidden" name="id_students_groups">
                            <input type="text" id="find_student" class="form-control" name="" autocomplete="off" placeholder="Введите фамилию ...">
                          </div>

                          <div class="form-group col-lg-4 col-md-12 col-sm-6 col-xs-12">
                            <label>Период</label> 
                            <input type="text" id="date" readonly class="form-control" style="cursor:pointer;">
                          </div>

                          <div class="form-group col-lg-2 col-md-12 col-sm-6 col-xs-12">
                            <label>Сумма</label> 
                            <input id="price" type="tel" class="form-control" placeholder="0" readonly="readonly" style="cursor: no-drop"> 
                          </div>

                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Ф.И.О. плательщика</label> 
                            <input type="hidden" name="id_parents">
                            <input type="text" id="find_parent" name="parent" readonly="readonly" class="form-control" autocomplete="off" placeholder="Введите фамилию ...">
                          </div>

                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Комментарий</label> 
                            <input type="text" name="note" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        

                        
                        <div id="painting" class="row" style="opacity:0;margin-top:20px;"> 
                          <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12"> 
                            <button class="btn btn-sm btn-default pull-right" type="button" onclick="clearCanvas()" style="display:block;margin-right:0px;">
                              <i class="fa fa-eraser"></i> очистить
                            </button> 

                             <canvas id="myCanvas" height="400">
                                Ваш браузер не поддерживает Canvas
                            </canvas>
                          </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button id="payment_btn" class="btn btn-md btn-success pull-right" onclick="payment(this)">принять оплату</button>
                          </div>
                        </div>

                  </div>
                </div>
              </div>

          </div>
        </div>
        <!-- /page content -->

<?php 
  $script="../build/js/payment.js?11";
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>