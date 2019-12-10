  <?php 
  require_once("functions.php");
 	
 	if (isset($_POST["data"]))
 	{
 		$arr=json_decode($_POST["data"],true);
 		//print_r($arr);
 		$groups=get_groups($arr); 
 	}
 	else
 	{
 		$groups=get_groups();
 	}

 ?>
  <!--Таблица с данными -->
 <h2 style="margin:0px" class="pull-right"><small>найдено записей:  <?php echo count($groups) ?></small></h2>
 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
     
      <div class="x_content">
        <table id="datatable-fixed-header" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th style="width:10%;">Уровень</th>
              <th style="min-width: 100px;width:20%">Группа</th>
              <th>Курс</th>
              <th>Учеников</th>        
              <th style="width:300px;max-width: 300px;">Детали</th>                     
            </tr>
          </thead>

          <tbody>
            <?php 
              
              
              if (count($groups)!=0)
              {
                foreach ($groups as $key => $val) {
                echo "<tr>";
                  echo "<td>".$val["level"]."</td>";
                  echo "<td>".$val["name_of_group"];
                  		echo "<br/><span class='edit_note' onclick='get_data_groups(".$val["id_groups"].")'><i class='fa fa-edit'></i>редактировать</span>";
                  echo "</td>";
                  echo '<td><i>'.$val['name_of_directions'].'</i><br><b> '.$val['name_of_course'].'</b></td>';
                  echo "<td><span onclick='modal_group_structure(".$val["id_groups"].",\"".$val["name_of_group"]."\")'>".count(get_students(array("id_groups" => array($val["id_groups"]), "achive" => array("false"))))."</span></td>"; 
                  echo "<td>".$val["note"]."</td>";
                echo "</tr>";
              }
              }
             ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>