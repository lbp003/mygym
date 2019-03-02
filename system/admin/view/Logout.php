<?php
    include '../common/dbconnection.php';
     include '../common/Session.php';
     include '../model/loginModel.php';
     

    $StaffDetails=$_SESSION['userDetails'];
    $log_id=$_SESSION['log_id'];
        
    
    $objlog = new log();
    $objlog->updateLogStaff($log_id); //To update log record
    
    unset($_SESSION['userDetails']);
    unset($_SESSION['log_id']);
    
    header("refresh:0,url=stafflogin.php"); //Redirect to stafflogin page
?>