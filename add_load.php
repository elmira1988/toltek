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
                <h3>Добавить нагрузку</h3>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="row">
               <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <br />
                   

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Преподаватель <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <select class="form-control">
                            <option>Ардашова И.К.</option>
                            <option>Баннкиов Р.С.</option>
                            <option>Дмитриев К.Д.</option>
                            <option>Володин А.П.</option>
                            <option>Галицина П.Р.</option>
                            <option>Шарко С.А.</option>
                            <option>Уварова Н.Р.</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Группа <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <select class="form-control">
                            <option>Группа 1</option>
                            <option>Группа 2</option>
                            <option>Группа 3</option>
                            <option>Группа 4</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Количество часов <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <input type="text" id="first-name" required="required" class="form-control">
                        </div>
                      </div>


                  </div>
                </div>
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <button type="submit" class="btn btn-success pull-right">Сохранить</button>
                    <button class="btn btn-primary pull-left" type="reset">Очистить</button>
                    
              </div>
              </form>
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