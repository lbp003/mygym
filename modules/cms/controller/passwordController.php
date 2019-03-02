<?php
include '../common/dbconnection.php';
include '../model/loginModel.php';
include '../common/CommonSql.php';
include '../common/Session.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$status=$_REQUEST['status'];
$objlo = new Login();


switch ($status){
    
    // change staff change password
    
    case "SCPW":
        
        $staff_id = $_POST['staff_id'];
        $current_pw = trim($_POST['current_pw']);
        $currentE_check = sha1($current_pw);
        $new_pw = trim($_POST['new_pw']);
        $newE_pw = sha1($new_pw);
        $con_pw = trim($_POST['con_pw']);
              
        //check current password
        if($current_pw == "" || $new_pw == ""){
            $msg="Current password or New Password are Empty";
            $msg= base64_encode($msg);//To encode the message
            header("Location:../view/Dashboard.php?msg=$msg");
        } else {
            if ($new_pw == $con_pw) {
                $response = $objlo->checkStaffPW($staff_id,$currentE_check);
            $result = $response->num_rows;
                if($result > 0){
                    $response1 = $objlo->updateStaffPW($staff_id, $newE_pw);
                    if($response1){

                        $msg="Your password is updated";
                        $msg= base64_encode($msg);//To encode the message
                        header("Location:../view/Dashboard.php?msg=$msg");
                    }
                    
                } else {
                    $msg="Current Password didn't match,Try again";
                    $msg= base64_encode($msg);//To encode the message
                    header("Location:../view/Dashboard.php?msg=$msg");
                }
            }else{
                $msg="Current password and Confirm password didn't match";
                $msg= base64_encode($msg);//To encode the message
                header("Location:../view/Dashboard.php?msg=$msg");
            }
        }
        
        break;
    // change member change password
    
    case "MCPW":
        
        $member_id = $_POST['member_id'];
        $current_pw = trim($_POST['current_pw']);
        $currentE_check = sha1($current_pw);
        $new_pw = trim($_POST['new_pw']);
        $newE_pw = sha1($new_pw);
        $con_pw = trim($_POST['con_pw']);
              
        //check current password
        if($current_pw == "" || $new_pw == ""){
            $msg="Current password or New Password are Empty";
            $msg= base64_encode($msg);//To encode the message
            header("Location:../../view/myPlan.php?msg=$msg");
        } else {
            if($new_pw == $con_pw){
                $response = $objlo->checkMemberPW($member_id,$currentE_check);
                $result = $response->num_rows;
                if($result > 0){
                    $response2 = $objlo->updateMemberPW($member_id, $newE_pw);
                    if($response2){
                        $msg="Your password is updated";
                        $msg= base64_encode($msg);//To encode the message
                        header("Location:../../view/myPlan.php?msg=$msg");
                    }
                    
                } else {
                    $msg="Current Password didn't match,Try again";
                    $msg= base64_encode($msg);//To encode the message
                    header("Location:../../view/myPlan.php?msg=$msg");
                }
            }else{
                $msg="Current password and Confirm password didn't match";
                $msg= base64_encode($msg);//To encode the message
                header("Location:../../view/myPlan.php?msg=$msg");
            }
        }

        break;
}

?>
