<?php
include '../common/dbconnection.php';
include '../model/memberModel.php';
include '../model/loginModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
//require '../vendor/phpmailer/phpmailer/src/SMTP.php';
//require '../PHPMailer/src/Exception.php';
//require '../PHPMailer/src/OAuth.php';
////require '../PHPMailer/src/POP3.php';

$status=$_REQUEST['status'];

$objmem= new member();


switch ($status){
    
    case "Con":
        
        $uname= trim($_POST['uname']);
        $email=trim($_POST['email']);
        $password=trim($_POST['pass']);
        $password= sha1($password);
        $activation = md5(rand());
                

        //check the email for existing or not    
        $checkE=$objmem->checkEmail($email);
            echo $checkE->num_rows;
            if($checkE->num_rows==0){
                
                
                
            //add new registation
                $reg_id=$objmem->addReg($uname,$email,$password,$activation);
                
                $result = $objmem->regMember($reg_id);
                $resultReg =$result->fetch_assoc();
                
//                if(isset($resultReg)){
                    
                    $url = "http://localhost/zgym/system/admin/controller/onlineMemberController.php";
                    $mail_body="<h2> Hi ". $resultReg['uname'] ." ,</h2>"
                            . "<p> Thanks for registation, Your password is ".$resultReg['password']."</p>"
                            . "<p>Password will work only after your email verification.</p>"
                            . "<p>Please open the link to verify your email -".$url."?status=Verified&activation=".$resultReg['activation_code']."&id=".$resultReg['reg_id']."</p>"
                            . "<p>Best Regards, <br />Z Gym</p>";
                    
                    
//                    if(isset($resultReg)){
                        
                        
                    
                    //Load Composer's autoloader
                    require '../vendor/autoload.php';
                    
                    
                    
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
                            $mail->addAddress($resultReg['email'],$resultReg['uname']);     // Add a recipient
//                            $mail->addAddress('ellen@example.com');               // Name is optional
//                            $mail->addReplyTo('info@example.com', 'Information');
//                            $mail->addCC('cc@example.com');
//                            $mail->addBCC('bcc@example.com');

                            //Attachments
//                            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//                            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                            //Content
                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = 'Email Verification';
                            $mail->Body    = $mail_body;
//                            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                            $mail->send();

                            $msg=base64_encode("Confirmation email has been sent,Please confirm your email");
                            header("Location:../../view/registerEmail.php?msg=$msg");
                            
                            
                            
                        } catch (Exception $e) {
                            
                            $msg=base64_encode("Message could not be sent.Mailer Error :".$mail->ErrorInfo);
                            header("Location:../../view/registerEmail.php?msg=$msg");
                        }
        }else{
            
            $msg=base64_encode("Error: member already exists in the system");
            header("Location:../../view/registerEmail.php?msg=$msg");
        }     
            break;
            
    case "Verified":
        
        $activation = $_REQUEST['activation'];
        $reg_id=$_REQUEST['id'];
        
//        echo $activation;
//        echo $reg_id;
        
        $result=$objmem->verifyMember($reg_id, $activation);
        $nor=$result->num_rows;
                            
            if($nor > 0){ 
                
              $objmem->ConfirmMember($reg_id);
              $resultc=$objmem->getMember($reg_id);
              
              
              $resultOM=$resultc->fetch_assoc();
              
              
              $email= $resultOM['email'];
              $pass= $resultOM['password'];
              
            //check the email for existing or not    
            $checkE=$objmem->checkEmail($email);
            $checkMail=$checkE->num_rows;
            
            if($checkMail == 0){
              //add member  
              $member_id=$objmem->addOnlineMember($email);
              
              //add login
              $objOn= new Login();             
              $objOn->addOnlineMemberLogin($email, $pass,$member_id);
              
                            
              $msg=base64_encode("Your email is confirmed, Please update your profile");
              header("Location:../../view/register.php?msg=$msg&member_id=".$member_id);
              
            }else{
                
                header("Location:../../view/login.php");
            }
              
              
                }
                break;
                
    case "Update":
        
        $member_id=$_REQUEST[member_id];
        
        $member_fname = $_POST['fname'];
        $member_lname = $_POST['lname'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $member_tel = $_POST['tel'];
        $address = $_POST['address'];
        $nic = $_POST['nic'];
        if($_FILES['member_image']['name'] != ""){
            
            $member_image=$_FILES['member_image']['name'];
            $member_loc = $_FILES['member_image']['tmp_name'];
            $new_image = time()."_". $member_image;
        }
        
        $objmem->updateMember($member_fname,$member_lname,$gender,$dob,$nic,$member_tel,$address,$member_id);
        
        //Adding an Image into member_image folder
            if($new_image!=""){
            $destination="../images/member_image/$new_image";
            move_uploaded_file($member_loc, $destination);
            
            $objmem->updateMemberImage($member_id, $new_image);
            }
            
            
            $msg=base64_encode("Your profile has been Updated");
            header("Location:../../view/selectPackage.php?msg=$msg");
            }
?>
