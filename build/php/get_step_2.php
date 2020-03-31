<?php
	
	include ("functions.php");

	$user=json_decode($_POST['val'],true);

	

	$str='<p class="text-muted well well-sm no-shadow">Пожалуйста, ознакомьтесь внимательно с курсами, представленными ниже, укажите наиболее подходящие.</p>'; 

	//$days = array(1 => 'Пн' , 2 => 'Вт', 3 => 'Ср', 4 => 'Чт', 5 => 'Пт', 6 => 'Сб', 7 => 'Вс');

	$directions=get_all_direction($user['tutor']);

	
	for ($n=0;$n<count($directions);$n++)
	{
		$courses=get_courses($directions[$n]['id_directions'],$user['class_number']);

			if (count($courses)!=0)
			{
				$str.="<h1>".$directions[$n]['name_of_directions']."</h1><h6>".$directions[$n]['description']."</h6>";
			}

			for ($i=0;$i<count($courses);$i++)
			{
				$str.='<div class="x_panel">';
					$str.='<div class="x_title" style="padding-top: 0px;">';
						$str.='<div class="checkbox" style="float: left; margin: 0px; margin-right: 5px;">';
							$str.='<label style="padding-left: 0px;">';
								$str.='<input type="checkbox" class="flat" name="id_courses"  data-name="'.$courses[$i]['name_of_course'].'" value="'.$courses[$i]['id_courses'].'">';
							$str.='</label>';
						$str.='</div>';
						$str.='<h2 title="'.$courses[$i]['name_of_course'].'">'.$courses[$i]['name_of_course'].'</h2>';
						$str.='<div class="nav navbar-right panel_toolbox" style="text-align:center;">';
						$str.=get_price_of_course($courses[$i]['id_courses'])."р.";  
						$str.='<h6 style="margin:0px;line-height: 5px;"><small style="color: #cccccc;">ежемесячно</small></h6>';
						$str.='</div>';
						$str.='<div class="clearfix"></div>';
					$str.='</div>';

					//$str.='<div class="x_content">';
						
						$str.='<div class="col-md-12 col-sm-12 col-xs-12 ">'.$courses[$i]['description'].'</div>';//mail_list_column

		/*
						$str.='<div class="col-md-4 col-sm-4 col-xs-12 mail_view">';
							$str.='<div class="x_title">';
								$str.='<h2 style="line-height: 15px;width: auto;padding: 0px;margin: 0px;">Расписание';
									$str.='<br><span style="font-size: 8pt; color: #cccccc;">выберите наиболее подходящее</span>';
								$str.='</h2>';
								$str.='<div class="clearfix"></div>';
							$str.='</div>';

							$str.='<ul class="to_do">';		
							$groups_id=get_groups_of_course($courses[$i]['id_courses']);

							for ($j=0;$j<count($groups_id);$j++)
							{
								$str.='<li>';
									$str.='<div class="row">';
										$str.='<div class="col-md-1 col-sm-2 col-xs-1">';
											$str.='<input type="checkbox" class="flat" name="id_courses_'.$courses[$i]['id_courses'].'" value="'.$groups_id[$j]['id_groups'].'">';
										$str.='</div>';	

								$time_table=get_time_table_of_group($groups_id[$j]['id_groups']);
								$d=0;

								$str_time='';
								for ($day=1;$day<=5;$day++)
								{
										$str_time.='<div class="col-md-2 col-sm-2 col-xs-2" style="text-align: center;">'.$days[$day];
												if ($time_table[$d]['day']==$day)
												{
													$str_time.='<br>'.get_printable_time($time_table[$d]['time_begin']).'<sup></sup>';	
													$d=$d+1;
												}
												
										$str_time.='</div>';								
								}

								if ($d==0) 
								{
									$str_time='';
									for ($day=6;$day<=7;$day++)
									{
											$str_time.='<div class="col-md-2 col-sm-2 col-xs-2" style="text-align: center;">'.$days[$day];
													if ($time_table[$d]['day']==$day)
													{
														$str_time.='<br>'.get_printable_time($time_table[$d]['time_begin']).'<sup></sup>';	
														$d=$d+1;
													}
													
											$str_time.='</div>';								
									}

								}
								$str.=$str_time;

								unset($time_table);

									$str.='</div>';	
								$str.='</li>';
							}
								
							$str.='</ul>';	
						$str.='</div>';*/
					//$str.='</div>';//x_content
				$str.='</div>';//x_panel
				
			}

	}



	$str.='<label for="message">Комментарий</label>';
		$str.='<textarea id="message" class="form-control" name="note_of_user"></textarea>';

	echo $str;
	
?>