  <?php 

  require_once("functions.php");
 	
  $arr=json_decode($_POST["data"],true);

  $arr=get_payments($arr,true);//выводим общее количество записей
  $count_raw = $arr['count_raw'];//количество записей общее
  $payments = $arr['payments'];//массив с историей выплат (подробно)
  $page = $arr['page'][0]; //номер печатаемой страницы
  $summ=$arr['summ'];//сумма общая

  $groups=get_groups(array(),true);//все группы
  $paymasters=get_paymasters(array(),true);//все кассиры
  
  $str='';
  
  if(count($payments))
  {
  	foreach ($payments as $k => $v) 
    {
      $group=$groups[$v["id_groups"]];
      $name=$v["surname"].' '.$v["name"].' '.$v["patronymic"];
      $sms_in_month=get_history_sms(array("id_user" => array($v["id_students"]),"months" => array(date('m')))); 
      
      $str.="<tr>";
        $str.='<td><input type="checkbox" name="selected" class="flat"></td>';
        $str.='<td style="border-bottom: 2px solid #dddddd;position:relative;">'; 
              if (count($sms_in_month)>0)
              {
                 $str.='<div class="fa fa-envelope last_sms" data-toggle="tooltip" data-placement="top" title="'.get_time($sms_in_month[count($sms_in_month)-1]["date"],5).'"></div>';
              }
              //ФИО обучащегося, группа, курс
              $str.='<span id="student" title="'.$v["id_students"].'" data-id-students="'.$v["id_students"].'" onclick="modal_history('.$v["id_students"].',\''.$name.'\')">'.$name.'</span>'; 
              $str.='<br><i class="fa fa-child"></i> '.$group['name_of_group'].' / <small>'.$group["name_of_course"].'</small>';
              $str.='<br><h2 style="margin:0px;"><small><i class="fa fa-mobile-phone"></i> '.$v['phone'];
              $str.='<br><i class="fa fa-envelope-o"></i> '.$v['email'].'</small></h2>';
        $str.='</td>';
      $str.='<td style="border-bottom: 2px solid #dddddd;padding:0px;">';

      //Описание оплаченных периодов

      $p=0;
      $parent=get_info_parents($v["id_parents"])[0];//представитель

       foreach ($v["payments"] as $key => $val)
       {
         if ($p>0) $str.='<div style="margin:5px 0px;width:100%;border-top:1px solid #ddd;"></div>';
     
         
         $date_of_receiving=get_time($val["date_of_receiving"],2);//дата списания платежа
         $paymaster=$paymasters[$val["id_users"]];
         $paymaster=get_inic($paymaster['surname'], $paymaster['name'],$paymaster['patronymic']);

         $str.="<div class='row' style='margin:0px;margin-top:5px;'>";
           //Месяц
           $str.='<div class="col-lg-1 col-md-4" id="block_with_months" style="height:25px;">'.print_months_study_payment(explode(",",$val['month']),$v["months_of_study"],$v["goodmonths"]).'</div>';

           //Сумма
           $str.='<div class="col-lg-1 col-md-4" style="text-align:center;height:25px;"';
           if ($date_of_receiving=="")
            $str.=" amount='notreceiving' payment='".$val['id_payment']."'"; 
            $str.='>'.$val["amount"].'</div>';
            //$summ+=$val["amount"];

            //Дата оплаты
            $str.='<div class="col-lg-2 col-md-4" style="height:25px;">'.get_time($val["date_of_entry"],2).'</div>';

            //Плательщик
            $str.='<div class="col-lg-3 col-md-4" style="height:25px;">'; 
            $str.='<span style="line-height: 14px;" onclick="print_payment_info(this)" paint="paint/'.$val['paint'].'" surname="'.$parent['surname'].' '.$parent['name'].' '.$parent['patronymic'].'">'.get_inic($parent['surname'], $parent['name'],$parent['patronymic']).'.</span>';
           $str.='</div>'; 

           //Кассир
           $str.='<div class="col-lg-3 col-md-4" style="height:25px;">'.$paymaster;

           //Комментарий
           if ($val["note"]!="")
           {
            $str.="<br><i>".$val["note"]."</i>";
           }
           $str.='</div>';

           //Дата списания
           $str.='<div class="col-lg-2 col-md-4" style="height:25px;">'.$date_of_receiving.'</div>';
         $str.='</div>';
         $p++;
      } 
      //print_this_months($v["badmonths"])
       $str.='<td style="border-bottom: 2px solid #dddddd;" id="block_with_months">';
       $str.=print_months_study_payment($GLOBALS['month_study'],$v["months_of_study"],$v["goodmonths"]).'</td>';
       $str.='</tr>'; 
    }
  
    $str.='<tr><td colspan="4">';
    	//Постраничная навигация
	  	$chunk_size=$GLOBALS["chunk_size"];//количество записей на одной странице
	  
	  	//количество страниц
	  	$count_page=intdiv($count_raw,$chunk_size);	  
		if(($count_raw%$chunk_size)>0)  {   $count_page+=1;  }

		$str.='<div class="row">';
			$str.='<div class="col-sm-5">';
				$str.='<div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite">Отображено с '.(($page-1)*$chunk_size+1).' по '.(($k=$page*$chunk_size<$count_raw)?$k:$count_raw).' из '.$count_raw.' записей</div>';
			$str.='</div>';
		$str.='<div class="col-sm-7">';
			$str.='<div class="dataTables_paginate paging_simple_numbers" id="datatable-fixed-header_paginate">';
	 		$str.='<ul class="pagination">';

		  if($count_page>1)
		  {
		      $str.='<li class="paginate_button previous '.(($page == 1)?' disabled ':'').'" id="datatable-fixed-header_previous">';
		        $str.='<a href="#" aria-controls="datatable-fixed-header" data-dt-idx="0" tabindex="0" onclick="get_data_by_filter('.($page-1).')">Предыдущая</a>';
		      $str.='</li>';
		  }


		  if($count_page<=7)
			{
				for($i=1;$i<=$count_page;$i++)
				{
					$str.='<li class="paginate_button '.(($page == $i )?'active':'').'">';
				        $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="'.$i.'" tabindex="0" onclick="get_data_by_filter('.$i.')">'.$i.'</a>';
				      $str.='</li>';
				}
			}
			else
			{
				if(($page>4) && (($count_page-$page)>4))
				{
					$str.='<li class="paginate_button">';
			        $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="1" tabindex="0" onclick="get_data_by_filter(1)">1</a>';
			      	$str.='</li>';

			      	$str.='<li class="paginate_button disabled" id="datatable-fixed-header_ellipsis">';
				      	$str.='<a href="" aria-controls="datatable-fixed-header" data-dt-idx="" tabindex="0" >…</a>';
				    $str.='</li>';

			      	$str.='<li class="paginate_button">';
			       	 $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="'.($page-1).'" tabindex="0" onclick="get_data_by_filter('.($page-1).')">'.($page-1).'</a>';
			      	$str.='</li>';


			      	$str.='<li class="paginate_button active">';
			       	 $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="'.$page.'" tabindex="0" onclick="get_data_by_filter('.$page.')">'.$page.'</a>';
			     	$str.='</li>';

			     	$str.='<li class="paginate_button">';
			       	 $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="'.($page+1).'" tabindex="0" onclick="get_data_by_filter('.($page+1).')">'.($page+1).'</a>';
			      	$str.='</li>';

			      	$str.='<li class="paginate_button disabled" id="datatable-fixed-header_ellipsis">';
				      	$str.='<a href="" aria-controls="datatable-fixed-header" data-dt-idx="" tabindex="0" >…</a>';
				    $str.='</li>';

			     	 $str.='<li class="paginate_button">';
			     	   $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="'.$count_page.'" tabindex="0" onclick="get_data_by_filter('.$count_page.')">'.$count_page.'</a>';
			     	 $str.='</li>';
				}
				else
				{
					if($page<=4)
					{
						for($i=1;$i<=5;$i++)
						{
							$str.='<li class="paginate_button '.(($page == $i)?" active ":"").'">';
					       	 $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="'.$i.'" tabindex="0" onclick="get_data_by_filter('.$i.')">'.$i.'</a>';
					     	$str.='</li>';
						}

						$str.='<li class="paginate_button disabled" id="datatable-fixed-header_ellipsis">';
				      		$str.='<a href="" aria-controls="datatable-fixed-header" data-dt-idx="" tabindex="0" >…</a>';
				    	$str.='</li>';

				    	$str.='<li class="paginate_button">';
				     	   $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="'.$count_page.'" tabindex="0" onclick="get_data_by_filter('.$count_page.')">'.$count_page.'</a>';
				     	 $str.='</li>';

					}
					else
					{
						$str.='<li class="paginate_button">';
				     	   $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="1" tabindex="0" onclick="get_data_by_filter(1)">1</a>';
				     	 $str.='</li>';

				     	 $str.='<li class="paginate_button disabled" id="datatable-fixed-header_ellipsis">';
				      		$str.='<a href="" aria-controls="datatable-fixed-header" data-dt-idx="" tabindex="0" >…</a>';
				    	 $str.='</li>';

						for($i=($count_page-4);$i<=$count_page;$i++)
						{
							$str.='<li class="paginate_button '.(($page == $i)?" active ":"").'">';
					       	 $str.='<a href="" role="button" aria-controls="datatable-fixed-header" data-dt-idx="'.$i.'" tabindex="0" onclick="get_data_by_filter('.$i.')">'.$i.'</a>';
					     	$str.='</li>';
						}
				    	
					}
				}
			}

		  if($count_page>1) 
		  {
		    $str.='<li class="paginate_button next '.(($page == $count_page)?' disabled ':'').'" id="datatable-fixed-header_next" >';
		      $str.='<a href="" aria-controls="datatable-fixed-header" data-dt-idx="8" tabindex="0" onclick="get_data_by_filter('.($page+1).')">Следующая</a>';
		    $str.='</li>';
		  }

		$str.='</ul>';
		$str.='</div>';
	$str.='</div>';

    $str.='</tr>';

	}
	else
	{
		$str='<tr><td colspan="4"> Записей не найдено</td></tr>';
	}

	$str.='<input type="hidden" name="count_raw" value="'.$count_raw.'"/>';
    $str.='<input type="hidden" name="summ" value="'.$summ.'"/>';
    $str.='<input type="hidden" name="query" value="'.$arr['query'].'"/>';
    echo $str;  
 
 ?>