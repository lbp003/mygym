<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/staff.php';
include_once '../model/member.php';

$auth = new Role(); 

$status=$_REQUEST['status'];

switch ($status){
    
    /**
    * forget password staff
    */

    case "forgetPwSt":

        $email = $_REQUEST['email'];

        if (empty($email)) {
            $msg="Email required.";
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/forget-pw.php?msg=$msg");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg="Invalid email address.";
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/forget-pw.php?msg=$msg");
            exit;
        }

        $result = Staff::forgetPasswordEmailCheck($email);

        if($result){
            $empData = $result->fetch_assoc();
            $staffID = $empData['staff_id'];
            $encID= base64_encode($staffID);

            $url = "http://fitness.test/cms/view/index/recovery-pw.php?id=$encID";
            $mailBody="<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#444; background:#ffffff; line-height:20px; padding-bottom:20px;'>"
            . "<h2> Hi ,</h2>"
            . "<p>Please click on the below link to reset your new password.</p>"
            . "<p>".$url."</p>"
            ."<p><a href =\"$url\">Link</a></p>"
            . "<p>Thank you.</p><br />"
            . "<p align='center'>".EMAIL_FOOTER."</p>"
            . "</div>";

            require_once '../vendor/autoload.php';

            try{
                // Create the Transport
                $transport = (new Swift_SmtpTransport(EMAIL_HOST, 25))
                ->setUsername(EMAIL_USERNAME)
                ->setPassword(EMAIL_KEY)
                ;
    
                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);
    
                // Create a message
                $message = (new Swift_Message('Recover Your Password'))
                ->setFrom([SYSTEM_EMAIL])
                ->setTo([$email])
                ->setBody($mailBody, 'text/html')
                ;
    
                // Send the message
                $result = $mailer->send($message);
    
                header("Location:../cms/view/index/recovery-mail-sent.php");
                exit; 
    
            }catch(Exception $e){
                $msg = "Failed to send the email. Try again";
                $msg = base64_encode($msg);
                header("Location:../cms/view/index/forget-pw.php");
                exit;  
            }
        }else {
            $msg = "Employee account not found. Try again with correct email address";
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/forget-pw.php");
            exit;  
        }
