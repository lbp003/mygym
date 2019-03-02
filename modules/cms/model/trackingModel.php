<?php

class tracking{
    
    function displayAllStaffLogs(){
        $con=$GLOBALS['con']; //To get connection string
        $sql="SELECT * FROM staff s, staff_log sl WHERE s.staff_id=sl.staff_id ORDER BY sl.log_id DESC";
        $result=$con->query($sql);
        return $result;
        
    }
    
        function displayAllMemberLogs(){
        $con=$GLOBALS['con']; //To get connection string
        $sql="SELECT * FROM member m, member_log ml WHERE m.member_id=ml.member_id ORDER BY ml.log_id DESC";
        $result=$con->query($sql);
        return $result;
        
    }
    
    
}

?>