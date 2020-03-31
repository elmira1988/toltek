<?php 

require_once("functions.php");
global $mysqli;
//print_r($_POST);

$data=json_decode($_POST["str"],true);

print_r($data);
   
$student=$data['student'];
$id_groups=$data['id_groups'];
$parents=$data['parents'];

//сохраняем изображение в папке photo
$file_name="";

if (count($_FILES)!=0)
{
	$file_name=end(explode('/',$_FILES['img']['tmp_name'])).'.'.explode('/',$_FILES['img']['type'])[1];
	move_uploaded_file($_FILES["img"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/photo/".$file_name);
	$student['photo']=$file_name;
}

$query=" UPDATE  `students` SET  ".get_set_string($student, array("`id_students`"))." WHERE  `id_students` =".$student['id_students'];
//echo $query;

if ($mysqli->query($query))
{
	//удаляем представителей
	$arr_parents=array();
	for ($i=0;$i<count($parents);$i++)
	{
		if ($parents[$i]["id_parents"]!="")	array_push($arr_parents,$parents[$i]["id_parents"]);
	}

	$query=" DELETE FROM  `parents` WHERE  `parents`.`id_parents` IN ( ";
		$query.=" SELECT  `id_parents` ";
			$query.=" FROM ( ";
			$query.=" SELECT  `id_parents` ";
			$query.=" FROM  `parents`  ";
			$query.=" WHERE  `id_students` =".$student["id_students"];
			$query.=" AND  `id_parents` NOT ";
			$query.=" IN ( ".implode(",",$arr_parents)." ) ";
			$query.=" ) AS t ";
		$query.=")";

	if ($mysqli->query($query))
	{
		
		for ($i=0;$i<count($parents);$i++)
		{
			//редактируем данные существующих представителей
			if ($parents[$i]['id_parents']!="")
			{
				$query=" UPDATE  `parents` SET  ".get_set_string($parents[$i],array("`id_parents`"))." WHERE  `id_parents` =".$parents[$i]['id_parents'];
				
			 	//echo $query;
				if (!$mysqli->query($query))
				{
					echo false; 
					break;
				}
			}
			else
			{
				//добавляем новых представителей
				unset($parents[$i]["id_parents"]);
				$arr=get_array_key_value($parents[$i]);	
				
				array_push($arr[0],"`id_students`");
				array_push($arr[1],"'".$student["id_students"]."'");	
				if (!save_data("INSERT INTO `parents` (".implode(",",$arr[0]).") VALUES (".implode(",",$arr[1]).")"))
				{
					echo false; 
					break;
				}


				unset($arr);
			}
		}
	}
	else
	{
		echo false;
	}
}
else
{
	echo false;
}

 ?>