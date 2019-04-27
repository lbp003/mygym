<?php

class membership{
    
    function displayAllMembership(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM membership ms,member m,package p WHERE ms.member_id = m.member_id AND ms.package_id = p.package_id ORDER BY ms.membership_id DESC";
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