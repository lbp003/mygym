<?php
date_default_timezone_get("Asia/Colombo");//To change time zone
//Login controller
//Server Side Include to include a file
include '../common/dbconnection.php';
include '../common/Session.php';
include '../model/loginmodel.php';

$uname=trim($_POST['uname']);
$pass=trim($_POST['pass']);
// echo $uname;
// echo $pass;
// exit;
$user_type=$_SESSION['user_type'];
$pass=sha1($pass); //To encrypt using secure hash algorithm

//Server side validation
if($uname=="" or $pass==""){
    $msg="User Name or Password are Empty";
    $msg= base64_encode($msg);//To encode the message
    
    //Redirecting and passing data though URL
    if($user_type=="member"){
         header("Location:../../view/login.php?msg=$msg");
    }else{
            header("Location:../view/Stafflogin.php?msg=$msg");
        }
    
} else {
   
     $obj=new Login();
     if($user_type=='member'){
          $result=$obj->validateLoginMember($uname,$pass);
     }
     else{
          $result=$obj->validateLoginStaff($uname,$pass);
     }
     $nor=$result->num_rows;
     
     if($nor==0){
        $msg="User Name or Password Invalid";
        $msg=base64_encode($msg);
        if($user_type=='member'){
            header("Location:../../view/login.php?msg=$msg");
        }else{
            header("Location:../view/Stafflogin.php?msg=$msg");
        }
        
     } else {//Valid user name and password  
         
        
         if($user_type=='member'){
             $MemberDetails=$result->fetch_assoc(); 
        //create session to pass validateLogin function query details 
            $_SESSION['userDetails']=$MemberDetails;
            
        //To get remote ip address - http://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
            function get_ip_address(){
                $ipaddress='';
                if(isset($_SERVER['HTTP_CLIENT_IP'])){
                    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
                }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
                    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];       
                }else if(isset($_SERVER['REMOTE_ADDR'])){
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                }else{
                    $ipaddress="UNKNOWN";
                }
                return $ipaddress;
            }

            $log_ip=get_ip_address();
            
            $objlogme=new log();
            $log_id=$objlogme->insertLogMember($log_ip, $MemberDetails['member_id']); //Maintaining Member logs
    
            //$MemberDetails['log_id']=$log_id;
            $_SESSION['log_id']=$log_id;
            
             header("Location:../../view/myPlan.php");
        }else{
            $StaffDetails=$result->fetch_assoc(); 
        //create session to pass validateLogin function query details 
            $_SESSION['userDetails']=$StaffDetails;
            
        //To get remote ip address - http://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
            function get_ip_address(){
                $ipaddress='';
                if(isset($_SERVER['HTTP_CLIENT_IP'])){
                    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
                }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
                    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];       
                }else if(isset($_SERVER['REMOTE_ADDR'])){
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                }else{
                    $ipaddress="UNKNOWN";
                }
                return $ipaddress;
            }

            $log_ip=get_ip_address();
            
            $objlogst=new log();
            $log_id=$objlogst->insertLogStaff($log_ip, $StaffDetails['staff_id']); //Maintaining Staff logs
            
           // $StaffDetails['log_id']=$log_id;
            $_SESSION['log_id']=$log_id;
                        
            
            
           header("Location:../view/Dashboard.php");
        } 
        
     }
}
