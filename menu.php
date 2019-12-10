      <?php 
      session_start();
      //print_r($_SESSION); 
      //print_r($_GLOBALS);
       ?>
      <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title">
                <i class="fa fa-mortar-board"></i> <span>ИС ТОЛТЕК</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Добро пожаловать,</span>
                <h2><?php echo $_SESSION['name'];?></h2> 
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <?php 
             
            ?>
            
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <input type="hidden" name="id_roles" value="<?php echo $_SESSION["id_roles"]; ?>">

                <ul class="nav side-menu">
                  
                  <?php 
                    //print_r($ArrNav);
                    $li_open=$GLOBALS["arr"][$_SESSION["id_roles"]]["open"];
                    $li_close=$GLOBALS["arr"][$_SESSION["id_roles"]]["closed"];

                    //print_r($li_open); 
                    $str='';
                    foreach ($GLOBALS["ArrNav"] as $key => $value) {
                      $li="<li id='".$key."'><a><i class='".$value["icon"]."'></i>".$value["name"].$value["span"]."</a>"; 
                        $li.="<ul class='nav child_menu'>";

                          $child_menu="";
                          foreach ($value["child_menu"] as $k => $v) {
                           if (((count($li_open)>0) && (in_array($k,$li_open))) || (count($li_open)==0))
                           {
                              if (!(in_array($k,$li_close)))
                              {
                                 $child_menu.="<li id='".$k."'><a href='".$v["href"]."'>".$v["name"]."</a></li>";
                              }
                            
                           }
                          
                          }

                        $li.=$child_menu."</ul>";  

                        if ($child_menu!="")
                        {
                          $str.=$li;
                        }
                    }

                    echo $str;
                   ?>
                  <!--
                   <li id="requests"><a><i class="fa fa-envelope-o"></i> Заявки <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="all_request"><a href="all_request.php">Все заявки</a></li>
                      <li id="request_statistic" ><a href="request_statistic.php">Статистика</a></li>
                    </ul>
                  </li>

                   <li id="courses"><a><i class="fa fa-bookmark-o"></i> Курсы <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="add_courses"><a href="add_courses.php">Добавить курс</a></li>
                      <li id="all_courses"><a href="all_courses.php">Все куры</a></li>                       
                    </ul>
                  </li>

                  <li id="groups"><a><i class="fa fa-child"></i> Группы <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="add_groups"><a href="add_groups.php">Добавить</a></li>
                      <li id="all_groups"><a href="all_groups.php">Все группы</a></li>
                    </ul>
                  </li>

                  <li id="students"><a><i class="fa fa-group"></i> Обучающиеся <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="add_students"><a href="add_students.php">Добавить</a></li>
                      <li id="all_students"><a href="all_students.php">Все обучающиеся</a></li>
                      <li id="attend_student"><a href="attend_student.php">Посещаемость</a></li>
                      <li id="payment"><a href="payment.php">Оплата</a></li>
                    </ul>
                  </li>

                  <li id="teachers"><a><i class="fa fa-group"></i> Преподаватели <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="add_teacher"><a href="add_teacher.php">Добавить</a></li>
                      <li id="all_teachers"><a href="all_teachers.php">Все преподаватели</a></li>
                      <li id="load"><a >Нагрузка <span class="fa fa-chevron-down"></span>
                      </a>

                        <ul class="nav child_menu" style="">
                          <li id="add_load"><a href="add_load.php">Добавить нагрузку</a></li>
                          <li id="all_load"><a href="all_load.php">Вся нагрузка</a></li>
                        </ul>

                      </li>

                      <li id="attend"><a href="attend_teacher.php">Посещаемость</a></li>
                    </ul>
                  </li>

                  <li id="timetable"><a><i class="fa fa-calendar"></i> Расписание <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="constructor"><a href="constructor.php">Конструктор расписания</a></li>
                      <li id="rasp"><a href="rasp.php">Просмотр расписания</a></li>
                    </ul>
                  </li>
                  </li>

                  <li id="statistic"><a><i class="fa fa-line-chart"></i> Статистика <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="stat1"><a href="stat1.php">Статистика по годам</a></li>
                      <li id="stat2"><a href="stat2.php">Статистика по месяцам</a></li>
                    </ul>
                  </li>
                  -->
                </ul>
              </div>

            </div>
            <!-- /sidebar menu --> 

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