break; 

    /**
    * recover password staff
    */

    case "recverPwSt":

        $staffID = base64_decode($_REQUEST['staff_id']);

        if (empty($staffID)) {
            $msg= UNKNOWN_ERROR;
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        $password = trim($_POST['pwd']);
        if (empty($password)) {
            $msg= "Password empty";
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        $conPassword = trim($_POST['conPwd']);
        if (empty($password)) {
            $msg= "Password empty";
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        if($password !== $conPassword){
            $msg= "Passwords not matching";
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        if(strlen($password) < 6 || strlen($password) > 32){
            $msg= "Your password must be between 6 to 32 characters.";
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        $encPassword = sha1($password);

        if(Staff::updateStaffPassword($staffID,$encPassword)){
            $msg= "Password successfully updated.";
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }else{
            $msg= "Password update failed";
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

break;

    /**
    * forget password member
    */

    case "forgetPwMem":

        $email = $_REQUEST['email'];

        if (empty($email)) {
            $msg="Email required.";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/forget-pw.php?msg=$msg");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg="Invalid email address.";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/forget-pw.php?msg=$msg");
            exit;
        }

        $result = Member::forgetPasswordEmailCheck($email);

        if($result){
            $memData = $result->fetch_assoc();
            $memberID = $memData['member_id'];
            $encID= base64_encode($memberID);

            $url = "http://fitness.test/web/view/index/recovery-pw.php?id=$encID";
            $mailBody="<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#444; background:#ffffff; line-height:20px; padding-bottom:20px;'>"
            . "<h2> Hi ,</h2>"
            . "<p>Please click on the below link to reset your new password.</p>"
            . "<p>".$url."</p>"
            ."<p><a href =\"$url\">Link</a></p>"
            . "<p>Thank you.</p><br />"
            . "<p align='center'>".EMAIL_FOOTER."</p>"
            . "</div>";

            require_once '../vendor/autoload.php';

            try{
                // Create the Transport
                $transport = (new Swift_SmtpTransport(EMAIL_HOST, 25))
                ->setUsername(EMAIL_USERNAME)
                ->setPassword(EMAIL_KEY)
                ;
    
                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);
    
                // Create a message
                $message = (new Swift_Message('Recover Your Password'))
                ->setFrom([SYSTEM_EMAIL])
                ->setTo([$email])
                ->setBody($mailBody, 'text/html')
                ;
    
                // Send the message
                $result = $mailer->send($message);
    
                if($mail->send()){
                    header("Location:../web/view/index/recovery-mail-sent.php");
                    exit;  
                }
    
            }catch(Exception $e){
                $msg = "Failed to send the email. Try again";
                $msg = base64_encode($msg);
                header("Location:../web/view/index/forget-pw.php");
                exit;  
            }
        
        }else {
            $msg = "Member account not found. Try again with correct email address";
            $msg = base64_encode($msg);
            header("Location:../web/view/index/forget-pw.php");
            exit;  
        }
break; 

     /**
    * recover password member
    */

    case "recverPwMem":

        $memberID = base64_decode($_REQUEST['member_id']);

        if (empty($memberID)) {
            $msg= UNKNOWN_ERROR;
            $msg= base64_encode($msg);
            header("Location:../web/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        $password = trim($_POST['pwd']);
        if (empty($password)) {
            $msg= "Password empty";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        $conPassword = trim($_POST['conPwd']);
        if (empty($password)) {
            $msg= "Password empty";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        if($password !== $conPassword){
            $msg= "Passwords not matching";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        if(strlen($password) < 6 || strlen($password) > 32){
            $msg= "Your password must be between 6 to 32 characters.";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        $encPassword = sha1($password);

        if(Member::updateMemberPassword($memberID,$encPassword)){
            $msg= "Password successfully updated.";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/login.php?msg=$msg");
            exit;
        }else{
            $msg= "Password update failed";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/recovery-pw.php?msg=$msg");
            exit;
        }
    
break;

    /**
    * contact us
    */

    case "Contact":

        $fullName = $_POST['fullName'];
        if (empty($fullName)) {
            header("Location:../web/view/index/failed.php");
            exit;
        }

        $email = $_POST['email'];
        if (empty($email)) {
            header("Location:../web/view/index/failed.php");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location:../web/view/index/failed.php");
            exit;
        }

        $phone = $_POST['phone'];
        if (empty($phone)) {
            header("Location:../web/view/index/failed.php");
            exit;
        }

        $message = $_POST['message'];
        if (empty($message)) {
            header("Location:../web/view/index/failed.php");
            exit;
        }

        $mailBody="<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#444; background:#ffffff; line-height:20px; padding-bottom:20px;'>"
        . "<h2> Hi ,</h2>"
        . "<p>".$fullName."</p>"
        . "<p>".$email."</p>"
        ."<p>".$phone."</p>"
        ."<p>".$message."</p>"
        . "<p>Thank you.</p><br />"
        . "<p align='center'>".EMAIL_FOOTER."</p>"
        . "</div>";
                
    //Send email

        // Load Composer's autoloader
        require_once '../vendor/autoload.php';

        try{
            // Create the Transport
            $transport = (new Swift_SmtpTransport(EMAIL_HOST, 25))
            ->setUsername(EMAIL_USERNAME)
            ->setPassword(EMAIL_KEY)
            ;

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message('Contact Us'))
            ->setFrom([$email => $fullName])
            ->setTo([SYSTEM_EMAIL])
            ->setBody($mailBody, 'text/html')
            ;

            // Send the message
            $result = $mailer->send($message);

            header("Location:../web/view/index/success.php");
            exit; 

        }catch(Exception $e){
            header("Location:../web/view/index/failed.php");
            exit; 
        }
break; 
/**
 * Index actiton
 */

    default:

}
