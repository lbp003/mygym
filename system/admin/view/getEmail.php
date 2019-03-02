<?php
include_once '../common/dbconnection.php';

$status=$_GET['status'];
$email=$_GET['email'];



switch ($status){
    
    case "staff":    
    $pat_email='/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/';
        if(preg_match($pat_email,$email)){

        $sql="SELECT * FROM login_staff WHERE staff_email='$email'";
        $result=$con->query($sql);
        $no=$result->num_rows;
        $status="";
        $msg="";
        if($no==0){
            $msg="Avalable Email Address";
            $status=1;
        }else{
            $msg="Existing Email Address";
            $status=0;
        }
        }else{
            $msg="Invalid email";
            $status=0;
        }
        if($status==1){
            echo "<span style='color:green'>".$msg."</span>";
        }else{
            echo "<span style='color:red'>".$msg."</span>";
        }
        
        break;
        
    case "member":
            
    $pat_email='/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/';
        if(preg_match($pat_email,$email)){

        $sql="SELECT * FROM login_member WHERE member_email='$email'";
        $result=$con->query($sql);
        $no=$result->num_rows;
        $status="";
        $msg="";
        if($no==0){
            $msg="Avalable Email Address";
            $status=1;
        }else{
            $msg="Existing Email Address";
            $status=0;
        }
        }else{
            $msg="Invalid email";
            $status=0;
        }
        if($status==1){
            echo "<span style='color:green'>".$msg."</span>";
        }else{
            echo "<span style='color:red'>".$msg."</span>";
        }
    
    
    
    
}

?>



