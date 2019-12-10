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
          <?php
          if (page_status(explode('.php',basename(__FILE__))[0]))
          { ?>
            <div class="page-title"> 
              <div class="title_left">
                <h3>Добавить группу</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <br />
                    <form id="form-add-group" data-parsley-validate="" class="form-horizontal form-label-left">
                      
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label>Наименование группы</label>
                          <input type="text" name="name_of_group" required="" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                      
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label>Курс</label>
                           <select name="id_courses" class="select2_group form-control">
                            <?php 
                                  //суммируем все направления ШКОЛА+УГЛУБЛЕННОЕ ИЗЧЕНИЕ ПРЕДМЕТОВ
                                  $direction=array_merge(get_all_direction(0),get_all_direction(1));

                                  for ($i=0;$i<count($direction);$i++)
                                  {
                                    echo '<optgroup label="'.$direction[$i]["name_of_directions"].'">';
                                      $courses=get_courses_of_direction($direction[$i]['id_directions']);
                                      for ($k=0;$k<count($courses);$k++)
                                      {
                                        echo '<option value="'.$courses[$k]['id_courses'].'">'.$courses[$k]['name_of_course'].'</option>';
                                      }
                                    echo '</optgroup>';
                                  }
                                    ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label>Комментарий</label>
                          <textarea name="note" class="form-control" rows="3"></textarea>
                        </div>
                      </div>
                    </form>

                    <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-success pull-right" onclick="save_group()">cохранить</button>
                        </div>
                      </div>
                      
                  </div>
                </div>
              </div>
            </div>
           <?php
           }
           else
           {
            include("build/blocks/access_is_denied.html"); 
           }
           ?> 
        </div>
        <!-- /page content -->
<?php 
  $script="../build/js/all_groups.js";
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>
