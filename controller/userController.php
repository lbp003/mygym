<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/staff.php';
include_once '../model/member.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$auth = new Role(); 

$status=$_REQUEST['status'];

switch ($status){
    
    /**
    * forget password
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
                
            //Send email
        
                    // Load Composer's autoloader
                require_once '../vendor/autoload.php';
        
                // Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);
        
                try {
                    //Server settings
                    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
                    $mail->isSMTP();                                            // Set mailer to use SMTP
                    $mail->Host       = EMAIL_HOST;  // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = SYSTEM_EMAIL;                     // SMTP username
                    $mail->Password   = APP_KEY;                               // SMTP password
                    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port       = 25;                                    // TCP port to connect to
        
                    //Recipients
                    $mail->setFrom(SYSTEM_EMAIL, 'Mailer');
                    $mail->addAddress($email,"User");     // Add a recipient
        
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Recover Your Password';
                    $mail->Body    = $mailBody;
        
                    if($mail->send()){
                        header("Location:../cms/view/index/recovery-mail-sent.php");
                        exit;  
                    }
                    
                } catch (Exception $e) {
                        //write email errors to  a text file 
                        $logFile = ERROR_LOG.'email_error_'.date('YmdH').'.txt';
                        @file_put_contents($logFile, "Mailer Error: " . $mail->ErrorInfo, FILE_APPEND | LOCK_EX);
            
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

    case "recverPwSt":

        $staffID = base64_decode($_REQUEST['staff_id']);

        if (empty($staffID)) {
            $msg= UNKNOWN_ERROR;
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        $password = $_POST['pwd'];
        if (empty($password)) {
            $msg= "Password empty";
            $msg= base64_encode($msg);
            header("Location:../cms/view/index/recovery-pw.php?msg=$msg");
            exit;
        }

        $conPassword = $_POST['conPwd'];
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
 * Index actiton
 */

    default:

}
