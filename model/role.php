<?php
class Role{

    CONST SUPER_ADMIN = "S";
    CONST ADMIN = "A";
    CONST MANAGER = "M";
    CONST TRAINER = "T";
    CONST MEMBER = "M";
    
    public static function viewRoleModule($role_id){
        $con=$GLOBALS['con'];
        $sql="SELECT * 
              FROM module_role r,module m 
              WHERE role_id='$role_id' 
              AND r.module_id=m.module_id";
        $result=$con->query($sql);
        return $result; 
        
    }
    function viewRole(){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM role";
        $result=$con->query($sql);
        return $result;               
    }
    
    function viewTrainers(){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM staff WHERE role_id=3";
        $result=$con->query($sql);
        return $result;
    }
    
    function viewAnatomy(){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM anatomy";
        $result=$con->query($sql);
        return $result;
    }
    function findStaffId($toStaff){
        $con=$GLOBALS['con'];
        $sql="SELECT staff_id FROM staff WHERE staff_email='$toStaff'";
        $result=$con->query($sql);
        return $result;
    }
    function findMemberId($toMember){
        $con=$GLOBALS['con'];
        $sql="SELECT member_id FROM member WHERE member_email='$toMember'";
        $result=$con->query($sql);
        return $result;
    }
    function viewCategory(){
        $con = $GLOBALS['con'];
        $sql="SELECT * FROM category";
        $result=$con->query($sql);
        return $result;
    }
}
?>

