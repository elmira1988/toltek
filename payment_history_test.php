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
            <div class="page-title">

              <div class="title_left">
                <h3>История выплат</h3>
              </div>

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

            </div>

            <div class="clearfix"></div>

            <?php 
              //блок с фильтрами
               include "build/blocks/filter_payment_history_block.php";
             ?>

             <!--Сама таблица-->
            <div id="table_block">
              
                <!--Таблица с данными -->
                <h2 style="margin:0px" class="pull-right">
                  <small>записей</small> <span id="count_pay"><?php echo count($payments) ?></span>
                  <span id="summa"></span></h2>
                  <!--<i class="fa fa-check"></i> <i class="fa fa-ruble"></i>-->
                <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                        <div class="x_content">
                          <table id="datatable-fixed-header" class="table table-bordered payments" style="width:100%">
                            <thead>
                              <tr>
                                <th rowspan="2" data-orderable="false" style="width:20px;"><input type="checkbox" id="check-all" class="flat"></th>            
                                <th rowspan="2" style="width:20%;max-width:240px;">Ф.И.О./ Группа/ Курс</th>
                                <th data-orderable="false" style="text-align: center;">Оплачено</th>
                                <th rowspan="2" data-orderable="false" style="text-align: center;width:120px;">Не оплачено</th>
                              </tr>
                              <tr>
                                <th style="padding:0px;border-right: 1px solid #dddddd;" data-orderable="false">
                                  <div class="col-lg-2 col-md-2">Период</div>
                                  <div class="col-lg-2 col-md-2" style="text-align:center;">Сумма (руб.)</div>
                                  <div class="col-lg-2 col-md-2">Плательщик</div>
                                  <div class="col-lg-2 col-md-2">Дата оплаты</div>
                                  <div class="col-lg-2 col-md-2">Кассир</div>
                                  <div class="col-lg-2 col-md-2">Дата списания</div>
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr><td colspan="4"><img src="images/preloader.gif" style="margin-left:45%;"></td></tr>
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

            </div>
        </div>
        <!-- /page content -->

<?php 
  $script="../build/js/payment_history_test.js?".rand(5,15);
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>