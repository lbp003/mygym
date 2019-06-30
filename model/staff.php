<?php
include_once 'role.php';
class Staff{

    // User Types of the system
    CONST SUPER_ADMIN = "S";
    CONST ADMIN = "A";
    CONST MANAGER = "M";
    CONST TRAINER = "T";

    //staff status
    CONST ACTIVE = "A";
    CONST INACTIVE = "I";
    CONST DELETED = "D";
    CONST SUSPENDED = "S";

    private static $adminAr = [Role::MANAGE_STAFF,Role::VIEW_STAFF];
    private static $managerAr = [];
    private static $trainerAr = [];
    
    /** 
	* Get All Staff Details
	* @return object $result 
	*/
    public static function displayAllStaff(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT 
                    staff.staff_id,
                    staff.first_name,
                    staff.last_name,
                    staff.email,
                    staff.address,
                    staff.gender,
                    staff.dob,
                    staff.telephone,
                    staff.staff_type,
                    staff.image,
                    staff.status
                FROM staff 
                WHERE staff.status != 'D'
                ORDER BY staff.staff_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    function addStaff($staff_fname,$staff_lname,$staff_email,$gender,$dob,$nic,$staff_tel,$address,$role_id,$staff_image){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO staff VALUES('','$staff_fname','$staff_lname','$staff_email','$gender','$dob','$nic','$staff_tel','$address','$role_id','$staff_image','Active')";
        $result=$con->query($sql);
        $staff_id=$con->insert_id;
        return $staff_id;
        
        
    }
    
    function updateStaff($staff_fname,$staff_lname,$gender,$dob,$nic,$staff_tel,$address,$role_id,$staff_id){
        $con = $GLOBALS['con'];
        $sql="UPDATE staff SET staff_fname='$staff_fname',staff_lname='$staff_lname',gender='$gender',dob='$dob',nic='$nic',staff_tel='$staff_tel',address='$address',role_id='$role_id' WHERE staff_id='$staff_id'";
        $result=$con->query($sql);
    }
    
    function updateStaffImage($staff_id,$new_image){
        $con=$GLOBALS['con'];
        $sql="UPDATE staff SET staff_image='$new_image' WHERE staff_id='$staff_id'";
        $result=$con->query($sql);
    }
    
    function activateStaff($staff_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE staff SET staff_status='Active' WHERE staff_id='$staff_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivateStaff($staff_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE staff SET staff_status='Deactive' WHERE staff_id='$staff_id'";
        $result=$con->query($sql);
        return $result;
    }
            
    public static function checkEmail($email){
        $con=$GLOBALS['con'];
        $sql="  SELECT staff.email 
                FROM staff 
                WHERE staff.email='$email' 
                AND staff.status != 'D'";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }
    
    function displayStaff($staff_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM staff s,role r WHERE s.role_id=r.role_id AND staff_id='$staff_id'";
        $result=$con->query($sql);
        return $result;
    }
   
}