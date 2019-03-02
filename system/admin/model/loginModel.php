<?php

//Login class
class Login{
    //To check user name and password of Staff
    function validateLoginStaff($u,$p){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM login_staff l,staff s,role r WHERE l.staff_email='$u' AND l.password='$p' AND s.staff_id=l.staff_id AND s.role_id = r.role_id";
        $result=$con->query($sql);
        return $result;
    }
        //To check user name and password of Staff
    function validateLoginMember($u,$p){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM login_member l,member m,role r WHERE l.member_email='$u' AND l.password='$p' AND m.member_id=l.member_id AND m.role_id = r.role_id";
        $result=$con->query($sql);
        return $result;
    }
    function addStaffLogin($staff_email,$staff_id){
        $con=$GLOBALS['con'];//To get connection string
        $password=sha1("123");//Default password
        $sql="INSERT INTO login_staff VALUES('$staff_email','$password','$staff_id','Active')";//To execute the query
        $result=$con->query($sql);
        $staff_id=$con->insert_id;
        return $staff_id;
        
    }
        function addMemberLogin($member_email,$password,$member_id){
        $con=$GLOBALS['con'];//To get connection string
        //$password=sha1("123");//Default password
        $sql="INSERT INTO login_member VALUES('$member_email','$password','$member_id','Active')";//To execute the query
        $result=$con->query($sql);
        $member_id=$con->insert_id;
        return $member_id;
        
    }
    
    function addOnlineMemberLogin($email,$pass,$member_id){
        $con=$GLOBALS['con'];//To get connection string
        $sql="INSERT INTO login_member VALUES('$email','$pass','$member_id','Active')";//To execute the query
        $result=$con->query($sql);
        $member_id=$con->insert_id;
        return $member_id;
        
    }
    //Activate and deactivate member login
    function activateMemberLogin($member_id){
      $con=$GLOBALS['con'];//To get connection string
      $sql="UPDATE login_member SET login_status='Active' WHERE member_id='$member_id'";
      $result=$con->query($sql);
      return $result;
    }
    
    function deactivateMemberLogin($member_id){
       $con=$GLOBALS['con'];//To get connection string
       $sql="UPDATE login_member SET login_status='Deactive' WHERE member_id='$member_id'";
       $result=$con->query($sql);
       return $result;
    }
    
     //Activate and deactivate staff login
     function activateStaffLogin($staff_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE login_staff SET login_status='Active' WHERE staff_id='$staff_id'";
        $result=$con->query($sql);
        return $result;
     }
     
     function deactivateStaffLogin($staff_id){
         $con=$GLOBALS['con'];
         $sql="UPDATE login_staff SET login_status='Deactive' WHERE staff_id='$staff_id'";
         $result=$con->query($sql);
         return $result;
     }
     
     // check current password
     function checkStaffPW($staff_id,$currentE_check){
         $con=$GLOBALS['con'];
         $sql="SELECT staff_id FROM login_staff WHERE staff_id='$staff_id' && password='$currentE_check'";
         $result=$con->query($sql);
         return $result;
     }
     
     function updateStaffPW($staff_id,$newE_pw){
         $con=$GLOBALS['con'];
         $sql="UPDATE login_staff SET password='$newE_pw' WHERE staff_id='$staff_id'";
         $result=$con->query($sql);
         return $result;
     }

     function checkMemberPW($member_id,$currentE_check){
         $con=$GLOBALS['con'];
         $sql="SELECT member_id FROM login_member WHERE member_id='$member_id' && password='$currentE_check'";
         $result=$con->query($sql);
         return $result;
     }

     function updateMemberPW($member_id,$newE_pw){
         $con=$GLOBALS['con'];
         $sql="UPDATE login_member SET password='$newE_pw' WHERE member_id='$member_id'";
         $result=$con->query($sql);
         return $result;
     }
}

//class module{
//    
//    function getModule($role_id){
//        $con=$GLOBALS['con']; //To get connection string
//        $sql="SELECT * FROM module_role WHERE role_id='$role_id'";
//        $result=$con->query($sql); //To excute the query
//        $arr=array();
//        while($row=$result->fetch_assoc()){
//            array_push($arr, $row['module_id']);
//            
//        }
//        
//        return $arr;
//    }
//    
//}


class log{
    
    function insertLogMember($log_ip,$member_id){
        $con=$GLOBALS['con'];
        $sql="INSERT INTO member_log VALUES('',NOW(),'','$log_ip','in','$member_id')";
        $result=$con->query($sql);
        $log_id=$con->insert_id;
        return $log_id;
    }
    
    function updateLogMember($log_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE member_log SET log_out=NOW(),log_status='out' WHERE log_id='$log_id'";
        $result=$con->query($sql);
    }
    
    function insertLogStaff($log_ip,$staff_id){
        $con=$GLOBALS['con'];
        $sql="INSERT INTO staff_log VALUES('',NOW(),'','$log_ip','in','$staff_id')";
        $result=$con->query($sql);
        $log_id=$con->insert_id;
        return $log_id;
    }
    function updateLogStaff($log_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE staff_log SET log_out=NOW(),log_status='out' WHERE log_id='$log_id'";
        $result=$con->query($sql);
    }
    
}
