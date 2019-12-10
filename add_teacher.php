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
        $requests=get_all_requests();
        ?>

        <!-- page content -->
        <div class="right_col" role="main">
         <?php
        if (page_status(explode('.php',basename(__FILE__))[0]))
        { ?>
          <div class="page-title">
            <div class="title_left">
              <h3>Добавить преподавателя</h3>
            </div>
          </div>

          <div class="clearfix"></div>
          <!--<div class="row">
          form teacher begin -->
          <form id="add_teacher"  class="form-horizontal form-label-left"><!--data-parsley-validate-->

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              
              <!--x-panel-->
              <div class="x_panel">
                
                <div class="x_title"><!--x-title-->
                  <h2>Данные</h2>
                  <div class="clearfix"></div>
                </div>               <!--x-title-->
               

                 <div class="x_content"><!--x_content-->
                
                  <!--photo-block-->
                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div id="photo_block">
                      <div id="myphoto">
                        <img src="/images/Teacher-female-icon.png"  class="img-responsive">
                      </div>
                      
                      <div id="photo_message" onclick="add_photo_of_user('img_of_user','#myphoto')" style="text-align: center;">
                        <i class="fa fa-camera" aria-hidden="true" style="margin-right:5px;"></i>
                        изменить
                      </div>
                      <input type="file" name="img_of_user"> 
                    </div>
                  </div><!--photo-block-->
                
                  <!--Поля преподавателя-->
                  <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 form-group-h50">
                    <div class="row">
                        <!--Фамилия-->
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" required="required" name="surname" placeholder="Фамилия">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <!--Имя-->
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" required="required" name="name" placeholder="Имя">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <!--Отчество-->
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" name="patronymic" placeholder="Отчество">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <!--Пол-->
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group select_class">
                         <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 0px;text-align: right; padding-top: 10px;">
                         Пол
                         </label>
                         <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding-right: 0px;">
                            <p>                                
                              <div>
                                <span>М</span> <input type="radio" class="flat" name="gender" value="1" checked/>
                              </div>

                              <div>
                                <span>Ж</span> <input type="radio" class="flat" name="gender" value="0" />
                              </div>
                            </p>  
                          </div>
                      </div>

                      <!--Дата рождения-->
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="date" class="date form-control has-feedback-left"  name="birth" required="required"  placeholder="Дата рождения" style="padding-right: 5px;">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      

                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback item form-group">
                        <input id="email"  type="email" class="form-control has-feedback-left"name="email" required="required" placeholder="email" > 
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>

                    </div>
                    
                    <div class="row">
                      <!--Телефон-->
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" name="phone" required="required" placeholder="Телефон" data-parsley-pattern="8\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}" data-inputmask="'mask' : '8 (999) 999-99-99'">
                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <!--Адрес-->
                       <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" name="adress" required="required"  placeholder="Адрес">
                        <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                    </div>
                </div> 
                <!--Поля преподавателя-->  

            </div><!--x_content-->
            </div><!--x-panel-->
          </div>

          <div class="col-lg-12 col-md-12 col-ms-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Комментарий</h2>
                  <div class="clearfix"></div>
                </div>

               <div class="x_content">
                <textarea class="form-control" name="note" style="margin-bottom: 10px;"></textarea>
               </div>
            </div>
          </div>
       
          </form> <!--form student end -->
          <!--</div>  class="row"-->

          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <button type="submit" class="btn btn-success pull-right" onclick="add_teacher()">Сохранить</button>
          </div>

          <?php 
          }
          else
          {
            include("build/blocks/access_is_denied.html");
          }
           ?>
          
          </div><!-- right-col -->

          </div><!--main_container-->
        </div>
        <!-- /page content -->

<?php 
  $script="../build/js/add_teachers.js";
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>