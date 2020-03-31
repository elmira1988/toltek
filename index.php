<?php 
 session_name('toltek');
 session_start(); 

    if (!isset($_SESSION['id_users']))
    {
       include "header.php"; 
      
	?>
  <body class="login"> 

      <div class="login_wrapper">
        <div class="animate form login_form">

        	<img src="images/Tekhnopark_logo.png" style="width:220px;display: block; margin: auto;margin-top:5%;">
        	<br/>
        	<h4 style="text-align: center;color:#055da9;"><b>Информационная система</b></h4>

	          <section class="login_content">
	            <form>
	              <h1 style="margin-bottom: 10px">Авторизация
                  <?php if (isset($_GET["admin"])) 
                  {
                    ?>
                      <p><small>администратор</small></p>
                      <input type="hidden" name="role" value="1">
                    <?php
                  }
                  else
                  {
                    ?>
                    <p><small>родитель / представитель</small></p>
                    <input type="hidden" name="role" value="4">
                    <?php
                  }
                  ?></h1>

	              <div class="error-login animated"> Неверный логин/пароль!</div>

                

	              <div>
	                <input type="text" name="login" class="form-control animated" placeholder="Логин" required="" />
	              </div>

	              <div>
	                <input type="password" name="password" class="form-control animated" placeholder="Пароль" required="" />
	              </div>

	              <div>
	                <a class="btn btn-default submit">войти</a>
                  <?php 
                  if (!isset($_GET["admin"])) 
                  {
                    ?>                    
                    <a class="reset_pass" href="/restore_log_pas.php">забыли логин/пароль?</a>
                    <?php
                  }
                  ?>
	              </div>

	              <div class="clearfix"></div>

	              

	            </form>
	          </section>
        </div>
      </div>

      <footer>
        <div class="separator">
              <p style="text-align: center;">©<?php echo date("Y")?> Стерлитамакский филиал БашГУ</p>
          </div> 
      </footer>
    <?php 
		//echo password_hash('njkntr1987!', PASSWORD_DEFAULT);
     ?>
        <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
   
    <!-- Custom Theme Scripts --> 
    <script src="../build/js/custom.js"></script>
    
    <!-- My Scripts -->
    <script src="../build/js/login.js"></script>
  </body>
</html>
<?php 
    }
    else
    {
      require_once("build/php/functions.php");

      if (isset($_GET["admin"]))
      {
        header("Location: /".$GLOBALS["arr"][$_SESSION["id_roles"]]["start_page"]);
         
      }
      else
      {
        header("Location: /".$GLOBALS["arr"][4]["start_page"]); 
      }
    	
    	
    } ?>
