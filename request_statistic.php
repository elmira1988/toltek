<?php 
  session_name('toltek');
  session_start();

  if (isset($_SESSION['id_users']))
  {
    $css=array("../build/css/request_statistic.css");//,"../vendors/bootstrap/dist/css/less/modals.less"
    include "header_main.php";
    require_once("build/php/functions.php");
 ?>
    <body class="nav-md">
      <div class="container body">
        <div class="main_container">
          <?php
          include "menu.php"; 
          include "top_navigation.php";  
          $directions=array_merge(get_all_direction(0),get_all_direction(1));
          ?>

          <!-- page content -->
           <div class="right_col" role="main">

            <?php if (page_status(explode('.php',basename(__FILE__))[0]))
            { ?>
              <!--page-title BEGIN-->
              <div class="page-title">
                <div class="title_left">
                  <h3>Статистика по заявкам</h3>
                </div>
                <div class="title_right">
                  <button type="button" class="btn btn-default pull-right" style="color: inherit;">
                    <span class="fa fa-file-excel-o" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>экспорт
                  </button> 
                </div>
              </div>
             <!--page-title END-->

              <div class="clearfix"></div>

              <?php 
              for ($i=0;$i<count($directions);$i++)
              {
                $courses=get_courses_of_direction($directions[$i]["id_directions"]); 
                $classis=get_all_class_by_direction($directions[$i]["id_directions"]);

                if(count($classis)!=0)
                {
                ?>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title" style="border:unset;">
                    <h2>
                     <?php  echo $directions[$i]["name_of_directions"];?>
                    </h2>
                  </div>
                  <div class="x_content">
                    <table class="table table-bordered table-static"> 
                      <thead>
                        <tr>
                          <th style="width:80px;" rowspan="2">Уровень</th>
                          <th rowspan="2">Наименование курса</th>
                          <th rowspan="2" style="width:80px;">Всего</th> 
                          <th rowspan="2" style="width:80px;">Старые</th>
                          <th rowspan="2" style="width:80px;" >Новые</th>
                          <th colspan="<?php echo count($classis) ?>" style="text-align: center;">Классы</th>
                        </tr> 

                        <tr>
                          <?php 
                          foreach ($classis as $key => $value) {
                            echo "<th style='width:30px;'>".$value["class_number"]."</th>";
                          }
                           ?>
                        </tr>

                      </thead>
                      <tbody>
                        <?php 

                          $sum_count_attend=0;
                          $sum_not_attend=0;
                          $array_class=array();
                          for ($k=0;$k<count($courses);$k++)
                          {
                            $count=get_count_of_requests($courses[$k]["id_courses"]);
                            $count_attend=$count["attend"];
                            $count_not_attend=$count["not_attend"];
                            $all_count=$count["attend"]+$count["not_attend"];

                            echo "<tr".(($all_count=='') ?' class="not_requests" ':'').">"; 
                              echo "<td>".$courses[$k]["level"]."</td>";
                              echo "<td>".$courses[$k]["name_of_course"]."</td>";
                              echo "<td>".pr_n($all_count)."</td>";
                              echo "<td>".pr_n($count_attend)."</td>";
                              echo "<td>".pr_n($count_not_attend)."</td>";

                              foreach ($classis as $key => $value) {
                              echo "<td style='vertical-align:middle'>". pr_n($count[$value["class_number"]])."</td>";
                              if (!array_key_exists($value["class_number"],$array_class))
                              {
                                $array_class[$value["class_number"]]=0;
                              }
                               $array_class[$value["class_number"]]+=$count[$value["class_number"]];
                            }
                            echo "</tr>";

                            $sum_count_attend+=$count_attend;
                            $sum_not_attend+=$count_not_attend;
                          }
                         ?>
                         <tr class="footer">
                           <td></td>
                           <td>Итого</td>
                           <td><?php echo ($sum_count_attend+$sum_not_attend);?></td>
                           <td><?php echo $sum_count_attend;?></td>
                           <td><?php echo $sum_not_attend;?></td>
                           <?php
                           foreach ($classis as $key => $value) {
                              echo "<td style='vertical-align:middle'>".$array_class[$value["class_number"]]."</td>";
                            }
                            ?>
                         </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <?php
                }
              }
              }
              else
              {
                include("build/blocks/access_is_denied.html"); 
              }
               ?>
              
            
        </div> <!-- /page content -->

<?php 
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>