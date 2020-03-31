  <?php 
  require_once("functions.php");
  //print_r($_POST);

    $str='<div class="row form-group-h50">'; 
      $str.='<input type="hidden" name="id_students" value="'.$_POST["id_students"].'">';
      $str.='<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Добавить обучающегося в группу</label>'; 
    $str.='<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 form-group multi-select">';
      $str.='<input id="multi_select_whith_meta" type="text" class="form-control" readonly="readonly" placeholder="Выбрать группу/группы" >'; 
       $str.='<ul class="select-block" style="max-height:150px;">'; 
      //суммируем все направления ШКОЛЫ+УГЛУБЛЕННОЕ ИЗЧЕНИЕ ПРЕДМЕТОВ
      $direction=array_merge(get_all_direction(0),get_all_direction(1));

      for ($i=0;$i<count($direction);$i++)
      {
        $groups=get_groups(array("id_directions" => array($direction[$i]["id_directions"])));
         $add=""; if (count($groups)==0) $add=" (нет групп)";
     
        $str.='<li class="all">
                 <div class="checkbox">
                   <label>';
                   $str.='<input type="checkbox" id="all" data-id="'. $direction[$i]['id_directions'].'" value="'.$direction[$i]['id_directions'].'">'.$direction[$i]['name_of_directions'].$add;
            $str.='</label>
                 </div>
              </li>';

          for ($k=0;$k<count($groups);$k++)
          {

            $str.='<li>
                      <div class="checkbox"> 
                        <label> ';
                      $str.='<input type="checkbox" name="id_groups" onchange="add_delete_meta(this,\'id_groups\')" data-id="'.$direction[$i]['id_directions'].'" value="'.$groups[$k]['id_groups'].'" data-class_number="'.get_class_number_of_course($groups[$k]['id_courses']).'" data-name="'.$groups[$k]['name_of_group'].'">'.$groups[$k]['name_of_group'].' <small> - <i>'.$groups[$k]['name_of_course'].'</i></small>'; 
                  $str.='</label> 
                      </div> 
                   </li>';
          }
      }

  $str.='</ul>
  </div>';
  

  //Мета-блок
  $str.='<div id="meta_block" class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group"></div>';

  $str.='</div>';

  $str.='<div class="row form-group-h50">';
      $str.='<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Период обучения</label>'; 
      $str.='<div  id="time" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group multi-select">
              <input type="text" id="date" readonly placeholder="Выберите период обучения" class="form-control" style="cursor:pointer;">
              <ul class="parsley-errors-list filled display_none"><li class="parsley-required">Это обязательное поле.</li></ul>
             </div>';
  $str.='</div>';


  echo $str; 
   ?>
  
 
    

      
      
   