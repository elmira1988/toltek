<?php 
    session_name('toltek');
    session_start();
    if (isset($_SESSION['id_users']))
    {
      
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
        <div class="right_col" role="main" style="<?php if (page_status(explode('.php',basename(__FILE__))[0])) { echo "opacity:0"; } ?>" >
            <?php 
            if (page_status(explode('.php',basename(__FILE__))[0]))
            { 

              if ($_SESSION["id_roles"]==4)//если онлайн оплату проводит родитель/представитель
              {
                $parent=get_parents(array("id_parents" => array($_SESSION["id_users"])))[0];
                $students=get_students(array("id_parents" => array($_SESSION["id_users"])));
                $par=get_parents(array("surname"=> array($parent["surname"]),"email" => array($parent["email"])));
                $st=array();
                foreach ($par as $key => $p) {array_push($st,$p["id_parents"]);}
                //поиск у этого родителя еще детей (поиск осуществляется по Фамилии и по по почтовому ящику)
                $students=get_students(array("id_parents" =>$st));
                /*
                print_r($parent);
                print_r($students);
                */
              }
             ?>
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
                          <?php 
                            if ($_SESSION["id_roles"]!=4)
                            {
                           ?>
                          <input type="hidden" name="id_students_groups">
                          <input type="text" id="find_student" class="form-control" name="" autocomplete="off" placeholder="Введите фамилию ...">
                          <?php 
                        }
                        else
                        {
                           ?>
                        
                        <select class="select2_single form-control" name="id_students_groups" tabindex="-1">
                          <?php 
                            foreach ($students as $key => $student) {
                              $groups=get_students_group($student["id_students"]);
                              foreach ($groups as $k => $group) {
                              ?>
                                <option value="<?php echo $group["id_students_groups"] ?>"><?php echo $student["surname"].' '.$student["name"].' '.$student["patronymic"].'/ '.$group["name_of_group"].'/ '.$group["name_of_course"]; ?></option>
                              <?php
                              }
                            }
                           ?>
                        </select>
                        <?php 
                        } ?>
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
                          
                          <?php 
                            if ($_SESSION["id_roles"]==4)
                            {
                           ?>
                           <input type="hidden" name="id_parents" value="<?php echo $parent["id_parents"] ?>">
                           <input type="text" name="LastName" readonly="readonly" class="form-control" autocomplete="off" placeholder="Введите фамилию ..." value='<?php echo $parent["surname"].' '.$parent["name"].' '.$parent["patronymic"];?>'/>
                           <?php 
                            }
                            else
                            {
                            ?>
                            <input type="hidden" name="id_parents">
                            <input type="text" id="find_parent" name="parent" readonly="readonly" class="form-control" autocomplete="off" placeholder="Введите фамилию ..."/>
                            <?php 
                            } ?>
                        </div>

                        <?php 
                        if ($_SESSION["id_roles"]==4)
                        {
                          ?>
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Email (сюда будет отправлен чек)</label> 
                          <input type="email" name="email" readonly="readonly" class="form-control" autocomplete="off" value="<?php echo $parent["email"]; ?>"/>
                        </div>
                          <?php
                        } 
                         ?>

                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                          <label>Комментарий</label> 
                          <input type="text" name="note" class="form-control" autocomplete="off">
                        </div>
                      </div>
                      

                      <?php 
                      if ($_SESSION["id_roles"]!=4)
                      {
                       ?>
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
                      <?php 
                      }
                       ?>

                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button id="payment_btn" class="btn btn-md btn-success pull-right"  
                            <?php 
                              if ($_SESSION["id_roles"]==4)
                              {
                                echo " onclick='payment(this,\"true\")'>   оплатить ";
                              }
                              else
                              {
                                echo " onclick='payment(this)'> принять оплату";
                              }
                             ?>
                          </button>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
        
        <?php 
        $script="../build/js/payment.js?".rand(10,30);
        }
        else
        {
          include("build/blocks/access_is_denied.html");
        } ?>
        <!-- /page content -->
        </div>
<?php 

include "footer_main.php";
}
else {
    header("Location: /"); 
 } ?>