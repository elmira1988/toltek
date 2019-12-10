<?php
	/*
	$db = mysql_connect ("localhost","root","1234567") or die ("Cannot open!");
	mysql_select_db("toltek", $db) or die ("Cannot select db!");	
	mysql_query("SET NAMES 'UTF8'");
	mb_internal_encoding("UTF-8");
	*/

	$mysqli = new mysqli("localhost", "046013955_arimle", "arimLe", "toltekplus_adminnew");
	
	//$mysqli = new mysqli("213.108.4.66", "clouduser", "cloudpassword", "clouddb");

	if (mysqli_connect_error()) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
	}

	//echo 'Соединение установлено... ' . $mysqli->host_info . "\n"; 
	$mysqli->set_charset('utf8');
	//$mysqli->close();

	function get_raw($query)
	{
		global $mysqli;

		$mysqli_result=$mysqli->query($query);
		
		if ($mysqli_result)
		{
			
			while ($row = $mysqli_result->fetch_array(MYSQLI_ASSOC))
				{
					$tmp[] = $row;
				}

			/* очищаем результаты выборки */
			$mysqli_result->free();
			return $tmp;
		}
		else
		{
			/* очищаем результаты выборки */
			$mysqli_result->free();
			return NULL;
		}

	}
	
?>