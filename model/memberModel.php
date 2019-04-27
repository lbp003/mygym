<?php

class member{
    
    function displayAllMember(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM member m, role r WHERE m.role_id=r.role_id ORDER BY m.member_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    function addMember($member_fname,$member_lname,$member_email,$gender,$dob,$nic,$member_tel,$address,$member_image){
        
    $con=$GLOBALS['con']; 
    $sql="INSERT INTO member VALUES('','$member_fname','$member_lname','$member_email','$gender','$dob','$nic','$member_tel','$address',4,'$member_image','Active')";
    $result=$con->query($sql);
    $member_id=$con->insert_id;
    return $member_id; //return last inserted id
    }
    
    function updateMember($member_fname,$member_lname,$gender,$dob,$nic,$member_tel,$address,$member_id){
        $con = $GLOBALS['con'];
        $sql="UPDATE member SET member_fname='$member_fname',member_lname='$member_lname',gender='$gender',dob='$dob',nic='$nic',member_tel='$member_tel',address='$address' WHERE member_id='$member_id'";
        $result=$con->query($sql);
    }
    
    function updateMemberImage($member_id,$new_image){
        $con=$GLOBALS['con'];
        $sql="UPDATE member SET member_image='$new_image' WHERE member_id='$member_id'";
        $result =$con->query($sql);
    }
    
    function activateMember($member_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE member SET member_status='Active' WHERE member_id='$member_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivateMember($member_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE member SET member_status='Deactive' WHERE member_id='$member_id'";
        $result=$con->query($sql);
        return $result;
    }
            
    function checkEmail($email){
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM member WHERE member_email='$email'";
        $result=$con->query($sql);
        return $result;   
    }
    
    function displayMember($member_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM member m,login_member l WHERE m.member_id=l.member_id AND m.member_id='$member_id'";
        $result=$con->query($sql);
        return $result;
    }
   
    function addReg($uname,$email,$password,$activation){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO register_member VALUES('','$uname','$email','$password','$activation','Unverified')";
        $result=$con->query($sql);
        $reg_id=$con->insert_id;
        return $reg_id;
        
        
    }
    
    function regMember($reg_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM register_member WHERE reg_id='$reg_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function verifyMember($reg_id,$activation){
        
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM register_member WHERE reg_id='$reg_id' AND activation_code='$activation'";
        $result=$con->query($sql);
        return $result;
    }
    
        function ConfirmMember($reg_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE register_member SET email_status='Confirmed' WHERE reg_id='$reg_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function getMember($reg_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM register_member WHERE reg_id='$reg_id'";
        $result=$con->query($sql);
        return $result;
    }
    function addOnlineMember($email){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO member VALUES('','','','$email','','','','','',4,'','Active')";
        $result=$con->query($sql);
        $member_id=$con->insert_id;
        return $member_id;
        
        
    }
}