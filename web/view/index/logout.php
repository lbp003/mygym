<?php
    include_once '../../../config/dbconnection.php';
    include_once '../../../config/session.php';
    include_once '../../../model/log.php';
     

    $user=$_SESSION['user'];
    $log_id=$_SESSION['log_id'];
          
    $objlog = new Log();
    $objlog->updateMemberLog($log_id); //To update log record
    
    unset($_SESSION['user']);
    unset($_SESSION['permission']); 
    unset($_SESSION['log_id']);     
    
    header("refresh:0,url=login.php"); //Redirect to member login page
?>