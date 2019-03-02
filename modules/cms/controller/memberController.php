<?php
include '../common/dbconnection.php';
include '../model/memberModel.php';
include '../model/membershipModel.php';
include '../model/loginModel.php';
include '../model/packageModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$status=$_REQUEST['status'];

$objme= new member();
$objms = new membership();
$objpa = new package();
$objlo = new Login();


switch ($status){
    
    case "Add":
        
        $member_fname=$_POST['fname'];
        $member_lname=$_POST['lname'];
        $member_email=$_POST['email'];
        $gender=$_POST['gender'];
        $dob=$_POST['dob'];
        $nic=$_POST['nic'];
        $member_tel=$_POST['tel'];
        $address=$_POST['address'];
        $package_id = $_POST['package'];
        
        if($_FILES['member_image']['name'] != ""){
            
            $member_image=$_FILES['member_image']['name'];
            $member_loc = $_FILES['member_image']['tmp_name'];
            $new_image = time()."_". $member_image;
        }else{
            $new_image ="";
        }
        
        if($package_id >= 1){
                    
        //To get the duration of the package
        
        $response = $objpa->getDuration($package_id);
        $duration = $response->fetch_assoc();
        $inDays = $duration['duration']*30;
        }
        //check the email for existing or not    
            $checkE=$objme->checkEmail($member_email);
            $checkE->num_rows;
            if($checkE->num_rows==0){    
            //add new member
            $member_id=$objme->addMember($member_fname,$member_lname,$member_email,$gender,$dob,$nic,$member_tel,$address,$new_image);

            //Adding an Image into member_image folder
            if($new_image!=""){
            $destination="../images/member_image/$new_image";
            move_uploaded_file($member_loc, $destination);
    
            }
            
            if(!empty($member_id)){
                //generate random password
            $length = 5;
            $ran = bin2hex(openssl_random_pseudo_bytes($length));
            $password=sha1($ran);
            //add login
            $result=$objlo->addMemberLogin($member_email,$password, $member_id);
            
            //add membership
            
            $end_time = date('Y-m-d', strtotime('+'.$inDays.' days'));
            
            $membership_id = $objms->addMembership($member_id,$package_id,$end_time);
            
            if(!empty($membership_id)){
                
                //Email send start
            
            $result = $objme->displayMember($member_id);
            if(!$result){
                die("Query DEAD ".mysqli_error($con));
            }
            $rowMe = $result->fetch_assoc();           
                    
                    $url = "http://localhost/zgym/system/";
                    $mail_body="<h2> Hi ". $rowMe['member_fname'] ." ,</h2>"
                            . "<p> Thanks for registation, Your password is ".$ran."</p>"
                            . "<p>Use this password to login to your myPlan account </p>"
                            . "<p>Best Regards, <br />Z Gym</p>";
                       
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
                            $mail->addAddress($rowMe['member_email'],$rowMe['member_fname']);     // Add a recipient
//                            $mail->addAddress('ellen@example.com');               // Name is optional
//                            $mail->addReplyTo('info@example.com', 'Information');
//                            $mail->addCC('cc@example.com');
//                            $mail->addBCC('bcc@example.com');

                            //Attachments
//                            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//                            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                            //Content
                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = 'myPlan Login';
                            $mail->Body    = $mail_body;
//                            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                            $mail->send();


                            $msg=base64_encode("A User has been Added");
                            header("Location:../view/Member.php?msg=$msg");
                            
                            
                        } catch (Exception $e) {
                            
                            $msg=base64_encode("Message could not be sent.Mailer Error :".$mail->ErrorInfo);
                            header("Location:../../view/registerEmail.php?msg=$msg");
                        }
                          //email send end
            
            }
            }

            }else{
                $msg=base64_encode("Existing Email Address");
                //header("Location:../view/addMember.php?msg=$msg");
            }
        
        
break;

    case "Update":
        
        $member_fname=$_POST['fname'];
        $member_lname=$_POST['lname'];
        //$staff_email=$_POST['email'];
        $gender=$_POST['gender'];
        $dob=$_POST['dob'];
        $nic=$_POST['nic'];
        $member_tel=$_POST['tel'];
        $address=$_POST['address'];
        
        if($_FILES['member_image']['name'] != ""){
            
            $member_image=$_FILES['member_image']['name'];
            $member_loc = $_FILES['member_image']['tmp_name'];
            $new_image = time()."_". $member_image;
        }
        
        $member_id =$_REQUEST['member_id']; 
        
        //update staff
            
        $objme->updateMember($member_fname,$member_lname,$gender,$dob,$nic,$member_tel,$address,$member_id);
            
        
            //Adding an Image into member_image folder
            if($new_image!=""){
            $destination="../images/member_image/$new_image";
            move_uploaded_file($member_loc, $destination);
            
            $objme->updateMemberImage($member_id, $new_image);
            }
            
            
            $msg=base64_encode("A User has been Updated");
            header("Location:../view/member.php?msg=$msg");
            
break;

    case "Edit":
        
        $member_fname=$_POST['fname'];
        $member_lname=$_POST['lname'];
        //$staff_email=$_POST['email'];
        $gender=$_POST['gender'];
        $dob=$_POST['dob'];
        $nic=$_POST['nic'];
        $member_tel=$_POST['tel'];
        $address=$_POST['address'];
        
        if($_FILES['member_image']['name'] != ""){
            
            $member_image=$_FILES['member_image']['name'];
            $member_loc = $_FILES['member_image']['tmp_name'];
            $new_image = time()."_". $member_image;
        }
        
        $member_id =$_REQUEST['member_id']; 
        
        //update staff
            
        $objme->updateMember($member_fname,$member_lname,$gender,$dob,$nic,$member_tel,$address,$member_id);
            
        
            //Adding an Image into member_image folder
            if($new_image!=""){
            $destination="../images/member_image/$new_image";
            move_uploaded_file($member_loc, $destination);
            
            $objme->updateMemberImage($member_id, $new_image);
            }
            
            
            $msg=base64_encode("Your profile has been Updated");
            header("Location:../../view/member.php?msg=$msg");
            
break;
// Activate member
    case "Active":
        $member_id=$_REQUEST['member_id'];
        $response = $objme->activateMember($member_id);
        if(!$response==""){
            $objlo->activateMemberLogin($member_id);   
        }      
        header("Location:../view/member.php");
// Deactivate member        
        break;
    case "Deactive":
        $member_id=$_REQUEST['member_id'];
        $response = $objme->deactivateMember($member_id);
        if(!$response==""){
            $objlo->deactivateMemberLogin($member_id);
        }
        header("Location:../view/member.php");
        
        break;
// View Member 
    case "View":
        
        $member_id=$_REQUEST['member_id'];
        header("Location:../view/ViewMember.php?member_id=$member_id");
        
break;
    
}

?>
