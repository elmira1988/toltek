<?php 

require_once("functions.php");

$data=json_decode($_POST['str'],true);

print_r($data);
//print_r($_FILES);

//print_r($data); 

$teacher=$data['teacher'];
$arr=get_array_key_value($teacher);	


//сохраняем изображение в папке photo
$file_name="";

if (count($_FILES)!=0)
{
	$file_name=end(explode('/',$_FILES['img']['tmp_name'])).'.'.explode('/',$_FILES['img']['type'])[1];
	move_uploaded_file($_FILES["img"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/photo/".$file_name);
}

$query="INSERT INTO `teachers` (".implode(",",$arr[0]).",`photo`) VALUES (".implode(",",$arr[1]).",'".$file_name."')";

//echo $query;

//сохранеяем данные учителя
if ($id_teachers=save_data($query)) 
{
	echo $id_teachers;
}
else
{
	echo false;
}

 ?>