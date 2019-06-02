<?php
date_default_timezone_get("Asia/Colombo");//To change time zone
//Login controller
//Server Side Include to include a file
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../model/login.php';
include_once '../model/role.php';
include_once '../model/log.php';

$objRole = new Role();

$email=trim($_POST['email']);  // get login email
$password=trim($_POST['password']); // get login password

$user_type=$_SESSION['user_type']; //get the user type
$password=sha1($password); //To encrypt using secure hash algorithm

//Server side validation
if($email=="" or $password==""){
    $msg="User Name or Password are Empty";
    $msg= base64_encode($msg);//To encode the message
    
    //Redirecting and passing data though URL
    if($user_type=="member"){
        header("Location:../web/view/login.php?msg=$msg");
    }else{
        header("Location:../cms/view/index.php?msg=$msg");
        }
    
} else {
   
     $obj=new Login(); // Call login model
    if($user_type=='member'){
        $result=$obj->validateMemberLogin($email,$password);
    }
    else{
        $result=$obj->validateStaffLogin($email,$password);
    }
    $nor=$result->num_rows;
     
    if($nor==0){
        $msg="User Name or Password Invalid";
        $msg=base64_encode($msg);
        if($user_type=='member'){
            header("Location:../web/view/login.php?msg=$msg");
        }else{
            header("Location:../cms/view/index.php?msg=$msg");
        }
        
    }else {//Valid user name and password  
               
         if($user_type=='member'){
             $user=$result->fetch_assoc(); 
            //create session to password validateLogin function query details 
            $_SESSION['user']=$user;
            
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
            
            $objlogme=new Log();
            $log_id=$objlogme->insertLogMember($log_ip, $user['member_id']); //Maintaining Member logs
    
            //$user['log_id']=$log_id;
            $_SESSION['log_id']=$log_id;
            
             header("Location:../web/view/myPlan.php");
        }else{
            $user=$result->fetch_assoc();
            //create session to password validateLogin function query details 
            $_SESSION['user']=$user;

            $staff_id = $user['staff_id']; 
            
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
            
            $objlogst=new Log();
            $log_id=$objlogst->insertStaffLog($log_ip, $user['staff_id']); //Maintaining Staff logs
            
            $staff_type = $user['staff_type'];

            $userPermission = $objRole->getPermissionList($staff_id);
            $permissionAr = [];
            while($row = mysqli_fetch_array($userPermission))
                {
                    $permissionAr[] = $row['role_id'];
                }

            $_SESSION['permission'] = $permissionAr; 

            $_SESSION['log_id']=$log_id;         
           header("Location:../cms/view/dashboard.php");
        } 
        
     }
}
