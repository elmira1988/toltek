<?php 
include "header_main.php";
?>
<body class="login">
	<div class="login_wrapper">
        <div  class=" form login_form">

        	<img src="images/Tekhnopark_logo.png" style="width:220px;display: block; margin: auto;margin-top: 5%;">
            <?php  if (!isset($_GET["key"])) 
            {
                ?>
                <div style="position:relative;">
                    <section id="email_block" class="animate login_content">
                        <form autocomplete="off">
                            <h2>Восстановление доступа</h2>
                            <p>Укажите почтовый ящик, который Вы оставляли администратору Технопарка Толтек СФБашГУ при заключении договора на обучение ребенка.</p>

                            <div class="form-group" style="min-height: 80px">
                                <label>Email</label>
                                <input id="email" type="email" name="email" class="form-control animated" required="required" style="margin-bottom:0px;"> 
                            </div>

                            <a class="btn btn-default submit pull-right">далее</a>
                                      
                        </form>
                    </section> 

                <section id="info" class="animate login_content" style="opacity: 0;position: absolute;top:0px">
                    <p>На указанный Вами почтовый ящик было отправено письмо. Пожалуйста, откройте его, чтобы продолжить восстановление доступа к личному кабинету.</p>
                </section>
                </div>
            <?php 
            }
            else
            {
                require_once("build/php/functions.php");
                if ($id_parents_key=get_data_parents_key(array("key" => array($_GET['key'])))[0]["id_parents_key"]);
                    {
                        ?> 
                        <br>
                        <div style="position:relative;">
                            <section id="new_log_pas" class="animate login_content">
                                <form autocomplete="off">
                                  <h2>Восстановление доступа</h2>
                                  <p>Введите новые логин и пароль</p>

                                  <input type="hidden" name="id_parents_key" value="<?php echo $id_parents_key; ?>">
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
                                  </div>
                                </form> 
                            </section>

                              <section id="info" class="animate login_content" style="opacity: 0;position: absolute;top:0px">
                                <p>Новые логин и пароль успешно сохранены!</p><br>
                                <a href="/" class="btn btn-default">войти в личный кабинет</a><br>
                            </section>
                        </div>
                         
                        <?php
                    }

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

<script type="text/javascript" src="build/js/restore_log_pas.js?2"></script>
</body>