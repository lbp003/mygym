<?php

class Log{
    
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

    public static function insertLogMember($log_ip,$member_id){
        $con=$GLOBALS['con'];
        $sql="INSERT INTO member_log VALUES('',NOW(),'','$log_ip','in','$member_id')";
        $result=$con->query($sql);
        $log_id=$con->insert_id;
        return $log_id;
    }
    
    public static function updateLogMember($log_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE member_log SET log_out=NOW(),log_status='out' WHERE log_id='$log_id'";
        $result=$con->query($sql);
    }
    
    public static function insertStaffLog($log_ip,$staff_id){
        $con=$GLOBALS['con'];
        $sql="INSERT INTO staff_log VALUES('',NOW(),'','$log_ip','I','$staff_id')";
        $result=$con->query($sql);
        $log_id=$con->insert_id;
        return $log_id;
    }

    public static function updateStaffLog($log_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE staff_log SET log_out=NOW(),log_status='O' WHERE log_id='$log_id'";
        $result=$con->query($sql);
    }
     
}

?>