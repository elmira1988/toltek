<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mail']) && isset($_POST['pass'])) {
 
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
 
    // get the user by email and password
    $user = $db->getUserByEmailAndPassword($mail, $pass);
 
    if ($user != false) {
        $response["error"] = FALSE;
        $response["uid"] = $user["uid"];
        $response["user"]["l_name"] = $user["l_name"];
        $response["user"]["f_name"] = $user["f_name"];
        $response["user"]["mw_s"] = $user["mw_s"];
        $response["user"]["mail"] = $user["mail"];
        
        $info = $db->getUserInfoByUID($user["uid"]);
        $response["user"]["m_name"] = $info["m_name"];
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
    $response["error_msg"] = "Required parameters mail or pass is missing!";
    echo json_encode($response);
}
?>