<?php
require_once 'connection.php';
$db = new Db_Connect();
$conn = $db->connect();
$conn->set_charset('utf8');

$response = array("error" => FALSE);

$query = "SELECT * FROM directions WHERE tutor = 0"; //0 - курсы
$result = $conn->query($query);
if (!$result){
    $response["error"] = TRUE;
    $response["error_msg"] = "DB не содержит нужных данных!";
} else {
    $response["s_count"] = $result->num_rows;
    $s_count = 0;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $s_count++;
        $id_directions = $row["id_directions"];
        $response["school_".$s_count]["info"]["s_name"] = $row["name_of_directions"];
        $response["school_".$s_count]["info"]["s_desc"] = $row["description"];
        $query = "SELECT * FROM courses WHERE id_directions = $id_directions ORDER by level";
        $res_cs = $conn->query($query);
        if (!$res_cs){
            $response["school_".$s_count]["info"]["c_count"] = 0;
        } else {
            $response["school_".$s_count]["info"]["c_count"] = $res_cs->num_rows;
            $c_count = 0;
            while ($row_cs = mysqli_fetch_array($res_cs, MYSQLI_ASSOC)) {
                $c_count++;
                $id_courses = $row_cs["id_courses"];
                $response["school_".$s_count]["course".$c_count]["c_id"] = $row_cs["id_courses"];
                $response["school_".$s_count]["course".$c_count]["c_name"] = $row_cs["name_of_course"];
                $response["school_".$s_count]["course".$c_count]["c_desc"] = $row_cs["description"];
                $query = "SELECT * FROM price WHERE id_courses = $id_courses";
                $res_pr = $conn->query($query);
                if (!$res_pr){
                    $response["school_".$s_count]["course".$c_count]["c_price"] = 0;
                } else {
                    $response["school_".$s_count]["course".$c_count]["c_price"] = mysqli_fetch_array($res_pr, MYSQLI_ASSOC)["price"];
                    if ($response["school_".$s_count]["course".$c_count]["c_price"] == null){
                        $response["school_".$s_count]["course".$c_count]["c_price"] = 0;
                    }
                }
            }
        }
    }
}
$conn->close();
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>