 <?php 
    session_name('toltek');
    session_start();
    if (isset($_SESSION['id_users']))
    {
      $css=array("../build/css/all_requist.css");//,"../vendors/bootstrap/dist/css/less/modals.less"
      include "header_main.php";
      require_once("build/php/functions.php");
 ?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php
      include "menu.html"; 
      include "top_navigation.php";  
      $requests=get_all_requests();
      ?>
        <!-- page content -->
         <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Вся нагрузка</h3>
              </div>
              <div class="title_right">
                <button type="button" class="btn btn-default pull-right" style="color: inherit;">
                  <span class="fa fa-file-excel-o" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>экспорт</button>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Преподаватель</th>
                          <th>Группа</th>
                          <th>Кол-во часов</th>         
                        </tr>
                      </thead>


                      <tbody>
                        <tr>
                          <td>Савченко Виктория Степановна</td>
                          <td>Группа 2</td>
                          <td>32</td>
                        </tr>
                       <tr>
                          <td>Михайлов Евгений Викторович</td>
                          <td>Группа 3</td>
                          <td>28</td>
                        </tr>

                        <tr>
                          <td>Ардашова Ольга Владимировна</td>
                          <td>Группа 4</td>
                          <td>22</td>
                        </tr>
                        <tr>
                          <td>Канафина Альмира Маратовна</td>
                          <td>Группа 6</td>
                          <td>12</td>
                        </tr>
                        <tr>
                          <td>Никитина Мария Ильинична</td>
                          <td>Группа 2</td>
                          <td>14</td>
                        </tr>
                        <tr>
                          <td>Петров Иван Сергеевич</td>
                          <td>Группа 3</td>
                          <td>28</td>
                        </tr>
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
  //$script="../build/js/all_requist.js";
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>