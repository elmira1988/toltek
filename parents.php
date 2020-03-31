<?php 
include "header_main.php";
?>
<body class="login"> 
	<div class="login_wrapper">
        <div class="animate form login_form">

        	<img src="images/Tekhnopark_logo.png" style="width:220px;display: block; margin: auto;margin-top:5%;">
        		
			<?php
			$key_error=true;//ошибка "Неверный ключ"
			if (isset($_GET['key']))
			{
				require_once("build/php/functions.php");

				if ($id_parents=get_data_parents_key(array("key" => array($_GET['key'])))[0]["id_parents"]);
				{
					$key_error=false;//Ключ в базе существует
					//ранее логин и пароль не были созданы
					if (!$id_parents_log_pas=has_log_pas($_GET['key']))
					{
				?>						
		        	<br>
		        	 <section class="login_content">
			            <form autocomplete="off">
			              <h1 style="margin-bottom: 10px">
			              	Регистрация<br><p><small>родителя / представителя</small></p>
			              </h1>

			              <input type="hidden" name="key" value="<?php echo $_GET['key']; ?>"/>

			              <div class="form-group" style="min-height: 80px">
		                      <label>Логин</label>
		                      <input type="text" name="login" class="form-control animated" required="" style="margin-bottom:0px;"> 
		                    </div>

		                  <div class="form-group" style="min-height: 80px;position:relative;">
		                      <label>Пароль</label>
		                       <input type="password" name="password" class="form-control animated" required="" style="margin-bottom:0px;">
		                       <label id="pass"></label>
		                    </div>
			              <div>

			              <div>
			                <a class="btn btn-default submit">сохранить</a>
			                <!--<a class="reset_pass" href="#">Lost your password?</a>-->
			              </div>
			            </form>
			          </section>
					<?php
				}
				else
				{
					?>
					<section class="info_content">
						<br>
						<h5>Логин и пароль для доступа к личному кабинету родителя/представителя ранее были успешно сохранены.</h5>
						<br>
						<a href="/" class="btn btn-default">войти в личный кабинет</a><br><br>
						<a href="/restore_log_pas.php" class="btn btn-default">я забыл логин и пароль</a>
					</section>
					<?php
					
				}
				}						
				}

				if ($key_error) //Ключ неверный или его не существует
				{
					?>
					<p style="color:red;font-size:14px;"><i  class="fa fa-warning"></i> <b>Неверный ключ!</b><br> Обратитесь к администратору</p>
				<?php
				}
				 ?>
		</div>
	</div>
<footer>
	<div class="separator">
      <p style="text-align: center;">©<?php echo date("Y")?> Стерлитамакский филиал БашГУ</p>
  </div> 
</footer>
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>

 <!-- jquery.inputmask -->
<script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script> 

<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
 <!-- Parsley -->
<script src="../vendors/parsleyjs/dist/parsley.js"></script>

<!-- PNotify -->
<script src="../vendors/pnotify/dist/pnotify.js"></script>
<script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
<script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.js"></script>

<script type="text/javascript" src="build/js/parent_registration.js"></script>
</body>
