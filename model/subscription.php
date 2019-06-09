<?php

class Subscription{

     //subscription status
     CONST ACTIVE = "A";
     CONST INACTIVE = "I";
     CONST DELETED = "D";
     CONST SUSPENDED = "S";

     //payment status
     CONST PAID = "P";
     CONST LATE = "L";

     /** 
	* Get All Subscription Details
	* @return object $result 
	*/
    public static function displayAllSubscription(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  membership.membership_id,
                        CONCAT(' ',member.first_name,member.last_name),
                        package.package_name,
                        membership.start_date,
                        membership.end_date,
                        membership.last_paid_date,
                        membership.status,
                        membership.payment_status,
                        CONCAT(' ',staff.first_name,staff.last_name)
                FROM membership
                INNER JOIN staff ON membership.updated_by = staff.staff_id
                INNER JOIN member ON membership.member_id = member.member_id
                INNER JOIN package ON membership.package_id = package.package_id
                WHERE member.member_id != 'D'   
                ORDER BY membership.membership_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    function addMembership($member_id,$package_id,$end_time){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO membership VALUES('',$member_id,'$package_id',CURDATE(),'$end_time','Active',NOW(),NOW())";
        $result=$con->query($sql);
        $membership_id=$con->insert_id;
        return $membership_id;
        
        
    }
    
    function updateMembership($membership_title,$membership_date,$membership_venue,$membership_description,$membership_id){
        $con = $GLOBALS['con'];
        $sql="UPDATE membership SET membership_title='$membership_title',membership_date='$membership_date',membership_venue='$membership_venue',membership_description='$membership_description' WHERE membership_id='$membership_id'";
        $result=$con->query($sql);
    }
    
    function updateMembershipImage($membership_id,$new_image){
        $con=$GLOBALS['con'];
        $sql="UPDATE membership SET membership_image='$new_image' WHERE membership_id='$membership_id'";
        $result =$con->query($sql);
    }
    
    function activateMembership($membership_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE membership SET membership_status='Active' WHERE membership_id='$membership_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivateMembership($membership_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE membership SET membership_status='Deactive' WHERE membership_id='$membership_id'";
        $result=$con->query($sql);
        return $result;
    }
            
    function displayMembership($membership_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM membership WHERE membership_id='$membership_id'";
        $result=$con->query($sql);
        return $result;
    }
   
}