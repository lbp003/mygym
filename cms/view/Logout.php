<?php
    include '../../config/dbconnection.php';
    include '../../config/session.php';
    include '../../model/login.php';
     

    $user=$_SESSION['user'];
    $log_id=$_SESSION['log_id'];
          
    $objlog = new log();
    $objlog->updateStaffLog($log_id); //To update log record
    
    unset($_SESSION['user']);
    unset($_SESSION['permission']); 
    unset($_SESSION['log_id']);     
    
    header("refresh:0,url=index.php"); //Redirect to stafflogin page
?>