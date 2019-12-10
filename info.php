<?php 
 include "header.php";
?>
  <body class="login">
    <div>
     <div class="info_block">
        <div class="animate form login_form">

        	<img src="images/Tekhnopark_logo.png" style="width:220px;display: block; margin: auto;">
        	
        	<section class="info_content">
        	<?php  
        		require_once("build/php/functions.php");

        		$id_requests=false;
        		if (isset($_GET["key"]))
        		{
        			$res=get_requests_key(array("key"=>array("'".$_GET["key"]."'"))); 

        			if (count($res)!=0)
        			{
        				$id_requests=$res[0]["id_requests"];
        				update_request_key($id_requests,1); 
        			}

        		}
        		
        		if ($id_requests)
        		{

        		
        		$request=get_all_requests(array("id_requests" => array($id_requests)))[0];

        		//print_r($request);

        		$request_status=get_request_status(array("id_request_status"=>array($request["id_request_status"])))[0];
        		$color=$request_status["color"];
        		$status=$request_status["request_status"];
        	?>
        	
        		<form>
 
        			<button type="button" class="btn btn-default" onclick="location.reload()" style="margin-bottom:15px;">Обновить данные</button>
	            
	            <div class="x_panel" style="border-color: <?php echo $color;?>;">
	            	<div class="x_title" style="color: <?php echo $color;?>">Заявка №<?php echo $request["id_requests"];?></div>
	            	<div class="x_content">
	            		<h4 style="color:<?php echo $color;?>;text-align: left"><b><?php echo $status;?></b></h4>

	            		<?php  
	            		if ($request["note"]!="")
	            		{
	            		?>

	            			<label class="control-label col-md-12 col-sm-12 col-xs-12" style="padding: 0px;text-align: left; padding-top: 10px;">Комментарий администратора</label>
							<div style="text-align: left;"><i><?php echo $request["note"]?></i></div>
	            		
	            		<?php
	            		}
	            		?>
						

						
	            	</div>
	            		
	            </div>

	            <div class="x_panel">
			          <div class="x_title">
			            Данные ребенка
			          </div>

		          <div class="x_content">
		              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
		                  <input type="text" class="form-control has-feedback-left" required="required" name="surname" readonly="readonly" placeholder="Фамилия" value="<?php echo $request["surname"]; ?>">
		                  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
		              </div>

		              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
		                <input type="text" class="form-control has-feedback-left" required="required" name="name" readonly="readonly" placeholder="Имя" value="<?php echo $request["name"]; ?>">
		                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
		              </div>

		              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
		                <input type="text" class="form-control has-feedback-left" name="patronymic" placeholder="Отчество"  readonly="readonly" value="<?php echo $request["patronymic"]; ?>">
		                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
		              </div>

		              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
		                <input type="date" class="date form-control has-feedback-left" name="birth" required="required" readonly="readonly" placeholder="Дата рождения" style="padding-right: 5px;" value="<?php echo $request["birth"]; ?>">
		                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
		              </div>

		              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group">
		                  <label class="control-label col-md-3 col-sm-3 col-xs-12" style="padding: 0px;text-align: left; padding-top: 10px;">Класс</label>
		                  <div class="col-md-9 col-sm-9 col-xs-12" style="padding-right: 0px;">
		                    <input class="form-control" type="text" readonly="readonly" value="<?php echo $request["class_number"]; ?>">
		                  </div>
		              </div>

		              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group select_class">
		                 <label class="control-label col-md-6 col-sm-6 col-xs-6" style="padding: 0px;text-align: left; padding-top: 10px;">Посещал ранее</label>
		                 <div class="col-md-6 col-sm-6 col-xs-6" style="padding-right: 0px;">
		                    <input class="form-control" type="text" readonly="readonly" value="<?php echo (($request["attend"])?"да":"нет"); ?>">
		                  </div>
		              </div>
		          </div><!--x_content-->
		         </div>


		         <div class="x_panel">
		           <div class="x_title">
		             Данные представителя
		           </div>
		           <div class="x_content">
		                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
		                    <input type="text" class="form-control has-feedback-left" readonly="readonly" required="required" name="parent" placeholder="Ф.И.О. полностью" style="padding-right: 3px;" value="<?php echo $request["parent"]; ?>">
		                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
		                </div>
		                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
		                  <input type="text" class="form-control has-feedback-left" readonly="readonly" placeholder="Телефон" required="" name="phone" data-parsley-pattern="8\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}" data-inputmask="'mask' : '8 (999) 999-99-99'" value="<?php echo $request["phone"]; ?>">
		                  <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
		                </div>
		                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
		                  <input type="email" id="email" name="email" readonly="readonly" required="required" class="form-control has-feedback-left" placeholder="Email" style="padding-right: 3px;" value="<?php echo $request["email"]; ?>">
		                  <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
		                </div>
		            </div>
		         </div>

		         <div class="x_panel">

	           <div class="x_title">
	             Выбран(ы) курс(ы)
	           </div>

	           <div class="x_content" style="text-align: left;color: #555;">
	           <!-- Направление - -->
	            
	            	<?php  
	            		$directions=array_merge(get_all_direction(0),get_all_direction(1));

	            		foreach ($directions as $key => $value) {
	            			$courses=get_all_courses_of_request($id_requests,array($value["id_directions"])) ;

	            			if (count($courses)!=0)
	            			{
	            				echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
	            				echo "<h4>".$value["name_of_directions"]."</h4>";
	            				echo "<ul>";
		            			foreach ($courses as $k => $v) {
		            				echo "<li>".$v["name_of_course"]."</li>";
		            			}
		            			echo "</ul>";
		            			echo "</div>";
	            			}
	            			}
	            		
	            	?>
	         
	            	
	          </div>
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
	          <?php 
	      		}
	      			else
	      			{
	      				echo '<h4 style="color:red">Неверный ключ</h4>';
	      			}
	      		?>
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
