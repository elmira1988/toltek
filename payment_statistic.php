<?php 
    session_name('toltek');
    session_start();
    if (isset($_SESSION['id_users']))
    {
      //$css=array("../build/css/all_requist.css");//,"../vendors/bootstrap/dist/css/less/modals.less"
      include "header_main.php";
      require_once("build/php/functions.php");
 ?>

  <body class="nav-md">
    <input type="hidden" name="role" value="<?php echo $_SESSION['id_roles']; ?>"> 
    <div class="container body">
      <div class="main_container">
        <?php
        include "menu.php"; 
        include "top_navigation.php";  
        ?>

        <!-- page content -->
         <div class="right_col" role="main">
          <?php
          if (page_status(explode('.php',basename(__FILE__))[0]))
          { ?>
            <div class="page-title">

              <div class="title_left">
                <h3>Статистика по выплатам</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Суммарный доход <small>по школам</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="myChart1" width="540" height="270" style="width: 540px; height: 270px;"></canvas>  
                  </div>
                </div>
              </div>

              <div class="col-lg-12">
               <div class="x_panel">
                  <div class="x_title">
                    <h2>Суммарный доход <small>по месяцам</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="myChart2" width="540" height="270" style="width: 540px; height: 270px;"></canvas>  
                  </div>
                </div>
              </div>

              </div>
            </div>
          <?php 
          }
          else
          {
            include("build/blocks/access_is_denied.html"); 
          }
           ?>
          

        </div>
        <!-- /page content -->
        <script>
        if (document.getElementById('myChart1')!=null)
        {
        var ctx1 = document.getElementById('myChart1').getContext('2d');
        var myChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Робот-ая шк.', 'Шк. прогр-ия', 'Констр. шк.', 'Угл. изуч. Мл. зв.', 'Угл. изуч. Ср. зв.', 'Угл. изуч. Ст. зв.'],
                datasets: [{
                    label: 'Доход',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var ctx2 = document.getElementById('myChart2').getContext('2d');
        var lineChart = new Chart(ctx2, {
        type: 'line',
        data: {
          labels: ["янв", "фев", "мар", "апр", "май", "июн", "июл", "авг","сен","окт","ноя","дек"],
          datasets: [{
          label: "Доход",
          backgroundColor: "rgba(38, 185, 154, 0.31)",
          borderColor: "rgba(38, 185, 154, 0.7)",
          pointBorderColor: "rgba(38, 185, 154, 0.7)",
          pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: "rgba(220,220,220,1)",
          pointBorderWidth: 1,
          data: [31, 74, 6, 39, 20, 85, 7,31, 74, 6, 39, 20]
          }]
        }
        });
      
      }
        </script>
<?php 
  include "footer_main.php";
}
else {
    header("Location: http://admin.toltekplus.ru/"); 
 } ?>