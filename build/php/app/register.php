<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['l_name']) && isset($_POST['f_name']) && isset($_POST['mw_s']) && isset($_POST['mail']) && isset($_POST['pass'])) {
 
    $l_name = $_POST['l_name'];
    $f_name = $_POST['f_name'];
    $mw_s = $_POST['mw_s'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
 
    // check if user is already existed with the same email
    if ($db->isUserExisted($mail)) {
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $mail;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeUser($l_name, $f_name, $mail, $mw_s, $pass);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["uid"] = $user["uid"];
            $response["user"]["l_name"] = $user["l_name"];
            $response["user"]["f_name"] = $user["f_name"];
            $response["user"]["mail"] = $user["mail"];
            $response["user"]["mw_s"] = $user["mw_s"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, mail or pass) is missing!";
    echo json_encode($response);
}
?>