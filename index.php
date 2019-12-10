 <?php 
    session_name('toltek');
    session_start();

    if (!isset($_SESSION['id_users']))
    {
       include "header.php";
	?>
  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">

        	<img src="images/Tekhnopark_logo.png" style="width:220px;display: block; margin: auto;">
        	<br/>
        	<h4 style="text-align: center;color:#055da9;"><b>Информационная система</b></h4>

	          <section class="login_content">
	            <form>
	              <h1 style="margin-bottom: 10px">Авторизация</h1>

	              <div class="error-login animated"> Неверный логин/пароль!</div>

	              <div>
	                <input type="text" name="login" class="form-control animated" placeholder="Логин" required="" />
	              </div>

	              <div>
	                <input type="password" name="password" class="form-control animated" placeholder="Пароль" required="" />
	              </div>

	              <div>
	                <a class="btn btn-default submit">войти</a>
	                <!--<a class="reset_pass" href="#">Lost your password?</a>-->
	              </div>

	              <div class="clearfix"></div>

	              <div class="separator">
	                <div class="clearfix"></div>
	                <br />
	                <div>
	                  <p>©2019 Стерлитамакский филиал БашГУ</p>
	                </div>
	              </div>

	            </form>
	          </section>
        </div>
      </div>
    </div>

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
    	header("Location: http://admin.toltekplus.ru/".$GLOBALS["arr"][$_SESSION["id_roles"]]["start_page"]); 
    } ?>
