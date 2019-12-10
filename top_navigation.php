<!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt=""><?php echo $_SESSION['name']; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="build/php/exit.php"><i class="fa fa-sign-out pull-right"></i> Выйти </a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                        <span>
                          <span>Владимир Меньшов</span>
                          <span class="time">3 часа назад</span>
                        </span>
                        <span class="message">
                          В сентябре хочу ходить на курсы Робототехники в ваше учебное учреждение...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                       <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                        <span>
                          <span>Юлия Никитина</span>
                          <span class="time">5 часов назад</span>
                        </span>
                        <span class="message">
                          Учусь в 9 классе. Хочу позаниматься у вас программированию...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                        <span>
                          <span>Дина Мавлетбердина</span>
                          <span class="time">10 часов назад</span> 
                        </span>
                        <span class="message">
                          После нового года хочу ходить к вам на программированиею Знаю Pascsl...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                        <span>
                          <span>Мария Кузьмина</span>
                          <span class="time">1 день назад</span>
                        </span>
                        <span class="message">
                         Не попала к вам с сентября, можно я сейчас начну ходить на Программирование...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>Посмотреть все заявки</strong> 
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->