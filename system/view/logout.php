<?php

    include '../common/dbconnection.php';
    include '../common/Session.php';
    include '../admin/model/loginModel.php';

if(!(isset($_SESSION))){
    
    session_start();
}

    $MemberDetails=$_SESSION['userDetails'];
    $log_id=$_SESSION['log_id'];
    

    
    $objlog = new log();
    $objlog->updateLogMember($log_id); //To update log record

    unset($_SESSION['userDetails']);
    
    header("Location:login.php");;
?>