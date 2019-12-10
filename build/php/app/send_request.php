<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
$response = array("error" => FALSE);

if (isset($_POST['c_count'])) {
    $c_count = $_POST['c_count'];
    if ($c_count != 0) {
        $user_id = $_POST['user_id'];
        for ($i = 1; $i <= $c_count; $i++){
            $result = $db->saveUserRequest($user_id, $_POST["course_id".$i]);
            if (!$result) {
                $response["error"] = TRUE;
                $response["error_msg"] = "Error saving requests";
                break;
            }
        }
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Courses not checked!";
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (c_count) is missing!";
}


echo json_encode($response);
?>