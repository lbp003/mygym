<?php

class Log{

    //Log In and Log Out
    CONST LOGIN = "I";
    CONST LOGOUT = "O";
    
    /* Get all staff log info
	* @return object $result
	*/
    public static function displayAllStaffLogs(){
        $con=$GLOBALS['con']; //To get connection string
        $sql="  SELECT  staff_log.log_id,
                        staff_log.log_in,
                        staff_log.log_out,
                        staff_log.log_ip,
                        staff_log.status,
                        CONCAT_WS(' ',staff.first_name,staff.last_name) AS name
                FROM staff_log 
                INNER JOIN staff ON staff_log.staff_id = staff.staff_id
                WHERE 1=1 
                ORDER BY staff_log.log_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    /* Get all member log
	* @return object $result
	*/
    public static function displayAllMemberLogs(){
        $con=$GLOBALS['con']; //To get connection string
        $sql="  SELECT  member_log.log_id,
                        member_log.log_in,
                        member_log.log_out,
                        member_log.log_ip,
                        member_log.status,
                        CONCAT_WS(' ',member.first_name,member.last_name) AS name
                FROM member_log
                INNER JOIN member ON member_log.member_id = member.member_id
                WHERE 1=1 
                ORDER BY member_log.log_id DESC";
        $result=$con->query($sql);
        return $result;   
    }

    /* Insert a staff login record
	* @return int $log_id
	*/
    public static function insertMemberLog($log_ip,$member_id){
        $log_in  = date('Y-m-d H:i:s', time());
        $status = self::LOGIN;

        $con=$GLOBALS['con'];
        $stmt = $con->prepare("INSERT INTO member_log (log_in, log_ip, status, member_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $log_in, $log_ip, $status, $member_id);
        $stmt->execute();
        $log_id = $con->insert_id;
        return $log_id;
    }
    
    /* Update member logout record
	*/
    public static function updateMemberLog($log_id){

        $log_out  = date('Y-m-d H:i:s', time());
        $status = self::LOGOUT;

        $con=$GLOBALS['con']; 
        $sql = "UPDATE member_log SET log_out = ?, status= ? WHERE log_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi", $log_out, $status, $log_id);
        $stmt->execute();
    }
    
    /* Insert a staff login record
	* @return int $log_id
	*/
    public static function insertStaffLog($log_ip,$staff_id){

        $log_in  = date('Y-m-d H:i:s', time());
        $status = self::LOGIN;

        $con=$GLOBALS['con'];
        $stmt = $con->prepare("INSERT INTO staff_log (log_in, log_ip, status, staff_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $log_in, $log_ip, $status, $staff_id);
        $stmt->execute();
        $log_id = $con->insert_id;
        return $log_id;
    }

    /* Update staff logout record
	*/
    public static function updateStaffLog($log_id){
       
        $log_out  = date('Y-m-d H:i:s', time());
        $status = self::LOGOUT;

        $con=$GLOBALS['con']; 
        $sql = "UPDATE staff_log SET log_out = ?, status= ? WHERE log_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi", $log_out, $status, $log_id);
        $stmt->execute();
    }
     
}

?>