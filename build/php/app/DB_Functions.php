<?php
class DB_Functions {
    private $conn;

    function __construct() {
        require_once 'connection.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        $this->conn->set_charset('utf8');
    }
    
    public function saveUserRequest($user_id, $course_id) {
        
        $stmt = $this->conn->prepare("SELECT * FROM app_requests WHERE app_requests.user_uid = ? and app_requests.course_id = ?");
        $stmt->bind_param("ss", $user_id, $course_id);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // request existed 
            $stmt->close();
            return true;
        } else {
            // request not existed
            $stmt->close();
            $stmt = $this->conn->prepare("INSERT INTO app_requests(user_uid, course_id) VALUES(?, ?)");
            $stmt->bind_param("ss", $user_id, $course_id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        
    }

    public function storeUser($l_name, $f_name, $mail, $mw_s, $pass) {
        $uid = uniqid('', true);
        $hash = $this->hashSSHA($pass);
        $pass = $hash["encrypted"];
        $salt = $hash["salt"];
 
        $stmt = $this->conn->prepare("INSERT INTO app_users(uid, l_name, f_name, mail, mw_s, pass, salt) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $uid, $l_name, $f_name, $mail, $mw_s, $pass, $salt);
        $result = $stmt->execute();
        $stmt->close();
 
        // check for successful store
        if ($result) {
            //добавление строки в таблицу app_parents
            $stmt = $this->conn->prepare("INSERT INTO app_parents(user_uid) VALUES(?)");
            $stmt->bind_param("s", $uid);
            $stmt->execute();
            $stmt->close();
            
            //получение информации о новом пользователе
            $stmt = $this->conn->prepare("SELECT * FROM app_users WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return false;
        }
    }
    
    public function getUserInfoByUID($uid) {
        $stmt = $this->conn->prepare("SELECT * FROM app_users, app_parents WHERE app_users.uid = ? and app_parents.user_uid = ?");
        $stmt->bind_param("ss", $uid, $uid);
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user; //данные из 2-ух таблиц
        } else {
            return false;
        }
    }
    
    public function getUserRequestsByUID($uid) {
        $stmt = $this->conn->prepare("SELECT * FROM app_requests, directions, courses, price WHERE app_requests.user_uid = ? and courses.id_courses = app_requests.course_id and directions.id_directions = courses.id_directions and price.id_courses = app_requests.course_id");
        $stmt->bind_param("s", $uid);
        if ($stmt->execute()) {
            $info = $stmt->get_result();
            $stmt->close();
            return $info; //данные из нескольких таблиц
        } else {
            return false;
        }
    }
    
    public function setUserInfoByUID($uid, $l_name, $f_name, $m_name, $phone, $mw_s, $birth, $p_l_name, $p_f_name, $p_m_name, $p_phone, $p_mail) {
        $stmt = $this->conn->prepare("UPDATE app_users SET l_name = ?, f_name = ?, m_name = ?, phone = ?, mw_s = ?, birth = ? WHERE uid = ?");
        $stmt->bind_param("sssssss", $l_name, $f_name, $m_name, $phone, $mw_s, $birth, $uid);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            $stmt = $this->conn->prepare("UPDATE app_parents SET p_l_name = ?, p_f_name = ?, p_m_name = ?, p_phone = ?, p_mail = ? WHERE user_uid = ?");
            $stmt->bind_param("ssssss", $p_l_name, $p_f_name, $p_m_name, $p_phone, $p_mail, $uid);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        
    }
    
    public function isUIDExisted($uid) {
        $stmt = $this->conn->prepare("SELECT mail FROM app_users WHERE uid = ?");
        $stmt->bind_param("s", $uid);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
 
    public function getUserByEmailAndPassword($mail, $pass) {
        $stmt = $this->conn->prepare("SELECT * FROM app_users WHERE mail = ?");
        $stmt->bind_param("s", $mail);
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            // verifying user password
            $salt = $user['salt'];
            $enc_pass = $user['pass'];
            $hash = $this->checkhashSSHA($salt, $pass);
            if ($enc_pass == $hash) {
                return $user;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
 
    public function isUserExisted($mail) {
        $stmt = $this->conn->prepare("SELECT mail FROM app_users WHERE mail = ?");
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
 
    public function hashSSHA($pass) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($pass . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $pass) {
        $hash = base64_encode(sha1($pass . $salt, true) . $salt);
        return $hash;
    }
}
?>