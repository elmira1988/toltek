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
      include "menu.php"; 
      include "top_navigation.php";  
      $requests=get_all_requests();
      ?>
        <!-- page content -->
         <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Все курсы</h3>
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
                          <th>Наименование курса</th>
                          <th>Описание</th>
                          <th>
                            <span class="fa fa-filter" style="color: inherit; opacity: 0.2; font-size: 12pt; padding-right: 5px;"></span>Категория</th>    
                          <th>
                            <span class="fa fa-filter" style="color: inherit; opacity: 0.2; font-size: 12pt; padding-right: 5px;"></span>
                            Статус
                          </th>                          
                        </tr>
                      </thead>


                      <tbody>
                        <tr>
                          <td>Робототехника</td>
                          <td>Здесь мы будем учиться управлять сложными механизмами.</td>
                          <td>Первая категория курсов</td>
                          <td><b>Создан</b><br>
                            <div class="btn-group" style="color:inherit">
                                 <button type="button" class="btn btn-default btn-xs" style="color:inherit">
                                <i class="fa fa-clock-o"></i></button>
                                <div class="btn-group" style="color:inherit">
                              <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-xs" type="button" aria-expanded="true" style="color:inherit">Статус <span class="caret"></span>
                              </button>
                              <ul role="menu" class="dropdown-menu" style="right: 0;left:auto;">
                                <li><a href="#">Открыть на запись</a>
                                </li>
                                <li><a href="#">Закрыть на запись</a>
                                </li>
                                <li><a href="#">Еще что-то</a>
                                </li>
                              </ul>
                               </div>
                            </div>     
                          </td>    
                        </tr>

                        <tr>
                          <td>Математика ЕГЭ</td>
                          <td>На этих занятиях мы будем готовить уровень В и С</td>
                          <td>Вторая категория курсов</td>
                          <td><b>Создан</b><br>
                            <div class="btn-group" style="color:inherit">
                                 <button type="button" class="btn btn-default btn-xs" style="color:inherit">
                                <i class="fa fa-clock-o"></i></button>
                                <div class="btn-group" style="color:inherit">
                              <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-xs" type="button" aria-expanded="true" style="color:inherit">Статус <span class="caret"></span>
                              </button>
                              <ul role="menu" class="dropdown-menu" style="right: 0;left:auto;">
                                <li><a href="#">Открыть на запись</a>
                                </li>
                                <li><a href="#">Закрыть на запись</a>
                                </li>
                                <li><a href="#">Еще что-то</a>
                                </li>
                              </ul>
                               </div>
                            </div>     
                          </td>    
                        </tr>

                        <tr>
                          <td>Мехатроника</td>
                          <td>Здесь мы будем учиться управлять сложными механизмами.</td>
                          <td>Вторая категория курсов</td>
                          <td><b>Создан</b><br>
                            <div class="btn-group" style="color:inherit">
                                 <button type="button" class="btn btn-default btn-xs" style="color:inherit">
                                <i class="fa fa-clock-o"></i></button>
                                <div class="btn-group" style="color:inherit">
                              <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-xs" type="button" aria-expanded="true" style="color:inherit">Статус <span class="caret"></span>
                              </button>
                              <ul role="menu" class="dropdown-menu" style="right: 0;left:auto;">
                                <li><a href="#">Открыть на запись</a>
                                </li>
                                <li><a href="#">Закрыть на запись</a>
                                </li>
                                <li><a href="#">Еще что-то</a>
                                </li>
                              </ul>
                               </div>
                            </div>     
                          </td>    
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