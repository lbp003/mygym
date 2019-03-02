<?php
include '../common/dbconnection.php';
include '../model/contactModel.php';
include '../common/CommonSql.php';
include '../common/Session.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$status=$_REQUEST['status'];

$objcon= new contact();


switch ($status){
    
    // Contact Message
    
    case "Submit":
        
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $telephone=$_POST['tel'];
        $subject=$_POST['subject'];
        $message=mysql_real_escape_string($_POST['msg']);
              
            //add new Message
         $contact_id=$objcon->addContactMsg($fname,$lname,$email,$telephone,$subject,$message);
            
            $msg=base64_encode("<h3 class='alert alert-success'>Thank You For Contacting Us</h3>");
            header("Location:../../view/contact.php?msg=$msg");
        
        
        break;

    case "Reply":
        $fname =$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $subject=$_POST['subject'];
        $reply=mysql_real_escape_string($_POST['reply']);
        
        $contact_id =$_REQUEST['contact_id'];
        $staff_id=$_REQUEST['staff_id'];
                
            
        //Sending Email starting
             
                    $mail_body="<h2> Hi ". $fname." ".$lname ." ,</h2>"
                            . "<p> Thanks for contacting us,</p>"
                            . "<p>".$reply."</p>"
                            . "<p>Best Regards, <br />Z Gym</p>";
                    
                    
//                    if(isset($resultReg)){
                        
                        
                    
                    //Load Composer's autoloader
                    require_once '../vendor/autoload.php';
                    
                    
                    
                    // phpMailer https://github.com/PHPMailer/PHPMailer
                    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                        try {
                            //Server settings
                            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                            $mail->isSMTP();                                      // Set mailer to use SMTP
                            $mail->Host = 'smtp.live.com';  // Specify main and backup SMTP servers
                            $mail->SMTPAuth = TRUE;                               // Enable SMTP authentication
                            $mail->Username = 'peramuna49@hotmail.com';                 // SMTP username
                            $mail->Password = 'lbp@hotmail';                           // SMTP password
                            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                            $mail->Port =25;                                    // TCP port to connect to

                            //Recipients
                            $mail->setFrom('peramuna49@hotmail.com', 'Z Gym');
                            $mail->addAddress($email,$fname);     // Add a recipient
//                            $mail->addAddress('ellen@example.com');               // Name is optional
//                            $mail->addReplyTo('info@example.com', 'Information');
//                            $mail->addCC('cc@example.com');
//                            $mail->addBCC('bcc@example.com');

                            //Attachments
//                            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//                            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                            //Content
                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = $subject;
                            $mail->Body    = $mail_body;
//                            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                            $mail->send();
        //Sending Email Ending
            //add new reply 
            
            $reply_id=$objcon->addContactReply($contact_id,$staff_id,$reply);
            $msg=base64_encode("Message has been Sent");
           // echo base64_decode($msg);
            header("Location:../view/notification.php?msg=$msg");
            } catch (Exception $e) {
                            
                            $msg=base64_encode("Message could not be sent.Mailer Error :".$mail->ErrorInfo);
                            header("Location:../view/Reply.php?msg=$msg");
                        }
            break;
// Delete Contact Message
    case "Delete":
        $contact_id=$_REQUEST['contact_id'];
        $objcon->deleteConMsg($contact_id);
        header("Location:../view/notification.php");
        
        break;
// View Contact Message 
    case "View":
        
        $contact_id=$_REQUEST['contact_id'];
        $objcon->ViewConMsg($contact_id);
        header("Location:../view/ViewContact.php?contact_id=$contact_id");
        
        break;
    
    // View Reply 
    case "ViewReply":
        
        $reply_id=$_REQUEST['reply_id'];
        header("Location:../view/ViewReply.php?reply_id=$reply_id");
        
        break;
//// Click Reply Button
//    case "SendReply":
//        
//        $contact_id=$_REQUEST['contact_id'];
//        header("Location:../view/SendMessage.php?contact_id=$contact_id");
//        
//        break;
//    
//    case "ViewReply":
//        
//        $reply_id=$_REQUEST['reply_id'];
//        header("Location:../view/ViewReply.php?reply_id=$reply_id");
//        break;
//    
    case "DeleteReply":
        $reply_id=$_REQUEST['reply_id'];
        $objcon->deleteReply($reply_id);
        
        $msg=base64_encode("Message has been Deleted");
        // echo base64_decode($msg);
        header("Location:../view/notification.php?msg=$msg");
        break;
    
    // Staff to Staff Message
    
    case "SendSSmsg":
        
        
        $fromStaffId = $_POST['fromStaff'];
        $subject=$_POST['subject'];
        $message=mysql_real_escape_string($_POST['message']);
        $toStaff = $_POST['toStaff'];
                $objCom = new CommonFun();
                $result=$objCom->findStaffId($toStaff);
                    while($row = $result->fetch_assoc()) {
                        $toStaffId=$row['staff_id'];
                    }          
        $toStaffId;
        
        if($fromStaffId==$toStaffId){
            $msg=base64_encode("Invalid Email Address");
            header("Location:../view/SendSSMessage.php?msg=$msg");
        } else {
        //Add New message
            $UserMsgID=$objcon->sendMessageSS($fromStaffId,$toStaffId,$subject,$message);
        //echo "LBP";
        //exit();
            $msg=base64_encode("Message has been Sent");
            header("Location:../view/SendSSMessage.php?msg=$msg");
    }
    
        break;
    
    case "SendSMmsg":
        
        
        $fromStaffId = $_POST['fromStaff'];
        $subject=$_POST['subject'];
        $message=mysql_real_escape_string($_POST['message']);
        $toMember = $_POST['toMember'];
                $objCom = new CommonFun();
                $result=$objCom->findMemberId($toMember);
                    while($row = $result->fetch_assoc()) {
                        $toMemberId=$row['member_id'];
                    }          
        $toMemberId;
        

        //Add New message
            $UserMsgID=$objcon->sendMessageSM($fromStaffId,$toMemberId,$subject,$message);
        //echo "LBP";
        //exit();
            $msg=base64_encode("Message has been Sent");
            header("Location:../view/SendSMMessage.php?msg=$msg");
            
            break;
            
    //FrontEnd Message
    case "SendMMmsg":
        
        
        $fromMemberId = $_POST['fromMember'];
        $subject=$_POST['subject'];
        $message=mysql_real_escape_string($_POST['message']);
        $toMember = $_POST['toMember'];
                $objCom = new CommonFun();
                $result=$objCom->findMemberId($toMember);
                    while($row = $result->fetch_assoc()) {
                        $toMemberId=$row['member_id'];
                    }          
        $toMemberId;
        
        if($fromMemberId==$toMemberId){
            $msg=base64_encode("Invalid Email Address");
            header("Location:../../view/MessageMember.php?msg=$msg");
        } else {
        //Add New message
            $UserMsgID=$objcon->sendMessageMM($fromMemberId,$toMemberId,$subject,$message);
        //echo "LBP";
        //exit();
            $msg=base64_encode("Message has been Sent");
            header("Location:../../view/SendMMMessage.php?msg=$msg");
    }
    
    break;
    
    case "SendMSmsg":
              
        $fromMemberId = $_POST['fromMember'];
        $subject=$_POST['subject'];
        $message=mysql_real_escape_string($_POST['message']);
        $toStaff = $_POST['toStaff'];
                $objCom = new CommonFun();
                $result=$objCom->findStaffId($toStaff);
                    while($row = $result->fetch_assoc()) {
                        $toStaffId=$row['staff_id'];
                    }          
        $toStaffId;
        
        //Add New message
            $UserMsgID=$objcon->sendMessageMS($fromMemberId,$toStaffId,$subject,$message);
        //echo "LBP";
        //exit();
            $msg=base64_encode("Message has been Sent");
            header("Location:../../view/SendMSMessage.php?msg=$msg");
            
            break;
            
       // View  Message 
    case "ViewMsgIn":
        
        $message_id=$_REQUEST['message_id'];
        $type=$_REQUEST['type'];
        $fname=$_REQUEST['fname'];
        $lname=$_REQUEST['lname'];
        $wh=$_REQUEST['wh'];
        $objcon->ViewMsg($message_id);
        
        if($wh=="M"){
            header("Location:../../view/ViewMessageIn.php?message_id=$message_id&type=$type&fname=$fname&lname=$lname");
        } else {
            header("Location:../view/ViewMessageIn.php?message_id=$message_id&type=$type&fname=$fname&lname=$lname");
        }
           
        break;
    case "ViewMsgOut":
        
        $message_id=$_REQUEST['message_id'];
        //$type=$_REQUEST['type'];
        $fname=$_REQUEST['fname'];
        $lname=$_REQUEST['lname'];
        $wh=$_REQUEST['wh'];
        
        if($wh=="M"){
            header("Location:../../view/ViewMessageOut.php?message_id=$message_id&fname=$fname&lname=$lname");
        }else{
            header("Location:../view/ViewMessageOut.php?message_id=$message_id&fname=$fname&lname=$lname");
        }
        break;
    // Delete Message
    case "DeleteMsg":
        $message_id=$_REQUEST['message_id'];
        $wh=$_REQUEST['wh'];
        
        $objcon->deleteMsg($message_id);
        
        if($wh=="M"){
            header("Location:../../view/notification.php");
        } else {
            header("Location:../view/notification.php");
        }
        
        
        
        break;
 // Send Reply Message
    case "SendMsgReply":
        
        $type=$_REQUEST['type'];
        $toId = $_POST['to'];
        $fromId=$_POST['from'];
        $subject=$_POST['subject'];
        $message=$_POST['msg'];

            if($type=="SS"){
                $ty="SS";
                $UserMsgID=$objcon->sendMessageReply($fromId,$toId,$subject,$message,$ty);
                //echo "HAHAHA";
                //exit();
                $msg=base64_encode("Message has been Sent");
                header("Location:../view/notification.php?msg=$msg");
            
            }elseif ($type=="MS") {
                echo $ty="SM";
                $UserMsgID=$objcon->sendMessageReply($fromId,$toId,$subject,$message,$ty);
                //echo "LBP";
                //exit();
                $msg=base64_encode("Message has been Sent");
                header("Location:../view/notification.php?msg=$msg");
            }elseif ($type=="SM") {
                $ty="MS";
                $UserMsgID=$objcon->sendMessageReply($fromId,$toId,$subject,$message,$ty);
                //echo "ABC";
                //exit();
                $msg=base64_encode("Message has been Sent");
                header("Location:../../view/message.php?msg=$msg");
        } else {
                $ty="MM";
                $UserMsgID=$objcon->sendMessageReply($fromId,$toId,$subject,$message,$ty);
                //echo "LOL";
                //exit();
                $msg=base64_encode("Message has been Sent");
                header("Location:../../view/message.php?msg=$msg");
        }
            
        
        break;
}

?>
