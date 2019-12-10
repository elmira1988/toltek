<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['l_name']) && isset($_POST['f_name']) && isset($_POST['uid'])) {
 
    $uid = $_POST['uid'];

    $l_name = $_POST['l_name'];
    $f_name = $_POST['f_name'];
    $m_name = $_POST['m_name'];
    $mw_s = $_POST['mw_s'];
    $birth = $_POST['birth'];
    $phone = $_POST['phone'];

    $p_l_name = $_POST['p_l_name'];
    $p_f_name = $_POST['p_f_name'];
    $p_m_name = $_POST['p_m_name'];
    $p_mail = $_POST['p_mail'];
    $p_phone = $_POST['p_phone'];
 
    // check if user is already existed with the same uid
    if (!$db->isUIDExisted($uid)) {
        $response["error"] = TRUE;
        $response["error_msg"] = "User don't exists with uid " . $uid;
        echo json_encode($response);
    } else {
        // update user info
        $result = $db->setUserInfoByUID($uid, $l_name, $f_name, $m_name, $phone, $mw_s, $birth, $p_l_name, $p_f_name, $p_m_name, $p_phone, $p_mail);
        if ($result) {
            // info updated successfully
            $user = $db->getUserInfoByUID($uid);
            if ($user){
                $response["error"] = FALSE;
                /*
                $response["user"]["l_name"] = $user["l_name"];
                $response["user"]["f_name"] = $user["f_name"];
                $response["user"]["m_name"] = $user["m_name"];
                $response["user"]["mw_s"] = $user["mw_s"];
                $response["user"]["birth"] = $user["birth"];
                $response["user"]["phone"] = $user["phone"];
                $response["parent"]["p_l_name"] = $user["p_l_name"];
                $response["parent"]["p_f_name"] = $user["p_f_name"];
                $response["parent"]["p_m_name"] = $user["p_m_name"];
                $response["parent"]["p_mail"] = $user["p_mail"];
                $response["parent"]["p_phone"] = $user["p_phone"];
                */
                echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Unknown error occurred in read user info!";
                echo json_encode($response);
            }
        } else {
            // info failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in update info!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (l_name and f_name) is missing!";
    echo json_encode($response);
}
?>