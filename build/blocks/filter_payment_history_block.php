<div id="filter-block" class="row" style="height:auto;display: block;"> 
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div id="filter_panel" class="x_content">

                    <div class="row">
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group" style="margin-bottom: 25px;">
                      <div id="paystatus" class="btn-group">
                          <button name="allPay" class="btn btn-default"  title="История выплат всех обучающихся" type="button">Все</button>
                          <button name="notPay" class="btn btn-default" title="Обучающиеся, не вносившие платежи" type="button">Без оплаты</button> 
                          <button name="Receiving" class="btn btn-default" title="Обучающиеся с оплатой, которую списали" type="button">С оплатой (списано)</button>
                          <button name="notReceiving" class="btn btn-default" title="Обучающиеся с оплатой, которую не списали" type="button">С оплатой (не списано)</button>
                        </div> 
                      </div>


                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group" style="margin-bottom: 25px;">
                        <div id="achivestatus" class="btn-group pull-right">
                          <button name="actual" class="btn btn-default"  title="Актуальные" type="button">Актуальные</button>
                          <button name="achive" class="btn btn-default" title="Архивные" type="button">Архивные</button> 
                          <button name="all" class="btn btn-default" title="Все записи" type="button">Все записи</button>
                      </div> 

                        <button id="export_payments" type="button" class="btn btn-default pull-right" style="color: inherit;margin-right: 30px;" onclick="export_excel()">
                          <span class="fa fa-file-excel-o" style="padding-right: 5px; font-size: 12pt;color:#5cb85c;"></span>экспорт
                        </button> 
                      </div>
                    </div>

                     <!-- Фамилия - filter begin-->
                      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 form-group">
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

                   <!-- Группы - filter begin-->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 form-group">
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

                    <!-- Период - filter begin-->
                    <div id="time" class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
                      <label>Период</label> 
                      <input type="text" id="date" readonly class="form-control" style="cursor:pointer;">
                    </div>
                    <!-- Период - filter end-->

                    <!-- Кассир - filter begin-->
                      <div id="paymasters" class="col-lg-2 col-md-4 col-sm-6 col-xs-12 form-group">
                        <label class="control-label">Кассир</label>
                        <div class="has-feedback multi-select"> 
                          <input type="text" class="form-control" id="paymaster_select" readonly="readonly" placeholder="Выбрать">
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
                                  $paymasters=get_paymasters();
                                  for ($i=0;$i<count($paymasters);$i++) 
                                  {
                                    $name=$paymasters[$i]['surname'].' '.substr($paymasters[$i]['name'], 0, 2).'. '.substr($paymasters[$i]['patronymic'], 0, 2).'.';
                                    ?>
                                     <li>
                                      <div class="checkbox">
                                        <label> 
                                          <input type="checkbox" name="id_users" value="<?php echo $paymasters[$i]['id_users'];?>" data-name="<?php echo $name;?>"><?php echo $name; ?>
                                        </label>
                                      </div>
                                    </li>
                                    <?php
                                  }
                                 ?>  
                            </ul>
                       </div>
                      </div>
                    <!-- Кассир - filter end-->

                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 form-group">
                      <button type="button" class="btn btn-success btn-sm pull-right" style="margin-top:26px;" onclick="get_data_by_filter()">Применить</button>
                    </div>

                  </div><!--x-content-->

                  </div><!--x-panel -->
             </div>
           </div> <!--filter-block-->