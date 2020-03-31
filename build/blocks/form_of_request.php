  <form id="send-requist-form" class="form-horizontal form-label-left input_mask" >
    <!--<div class="row">-->
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel" style="border: 0px;">
            <div class="x_content">
              <!-- Smart Wizard -->
              <div id="wizard" class="form_wizard wizard_horizontal">
                <ul class="wizard_steps" >
                  <li>
                    <a href="#step-1">
                      <span class="step_no">1</span>
                      <span class="step_descr">
                                        Шаг 1<br />
                                        <small>Давайте знакомиться</small>
                      </span>
                    </a>
                  </li>
                  <li>
                    <a href="#step-2">
                      <span class="step_no">2</span>
                      <span class="step_descr">
                                        Шаг 2<br />
                                        <small>Выбираем курс/курсы</small>
                       </span>
                    </a>
                  </li>
                  <li>
                    <a href="#step-3">
                      <span class="step_no">3</span>
                      <span class="step_descr">
                                        Шаг 3<br />
                                        <small>Отправка заявки</small>
                      </span>
                    </a>
                  </li>
                </ul>
    
                <div id="step-1" class="form-section">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Данные ребенка</h2>
                          <div class="clearfix"></div>
                        </div>
                        <input type="hidden" name="tutor" value="<?php echo ((isset($_GET['tutor']))?'1':'0')?>">
                        <div class="x_content">
                          <div class="col-xs-12 form-group has-feedback">
                              <input type="text" class="form-control has-feedback-left" required="required" name="surname" placeholder="Фамилия">
                              <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                          </div>
                          <div class="col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" required="required" name="name" placeholder="Имя">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                          </div>
                          <div class="col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" name="patronymic" placeholder="Отчество">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                          </div>
                          <div class="col-xs-12 form-group has-feedback">
                            <input type="date" class="date form-control has-feedback-left"  name="birth" required="required"  placeholder="Дата рождения" style="padding-right: 5px;">
                            <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                          </div>
                          <div class="col-xs-12 form-group select_class">
                            <label style="padding-left: 10px;">Класс (на предстоящий учебный год)</label>
                              <p>
                                
                                <?php 
                                for ($i=1;$i<=10;$i++)
                                {
                                  echo '<div>
                                          <span>'.$i.'</span> <input type="radio" class="flat" name="class_number" value="'.$i.'" />
                                        </div>';
                                }
                                if (isset($_GET['tutor']))
                                    { 
                                      echo '<div>
                                              <span>11</span> <input type="radio" class="flat" name="class_number" value="11" />
                                            </div>';
                                    }

                                    ?>

                              </p>
                          </div> 

                          <div class="col-xs-12 form-group select_class">
                             <label style="padding-left: 10px;">Посещали ли вы ранее курсы нашего технопарка?</label>
                              <p>                                
                                <div>
                                  <span>да</span> <input type="radio" class="flat" name="attend" value="1" />
                                </div>

                                <div>
                                  <span>нет</span> <input type="radio" class="flat" name="attend" value="0" />
                                </div>
                              </p>  
                          </div>
                          

                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Данные родителя/представителя</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <div class="col-xs-12 form-group has-feedback">
                              <input type="text" class="form-control has-feedback-left" required="required" name="parent" placeholder="Ф.И.О. полностью">
                              <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                          </div>
                          <div class="col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" placeholder="Телефон" required="" name="phone" data-parsley-pattern="8\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}" data-inputmask="'mask' : '8 (999) 999-99-99'">
                            <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                          </div>
                          <div class="col-xs-12 form-group has-feedback">
                            <input type="email" id="email" name="email" required="required" class="form-control has-feedback-left" id="inputSuccess3" placeholder="Email">
                            <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                          </div>
                        </div>
                      </div>
                    <div class="col-xs-12 checkbox">
                      <input type="checkbox" class="flat" checked="checked" disabled="disabled"> Нажимая на кнопку "Далее", я даю 
                      <a href="#" style="text-decoration: underline;" data-toggle="modal" data-target=".bs-example-modal-md">согласие на обработку персональных данных</a>

                      <div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">

                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                              </button>
                              <h4 class="modal-title" id="myModalLabel">Согласие на обработку персональных данных</h4>
                            </div>
                            
                            <div class="modal-body">
                              <p>Настоящим действием подтверждается согласие Заказчика Башкирскому государственному университету (Стерлитамакский филиал, СФ БашГУ), расположенному по адресу: г. Стерлитамак, пр. Ленина, д. 49, на автоматизированную, а также без использования средств автоматизации обработку персональных данных, а именно совершение действий, предусмотренных пунктом 3 части первой статьи 3 Федерального закона от 27 июля 2006 № 152-ФЗ "О персональных данных": сбор, систематизацию, накопление, хранение, уточнение (обновление, изменение), использование, распространение (передачу), обезличивание, блокировку и уничтожение сведений о Заказчике и Участнике: фамилия, имя, отчество; год, месяц, число и место рождения; паспортные данные, мобильный телефон.</p>
                               <p>Срок действия настоящего согласия на обработку персональных данных: с момента его подписания и до достижения целей обработки.</p> 
                               <p>В дальнейшем - в соответствии с законодательством об архивном деле в Российской Федерации.</p>
                               <p>Настоящее согласие может быть отозвано мной в письменной форме на основании заявления, поданного на имя директора СФ БашГУ.</p>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                    </div>  
                  </div> 
                </div>
                
                <div id="step-2" class="form-section">
                  

                </div>

                <div id="step-3" class="form-section">
                    <div class="row">
                      <div class="col-lg-12" style="float: unset;">
                        <h2 style="text-align: center;">Спасибо, Ваша заявка принята!</h2>
                        <h2 style="text-align: center;">Ожидайте письмо на почту.</h2>
                      </div>
                     </div>                                                 
                </div>
                  
              </div>
              <!-- End SmartWizard Content -->
            </div>
          </div>
      </div>
    <!--</div> row-->
        
        <!-- /page content -->
  </form>

    <style text="text/css">

    .actionBar
    {
      text-align: unset;
      border-top: 0px solid #ddd;
    }

    .actionBar .buttonNext.btn.btn-success, .buttonValidate.btn.btn-success
    {
      float: right
    }

    .actionBar .buttonNext.btn.btn-success
    {
      display: none;
    }

    .select_class 
    {
      padding-left: 0px;
    }

    .select_class span
    {
      margin-left: 15px;
      position: relative;
    }

    .select_class div
    {
      display: inline-block;
      margin-bottom: 5px;
    }

    .form-horizontal .checkbox 
    {
      padding-top: 2px;
    }

    .buttonFinish
    {
      float: right;
    }
        
    </style>