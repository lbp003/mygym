<?php
// include_once '../config/session.php';
class Role{
    // Staff Module
    const MANAGE_STAFF = 1;
    const VIEW_STAFF = 2;

    // Member Module
    const MANAGE_MEMBER = 3;
    const VIEW_MEMBER = 4;
    
    // Login Log
    const VIEW_STAFF_LOGIN_LOG = 5;
    const VIEW_MEMBER_LOGIN_LOG = 6;

    // PAyment
    const VIEW_PAYMENT = 7;
    const MANAGE_PAYMENT = 8;

    // package
    const VIEW_PACKAGE = 9;
    const MANAGE_PACKAGE = 10;

    // class
    const VIEW_CLASS = 11;
    const MANAGE_CLASS = 12;

    // class shedule
    const VIEW_CLASS_SESSION = 13;
    const MANAGE_CLASS_SESSION = 14;

    // equipment
    const VIEW_EQUIPMENT = 15;
    const MANAGE_EQUIPMENT = 16;

    // subscription
    const VIEW_SUBSCRIPTION = 17;
    const MANAGE_SUBSCRIPTION = 18;

    // workout
    const VIEW_WORKOUT = 19;
    const MANAGE_WORKOUT = 26;

    // report
    const VIEW_REPORT = 20;
    const MANAGE_REPORT = 21;

    // message
    const VIEW_MESSAGE = 22;
    const MANAGE_MESSAGE = 23;

    // event
    const VIEW_EVENT = 24;
    const MANAGE_EVENT = 27;

    // backup
    const MANAGE_BACKUP = 25;

    //Access
    const UNAUTHORIZED_ACCESS = "UNAUTHORIZED ACCESS";

    public static function getPermissionList($staff_id){
        $con = $GLOBALS['con'];
        $sql = "SELECT role_id
                FROM staff_role
                WHERE staff_id = '$staff_id'";
        $result=$con->query($sql);
        return $result;         
    }

    public static function checkPermissions($permissionLevels = []){
        $userPermission = $_SESSION['permission'];
        // print_r($userPermission); exit;
        foreach($permissionLevels as $permission){
            if (!in_array($permission,$userPermission))
                return false; // if one is missing decline
        }
        return true; // if got here mean all found
    }
    
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

