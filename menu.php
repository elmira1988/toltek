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
          <img src="images/people-icon.png" alt="..." class="img-circle profile_img">
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
          </ul>
        </div>

      </div>
      <!-- /sidebar menu --> 

      <!-- /menu footer buttons 
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
      -->
    </div>
  </div>
