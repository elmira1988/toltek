<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

if (isset($_POST['uid'])) {
 
    $uid = $_POST['uid'];
 
    $info = $db->getUserRequestsByUID($uid);
 
    if ($info != false) {
        $response["error"] = FALSE;
        $c_count = 0;
        while ($row = $info->fetch_assoc()) {
            $c_count++;
            $response["course_".$c_count]["c_id"] = $row["course_id"];
            $response["course_".$c_count]["r_date"] = $row["date"];
            $response["course_".$c_count]["status"] = $row["status"];
            $response["course_".$c_count]["name"] = $row["name_of_course"];
            $response["course_".$c_count]["level"] = $row["level"];
            $response["course_".$c_count]["desc"] = $row["description"];
            $response["course_".$c_count]["school"] = $row["name_of_directions"];
            $response["course_".$c_count]["price"] = $row["price"];
            $response["course_".$c_count]["b_date"] = $row["date_begin"];
            $response["course_".$c_count]["e_date"] = $row["date_end"];
        }
        $response["c_count"] = $c_count;
    } else {
        // info is not found
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter uid is missing!";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>