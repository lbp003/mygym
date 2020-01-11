<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/member.php';
include_once '../model/role.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

switch ($status){

/**
 * send email
*/ 

    case "SendMail":

         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_MESSAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        $emailAr = $_POST['email'];
        // print_r($emailAr); exit;
        if (empty($emailAr)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Recipient can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/contact/index.php?msg=$msg");
            exit;
        }

        $subject = $_POST['subject'];
        if (empty($subject)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Subject can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/contact/index.php?msg=$msg");
            exit;
        }

        $message = $_POST['message'];
        if (empty($message)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Message can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/contact/index.php?msg=$msg");
            exit;
        }

        foreach($emailAr as $email){

            $result = Member::getMemberNameByEmail($email);
            $row = $result->fetch_assoc();
            $fullName = $row['member_name'];

               // Send mail
               $mailBody="<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#444; background:#ffffff; line-height:20px; padding-bottom:20px;'>"
               . "<h2> Hi ".$fullName." ,</h2>"
               . "<p>".$message.".</p>"
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
                       $mail->addAddress($email, $fullName);     // Add a recipient
           
                       // Content
                       $mail->isHTML(true);                                  // Set email format to HTML
                       $mail->Subject = $subject;
                       $mail->Body    = $mailBody;
                       // $mail->AltBody = 'Employee Registration';
           
                       $mail->send();                      
                       
                   } catch (Exception $e) {
                       
                           //write email errors to  a text file 
                           $logFile = ERROR_LOG.'email_error_'.date('YmdH').'.txt';
                           @file_put_contents($logFile, "Mailer Error: " . $mail->ErrorInfo, FILE_APPEND | LOCK_EX);
               
                           $msg = json_encode(array('title'=>'Danger','message'=> 'Email sending failed','type'=>'danger'));
                           $msg = base64_encode($msg);
                           header("Location:../cms/view/contact/index.php?msg=$msg");
                           exit;            
                   }
        }
        
        $msg = json_encode(array('title'=>'Success','message'=>'Email successful','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/contact/index.php?msg=$msg");
        exit;

break;

/**
 * Index actiton
 */

        case "index":

            if(!$user)
            {
                $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/index/index.php?msg=$msg");
                exit;
            }

            if(!$auth->checkPermissions(array(Role::MANAGE_MESSAGE, Role::VIEW_MESSAGE)))
            {
                $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
                exit;
            }

            //get members list
            $tDataSet = Member::getAllMembers();
            $memberListAr = [];
            while($row = $tDataSet->fetch_assoc())
            {
                $memberListAr[$row['email']] = $row['member_name'];
            }

            $_SESSION['memberList'] = $memberListAr;

            header("Location:../cms/view/contact/");
}