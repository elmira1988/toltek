<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['uid'])) {
 
    $uid = $_POST['uid'];
 
    // get the user info by uid
    $info = $db->getUserInfoByUID($uid);
 
    if ($info != false) {
        $response["error"] = FALSE;
        $response["user"]["l_name"] = $info["l_name"];
        $response["user"]["f_name"] = $info["f_name"];
        $response["user"]["m_name"] = $info["m_name"];
        $response["user"]["mw_s"] = $info["mw_s"];
        $response["user"]["birth"] = $info["birth"];
        $response["user"]["phone"] = $info["phone"];
        $response["parent"]["p_l_name"] = $info["p_l_name"];
        $response["parent"]["p_f_name"] = $info["p_f_name"];
        $response["parent"]["p_m_name"] = $info["p_m_name"];
        $response["parent"]["p_mail"] = $info["p_mail"];
        $response["parent"]["p_phone"] = $info["p_phone"];
        echo json_encode($response);
    } else {
        // user is not found
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter uid is missing!";
    echo json_encode($response);
}
?>