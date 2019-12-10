<?php 

require_once("functions.php");
global $mysqli;

$data=json_decode($_POST["str"],true);
$teacher=$data['teacher'];

//сохраняем изображение в папке photo
$file_name="";

if (count($_FILES)!=0)
{
	$file_name=end(explode('/',$_FILES['img']['tmp_name'])).'.'.explode('/',$_FILES['img']['type'])[1];
	move_uploaded_file($_FILES["img"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/photo/".$file_name);
	$teacher['photo']=$file_name;
}

$query=" UPDATE  `teachers` SET  ".get_set_string($teacher, array("`id_teachers`"))." WHERE  `id_teachers` =".$teacher['id_teachers'];

if ($mysqli->query($query))
{
	echo true;
}
else
{
	echo false;
}

 ?>