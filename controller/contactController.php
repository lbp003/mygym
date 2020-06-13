<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/member.php';
include_once '../model/role.php';

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
                    $message = (new Swift_Message($subject))
                    ->setFrom([SYSTEM_EMAIL])
                    ->setTo([$email => $fullName])
                    ->setBody($mailBody, 'text/html')
                    ;
    
                    // Send the message
                    $result = $mailer->send($message);
    
                }catch(Exception $e){
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
                $msg = SESSION_TIMED_OUT;
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

break;

}