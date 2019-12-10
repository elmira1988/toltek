<div id="filter-block" class="row" style="display: block"> 
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div id="filter_panel" class="x_content">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
                      <div id="achive" class="btn-group">
                        <button name="achive" class="btn btn-default active" title="Актууальные записи" type="button" value="false">Актуально</button>
                        <button name="achive" class="btn btn-default" title="Обучающиеся, не вносившие платежи" type="button" value="true">Архив</button> 
                      </div>
                    </div>

                     <!-- Фамилия - filter begin-->
                      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group">
                        <label class="control-label">Фамилия</label>
                        <div class="has-feedback multi-select"> 
                          <input type="text" class="form-control" id="surname_select" readonly="readonly" placeholder="Выбрать">
                          <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>

                           <ul class="select-block">
                                <li class="all">
                                 <div class="checkbox">
                                  <label>
                                    <input type="checkbox" value="all"> Все
                                  </label>
                                </div>
                                </li>
                                <?php 
                                  $students=get_students();
                                  for ($i=0;$i<count($students);$i++)
                                  {
                                    $name=$students[$i]['surname'].' '.$students[$i]['name'].' '.$students[$i]['patronymic'];
                                    ?>
                                     <li>
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="id_students" value="<?php echo $students[$i]['id_students'];?>" data-name="<?php echo $name;?>"><?php echo $name; ?>
                                        </label>
                                      </div>
                                    </li>
                                    <?php
                                  }
                                 ?>  
                            </ul>
                       </div>
                      </div>
                    <!-- Фамилия - filter end-->

                    <!-- Класс - filter begin-->
                      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 form-group">
                        <label class="control-label">Класс</label>
                        <div class="has-feedback multi-select"> 
                          <input type="text" class="form-control" id="surname_select" readonly="readonly" placeholder="Выбрать">
                          <span class="fa fa-bell form-control-feedback right" aria-hidden="true"></span>

                           <ul class="select-block">
                                <li class="all">
                                 <div class="checkbox">
                                  <label>
                                    <input type="checkbox" value="all"> Все
                                  </label>
                                </div>
                                </li>
                                <?php 
                                  for ($i=1;$i<=11;$i++)
                                  {
                                    ?>
                                     <li>
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="class_number" value="<?php echo $i; ?>" data-name="<?php echo $i; ?>"><?php echo $i; ?>
                                        </label>
                                      </div>
                                    </li>
                                    <?php
                                  }
                                 ?>  
                            </ul>
                       </div>
                      </div>
                    <!-- Класс - filter end-->

                   <!-- Группы - filter begin-->
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 form-group">
                      <label class="control-label">Направления/ Курсы/ Группы</label>
                      <div class="has-feedback multi-select"> 
                        <input type="text" class="form-control" id="surname_select" readonly="readonly" placeholder="Выбрать">
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>

                          <ul class="select-block">
                              <?php 
                                //суммируем все направления ШКОЛА+УГЛУБЛЕННОЕ ИЗЧЕНИЕ ПРЕДМЕТОВ
                                $direction=array_merge(get_all_direction(0),get_all_direction(1));
                                
                                
                                for ($i=0;$i<count($direction);$i++)
                                {
                                  $groups=get_groups(array("id_directions" => array($direction[$i]["id_directions"])));
                                  $add="";
                                  if (count($groups)==0) $add=" <i>(нет групп)</i>";
                                  ?>
                                  <li class="all">
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="all" data-id="<?php echo $direction[$i]['id_directions'];?>" value="<?php echo $direction[$i]['id_directions']; ?>"><?php echo $direction[$i]['name_of_directions'].$add; ?>
                                      </label>
                                    </div>
                                  </li>
                                  <?php  
                                  
                                  //print_r($groups);
                                  for ($k=0;$k<count($groups);$k++) 
                                  {
                                    ?>
                                    <li> 
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="id_groups" data-id="<?php echo $direction[$i]['id_directions'];?>" value="<?php echo $groups[$k]['id_groups']; ?>" data-name="<?php echo $groups[$k]['name_of_group']; ?>">
                                        <?php echo $groups[$k]['name_of_group']." <small> - <i>".$groups[$k]['name_of_course']."</i></small>"; ?>
                                      </label> 
                                    </div>
                                  </li>
                                    <?php
                                  }
                                }
                               ?>  
                          </ul>

                     </div>
                    </div>
                    <!-- Группы - filter end-->

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 form-group">
                      <button type="button" class="btn btn-success btn-sm pull-right" style="margin-top:26px" onclick="get_data_by_filter()">Применить</button>
                    </div>
                  </div><!--x-content-->

                  </div><!--x-panel -->
             </div>
           </div> <!--filter-block-->