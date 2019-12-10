<?php 

require_once("functions.php");

$data=json_decode($_POST['str'],true);

//print_r($data);
//print_r($_FILES);

//print_r($data);

$student=$data['student'];
$month_begin=$student["month_begin"][0];
$month_end=$student["month_end"][0];
unset($student["month_begin"]);
unset($student["month_end"]); 
$id_groups=$data['id_groups'];
$parents=$data['parents'];


$arr=get_array_key_value($student);	


//сохраняем изображение в папке photo
$file_name="";

if (count($_FILES)!=0)
{
	$file_name=end(explode('/',$_FILES['img']['tmp_name'])).'.'.explode('/',$_FILES['img']['type'])[1];
	move_uploaded_file($_FILES["img"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/photo/".$file_name);
}

$query="INSERT INTO `students` (".implode(",",$arr[0]).",`photo`) VALUES (".implode(",",$arr[1]).",'".$file_name."')";

//echo $query;

//сохранеяем данные студента
if ($id_students=save_data($query)) 
{
	//закрепляем студента за группами
	for ($i=0;$i<count($id_groups);$i++) 
	{
		save_data("INSERT INTO `students_groups` (`id_students`,`id_groups`,`year`,`months_of_study`) VALUE ($id_students,$id_groups[$i],".$GLOBALS['year'].",'".implode(",",get_months_between($month_begin,$month_end))."')"); 
	}

	//сохраняем и закрепляем представителей 
	for ($i=0;$i<count($parents);$i++)
	{
		unset($arr);
		$arr=get_array_key_value($parents[$i]);	

		array_push($arr[0],"`id_students`");
		array_push($arr[1],"'".$id_students."'");	
		save_data("INSERT INTO `parents` (".implode(",",$arr[0]).") VALUES (".implode(",",$arr[1]).")"); 
	}


	echo true;
}
else
{
	echo false;
}

 ?>