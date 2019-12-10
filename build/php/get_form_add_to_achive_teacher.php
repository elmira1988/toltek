  <?php 
  require_once("functions.php");
  
  $str='<h4>Добавить в архив преподавателя</h4>';

  $str.='<input type="hidden" name="id_teachers" value="'.$_POST['id_teachers'].'">';

  $str.='<div class="row" style="margin-top:20px;">';
    $str.='<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Комментарий</label>';
    $str.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
      $str.='<textarea class="form-control" name="note" style="margin-bottom: 10px;"></textarea>';
    $str.='</div>';
  
  echo $str;
   ?>
  
 
    

      
      
   