<?php
class Staff{

    // User Types of the system
    CONST SUPER_ADMIN = "S";
    CONST ADMIN = "A";
    CONST MANAGER = "M";
    CONST TRAINER = "T";
    
    public static function displayAllStaff(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  staff.first_name,
                        staff.last_name 
                FROM staff 
                WHERE 1=1
                ORDER BY staff_id DESC";
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
            
    function checkEmail($email){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM staff WHERE staff_email='$email'";
        $result=$con->query($sql);
        return $result;
        
    }
    
    function displayStaff($staff_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM staff s,role r WHERE s.role_id=r.role_id AND staff_id='$staff_id'";
        $result=$con->query($sql);
        return $result;
    }
   
}