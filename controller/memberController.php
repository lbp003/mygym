<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/member.php';
include_once '../model/role.php';
include_once '../model/package.php';
include_once '../model/subscription.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

$objme= new Member();
$objsu = new Subscription();

switch ($status){
   
// Redirect to Add Member

    case "Add":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/member/index.php?msg=$msg");
        exit;
    }

    //get packages
    $dataSet = Package::getActivePackage();
    $packagAr = [];
    while($row = $dataSet->fetch_assoc())
    {
        $packagAr[$row['package_id']] = $row['package_name'];
    }

    // print_r($packagAr); exit;
    
    $_SESSION['pacData'] = $packagAr;

    header("Location:../cms/view/member/addMember.php");


break;
    
    case "Insert":

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/index.php?msg=$msg");
            exit;
        }
      
        $firstName=$_POST['first_name'];
        if (empty($firstName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'First Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $lastName=$_POST['last_name'];
        if (empty($lastName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Last Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $email=$_POST['email'];
        if (empty($email)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $gender=$_POST['gender'];
        if (empty($gender)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Gender can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $dob=$_POST['dob'];
        if (empty($dob)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date of Birth can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $nic=$_POST['nic'];
        if (empty($nic)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'NIC can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $phone=$_POST['phone'];
        if (empty($phone)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Phone number can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $address=$_POST['address'];
        if (empty($address)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Address can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $packageID=$_POST['package'];
        if (empty($packageID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $membershipNumber=$_POST['membership_number'];
        if (empty($membershipNumber)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Membership number can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }  
        
        $password = mt_rand(1000000, 10000000);
        $enPassword = sha1($password);
        $lmd = date('Y-m-d H:i:s', time());
        $status = Member::ACTIVE;
        $createdBy = $user['staff_id'];
        $updatedBy = $user['staff_id'];
    
        if(Member::checkEmail($email)){
              //add new member
            $memberID=$objme->addMember($firstName,$lastName,$email,$gender,$dob,$nic,$phone,$address,$packageID, $membershipNumber, $enPassword, $createdBy, $updatedBy, $lmd, $status);
            
            if($memberID){
                // Get package duration
                $packageDuration = Package::getPackageDuration($packageID);
                $duration = $packageDuration->fetch_assoc();

                //subscription end date
                $date = date("Y-m-d");
                $lastPidDate = date("Y-m-d");
                $lmd = date('Y-m-d H:i:s', time());

                $endDate = date('Y-m-d', strtotime("+".$duration['duration']." months", strtotime($date)));
                // print_r($endDate); exit;

                $paymentStatus = Subscription::PAID;
                $status = Subscription::ACTIVE;

                // Add subscription

                $subscriptionID=$objsu->addMembership($memberID,$packageID,$date,$endDate,$lastPidDate,$paymentStatus,$status,$createdBy,$updatedBy,$lmd);
                if($subscriptionID){
                    
                    // Send mail
                    $fullName = $firstName." ".$lastName;
                    $mailBody="<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#444; background:#ffffff; line-height:20px; padding-bottom:20px;'>"
                    . "<h2> Hi ".$fullName." ,</h2>"
                    . "<p>Your member account has been created in ".SYSTEM_BUSINESS_NAME. " Please find below credentials to access your account.</p>"
                    . "<table width='100%' style='margin-top:20px' cellpadding='10' cellspacing='0'>"
                    . "<tr style='background:#F5F5F5'>"
                    . "<td width='30%'>URL :</td>"
                    . "<td width='70%'>".LIVE_HOST_URL_WEB."</td>"
                    . "</tr>"
                    . "<tr style='background:#FCFCFC'>"
                    . "<td width='30%'>Username :</td>"
                    . "<td width='70%'>".$email."</td>"
                    . "</tr>"
                    . "<tr style='background:#F5F5F5'>"
                    . "<td width='30%'>Password :</td>"
                    . "<td width='70%'>".$password."</td>"
                    . "</tr>"
                    . "</table>"
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
                            // $mail->addAddress('ellen@example.com');               // Name is optional
                            // $mail->addReplyTo('info@example.com', 'Information');
                            // $mail->addCC('cc@example.com');
                            // $mail->addBCC('bcc@example.com');
                
                            // Attachments
                            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                
                            // Content
                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = 'Member Registration';
                            $mail->Body    = $mailBody;
                            // $mail->AltBody = 'Employee Registration';
                
                            if($mail->send()){
                                $msg = json_encode(array('title'=>'Success','message'=>'Member registration successful','type'=>'success'));
                                $msg = base64_encode($msg);
                                header("Location:../cms/view/member/index.php?msg=$msg");
                                exit;
                            }
                            
                        } catch (Exception $e) {
                               //write email errors to  a text file 
                               $logFile = ERROR_LOG.'email_error_'.date('YmdH').'.txt';
                               @file_put_contents($logFile, "Mailer Error: " . $mail->ErrorInfo, FILE_APPEND | LOCK_EX);
                   
                               $msg = json_encode(array('title'=>'Danger','message'=> 'Employee registration failed','type'=>'danger'));
                               $msg = base64_encode($msg);
                               header("Location:../cms/view/member/addMember.php?msg=$msg");
                               exit;            
                        }
                }else {
                    $msg = json_encode(array('title'=>'Warning','message'=> 'Member subscription failed','type'=>'danger'));
                    $msg = base64_encode($msg);
                    header("Location:../cms/view/member/addMember.php?msg=$msg");
                    exit;
                }
            }else{
                $msg = json_encode(array('title'=>'Warning','message'=> 'Member registration failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/member/addMember.php?msg=$msg");
                exit;
            }

        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email address already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }    
                
break;

// Get the employee details for Update Employee

    case "Edit":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/member/index.php?msg=$msg");
        exit;
    }

    $memberID = $_REQUEST['member_id'];
    if(!empty($memberID)){
        //get employee details
        $dataSet = Member::getMemberByID($memberID);
        // print_r($dataSet); exit;
        $memberData = $dataSet->fetch_assoc();

        $_SESSION['memData'] = $memberData;

        //get packages
        $dataSet = Package::getActivePackage();
        $packagAr = [];
        while($row = $dataSet->fetch_assoc())
        {
            $packagAr[$row['package_id']] = $row['package_name'];
        }

        // print_r($packagAr); exit;
        
        $_SESSION['pacData'] = $packagAr;

        header("Location:../cms/view/member/updateMember.php");
        exit;
    }else {
        $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/member/index.php?msg=$msg");
        exit;
    }

break;


    case "Update":
       
    
        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/index.php?msg=$msg");
            exit;
        }
    
        $memberID=$_POST['member_id'];

        $firstName=$_POST['first_name'];
        if (empty($firstName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'First Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        }
        $lastName=$_POST['last_name'];
        if (empty($lastName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Last Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        }
        $email=$_POST['email'];
        if (empty($email)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        }
        $gender=$_POST['gender'];
        if (empty($gender)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Gender can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        }
        $dob=$_POST['dob'];
        if (empty($dob)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date of Birth can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        }
        $nic=$_POST['nic'];
        if (empty($nic)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'NIC can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        }
        $phone=$_POST['phone'];
        if (empty($phone)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Phone number can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        }
        $address=$_POST['address'];
        if (empty($address)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Address can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        }
        // $packageID=$_POST['package'];
        // if (empty($packageID)) {
        //     $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
        //     $msg = base64_encode($msg);
        //     header("Location:../cms/view/member/addMember.php?msg=$msg");
        //     exit;
        // }
        $membershipNumber=$_POST['membership_number'];
        if (empty($membershipNumber)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Membership number can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        } 
        
        $tmp = $_FILES['avatar'];
        if(!empty($tmp['name'])){
            // print_r($tmp); exit;
            $file = $tmp['name'];
            $file_loc = $tmp['tmp_name'];
            $file_size = $tmp['size'];
            $file_type = $tmp['type'];
             
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $imgName = "IMG_".$memberID.".".$ext;
        }
    
        $lmd = date('Y-m-d H:i:s', time());
        $updatedBy = $user['staff_id'];

        if(Member::checkUpdateEmail($email, $memberID)){

            // upload the image to a temp folder

            if(!empty($imgName)){
                if (!file_exists('../'.PATH_IMAGE.PATH_MEMBER_IMAGE)) {
    
                    mkdir('../'.PATH_IMAGE.PATH_MEMBER_IMAGE, 0777, true);
                }
        
                move_uploaded_file($file_loc,'../'.PATH_IMAGE.PATH_MEMBER_IMAGE.$imgName);
            }
            // var_dump($imgName); exit;
            $dataAr = [
                'fname' => $firstName,
                'lname' => $lastName,
                'email' => $email,
                'gender' => $gender,
                'dob' => $dob,
                'nic' => $nic,
                'phone' => $phone,
                'address' => $address,
                'membership_num' => $membershipNumber,
                'updated_by' => $updatedBy,
                'img' => (!empty($imgName)) ? $imgName : NULL,
                'lmd' => $lmd,
                'id' => $memberID
            ];
             //update member
            $result=Member::updateMember($dataAr);
            if($result == true){
                $msg = json_encode(array('title'=>'Success :','message'=> 'Member has been updated','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/member/index.php?msg=$msg");
                exit;
            }else {
                $msg = json_encode(array('title'=>'Warning :','message'=> 'Update failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/member/updateMember.php?msg=$msg");
                exit;
            }
    
    
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email address already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/updateMember.php?msg=$msg");
            exit;
        }
            
break;

    // View Member
    case "View":
            
        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::VIEW_MEMBER)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/index.php?msg=$msg");
            exit;
        }

        $memberID = $_REQUEST['member_id'];
        if(!empty($memberID)){
            //get employee details
            $dataSet = Member::getMemberByID($memberID);
            $memberData = $dataSet->fetch_assoc();

            $_SESSION['memData'] = $memberData;

            header("Location:../cms/view/member/viewMember.php");
            exit;
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/index.php?msg=$msg");
            exit;
        }

break;

// Activate member

    case "Activate":
        
    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/member/index.php?msg=$msg");
        exit;
    }

    $memberID=$_REQUEST['member_id'];

    $response = Member::activateMember($memberID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Member has been activated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/member/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/member/index.php?msg=$msg");
        exit;
    }  

break;

// Dectivate member

    case "Deactivate":
    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/member/index.php?msg=$msg");
        exit;
    }

    $memberID=$_REQUEST['member_id'];

    $response = Member::deactivateMember($memberID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Member has been deactivated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/member/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/member/index.php?msg=$msg");
        exit;
    }
        
break;

// Delete Member

    case "Delete":

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/index.php?msg=$msg");
            exit;
        }

        $memberID=$_REQUEST['member_id'];

        $response = Member::deleteMember($memberID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Member has been deleted','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/index.php?msg=$msg");
            exit;
        }

break;

       //check email exists

       case "checkEmail":

       $email=$_REQUEST['email'];
       $result = Member::checkEmail($email);
       if($result == true){
           echo(json_encode(['Result' => true]));
       }else {
           echo(json_encode(['Result' => false]));
       }
break;  

       //check update email exists

       case "checkUpdateEmail":

       $email=$_REQUEST['email'];
       $memberID=$_REQUEST['member_id'];

       $result = Member::checkUpdateEmail($email,$memberID);
       if($result == true){
           echo(json_encode(['Result' => true]));
       }else {
           echo(json_encode(['Result' => false]));
       }
break;

/**
 * Index actiton
 */

    default:

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER, Role::VIEW_MEMBER)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/member/");
    
}

?>
