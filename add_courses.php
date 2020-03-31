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
                <h3>Добавить курс</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Наименование курса <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Описание
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control" rows="3"></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Категория
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="select2_group form-control">
                            <optgroup label="Категория 1">
                              <option value="Подкатегория 1.1">Подкатегория 1.1</option>
                              <option value="Подкатегория 1.2">Подкатегория 1.2</option>
                            </optgroup>
                            <optgroup label="Категория 2">
                              <option value="Подкатегория 2.1">Подкатегория 2.1</option>
                              <option value="Подкатегория 2.2">Подкатегория 2.2</option>
                              <option value="Подкатегория 2.3">Подкатегория 2.3</option>
                            </optgroup>
                           <optgroup label="Категория 3">
                              <option value="Подкатегория 3.1">Подкатегория 3.1</option>
                              <option value="Подкатегория 3.2">Подкатегория 3.2</option>
                              <option value="Подкатегория 3.3">Подкатегория 3.3</option>
                              <option value="Подкатегория 3.4">Подкатегория 3.4</option>
                            </optgroup>
                          </select>
                           </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						              <button class="btn btn-primary" type="reset">Очистить</button>
                          <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- /page content -->

        <!-- /page content -->

<?php 
  //$script="../build/js/all_requist.js";
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>
