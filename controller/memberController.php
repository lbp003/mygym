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

    header("Location:../cms/view/member/add-member.php");


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
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }
        $lastName=$_POST['last_name'];
        if (empty($lastName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Last Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }
        $email=$_POST['email'];
        if (empty($email)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }
        $gender=$_POST['gender'];
        if (empty($gender)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Gender can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }
        $dob=$_POST['dob'];
        if (empty($dob)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date of Birth can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }
        $nic=$_POST['nic'];
        if (empty($nic)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'NIC can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }
        $phone=$_POST['phone'];
        if (empty($phone)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Phone number can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }
        $address=$_POST['address'];
        if (empty($address)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Address can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }
        $packageID=$_POST['package'];
        if (empty($packageID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }
        $membershipNumber=$_POST['membership_number'];
        if (empty($membershipNumber)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Membership number can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
            exit;
        }  
        $joinedDate=$_POST['joined_date'];
        if (empty($joinedDate)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Joined date can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
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
                
                            $msg = json_encode(array('title'=>'Danger','message'=> 'Member registration failed','type'=>'danger'));
                            $msg = base64_encode($msg);
                            header("Location:../cms/view/member/add-member.php?msg=$msg");
                            exit;            
                    }
            }else{
                $msg = json_encode(array('title'=>'Warning','message'=> 'Member registration failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/member/add-member.php?msg=$msg");
                exit;
            }

        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email address already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/add-member.php?msg=$msg");
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

        header("Location:../cms/view/member/update-member.php");
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
        //     header("Location:../cms/view/member/add-member.php?msg=$msg");
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

            //get packages
            $dataSet = Package::getActivePackage();
            $packagAr = [];
            while($row = $dataSet->fetch_assoc())
            {
                $packagAr[$row['package_id']] = $row['package_name'];
            }
            
            $_SESSION['pacData'] = $packagAr;

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

    // check member subscription before activate
    $res = Subscription::checkSubscriptionStatus($memberID);
    $status = $res->fetch_assoc();

    if($status['status'] == Subscription::ACTIVE){
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
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Can not activate the member. membership has been expired','type'=>'danger'));
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

       //check insert member BMI 

    case "BMI":
        
        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/index/index.php?msg=$msg");
            exit;
        }

        $height = $_POST['height'];
        if (empty($height)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Height can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $weight = $_POST['weight'];
        if (empty($weight)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Weight can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $bmiValue = $_POST['bmiValue'];
        if (empty($bmiValue)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'BMI value can not be empty, Please calculate the value before save','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $memberID = $_POST['member_id'];
        if (empty($memberID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Failed to recognize the member','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $date = date("Y-m-d");
        $status = Member::ACTIVE;

        $result = Member::addBMI($memberID, $weight, $height, $bmiValue, $date, $status);

        if($result){
            echo Json_encode(['Result' => true]);
            exit;
        }else{
            echo Json_encode(['Result' => false]);
            exit;
        }

        

break;

    //check insert member bodyfat 

    case "BF":
        
        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/index/index.php?msg=$msg");
            exit;
        }

        $chest = $_POST['chest'];
        if (empty($chest)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'chest can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $axila = $_POST['axila'];
        if (empty($axila)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'axila can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $tricep = $_POST['tricep'];
        if (empty($tricep)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'tricep can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $subscapular = $_POST['subscapular'];
        if (empty($subscapular)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'subscapular can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $abdominal = $_POST['abdominal'];
        if (empty($abdominal)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'abdominal can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $suprailiac = $_POST['suprailiac'];
        if (empty($suprailiac)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'suprailiac can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $thigh = $_POST['thigh'];
        if (empty($thigh)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'thigh can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $age = $_POST['age'];
        if (empty($age)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'age can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $bfValue = $_POST['bfValue'];
        if (empty($bfValue)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Body Fat value can not be empty, Please calculate the value before save','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $memberID = $_POST['member_id'];
        if (empty($memberID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Failed to recognize the member','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../web/view/dashboard/index.php?msg=$msg");
            exit;
        }

        $date = date("Y-m-d");

        $result = Member::addBF($memberID, $chest, $axila, $tricep, $subscapular, $abdominal, $suprailiac, $thigh, $age, $bfValue, $date);
        
        if($result){
            echo Json_encode(['Result' => true]);
            exit;
        }else{
            echo Json_encode(['Result' => false]);
            exit;
        }

    break;

        //check insert member BMI 

        case "getBmiData":

            $memberID = $_POST['member_id'];
            if (empty($memberID)) {
                echo Json_encode(['Result' => false]);
                exit;
            }    
    
            $result = Member::getBMIDataById($memberID);
            
            $bmiData = [];
            while($row = $result->fetch_assoc()){
                $bmiData[] = $row;
            }

            if($result){
                echo Json_encode(['Result' => true, 'Data' => $bmiData]);
                exit;
            }else{
                echo Json_encode(['Result' => false]);
                exit;
            }
    
            
    
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

        if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER, Role::VIEW_MEMBER)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        
        $today = date("Y-m-d");
        //Get late payment members
        $lateSubData = Subscription::getAllLateSubscription($today);

        $lateSubaAr = [];
        $outMemberAr = [];
        while($row = $lateSubData->fetch_assoc())
        {
            $lateSubaAr[] = $row['membership_id'];

            $endDate = $row['end_date'];
            $graceDate = date('Y-m-d', strtotime("+7 days", strtotime($endDate)));

            if($graceDate < $today){

                $outMemberAr[] = $row['member_id'];
            }

            $invoiceIdNum = $row['invoice_id_number'];
            $paypalInvoiceNum = $row['invoice_number'];
            $payStatus = $row['payment_status'];
            $status = $row['invoice_status'];
            if(!empty($paypalInvoiceNum) && $status != "D"){
                // var_dump($paypalInvoiceNum); exit;

            /**
             * To get the access token
             ***/

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, 'https://api.sandbox.paypal.com/v1/oauth2/token');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_USERPWD, PAYPAL_CREDENTIALS['sandbox']['client_id'] . ':' . PAYPAL_CREDENTIALS['sandbox']['client_secret']);
            
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Accept-Language: en_US';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            
            $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $data = json_decode($response);
                    $accessToken = $data->access_token;
                    // echo $accessToken; exit;


                    //Search invoice details
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/search-invoices?total_required=true&page_size=1&page=1",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => '{
                    "invoice_number": "'.$paypalInvoiceNum.'"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'authorization: Bearer '.$accessToken,
                        'content-type: application/json'
                    ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                    echo "cURL Error #:" . $err;
                    } else {
                    // echo $response; exit;
                    $data = json_decode($response,true);
                    $invoicePaymentStatus =  $data['items'][0]['status']; 
                    // var_dump($invoicePaymentStatus); exit; 
                        // echo json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); exit;

                        $memberID = $row['member_id'];
                        $subscriptionID = $row['membership_id'];
                        $packageID = $row['package_id'];
                        $updatedBy = $user['staff_id'];
                        $method = Subscription::WEB;

                        if($invoicePaymentStatus == Subscription::PAYPAL_PAID && $graceDate >= $today){

                            $res = Subscription::renewMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy, $method);
                            // var_dump($res); exit;

                            if($res){
                                // echo $row['member_id']; exit;
                                $paidMembershipAr[] = $subscriptionID;
                                $paidMemberAr[] = $memberID;

                            }
                        }elseif($invoicePaymentStatus == Subscription::PAYPAL_PAID && $graceDate < $today){   
                            $res = Subscription::reactivateMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy, $method);
                            // var_dump($res); exit;
                            // Subscription::updateInvoice($memberID);

                            if($res){
                                $paidMembershipAr[] = $subscriptionID;
                                $paidMemberAr[] = $memberID;;
                            }
                        }elseif($invoicePaymentStatus == !Subscription::PAYPAL_PAID && $graceDate < $today){
                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/invoices/".$invoiceIdNum,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "DELETE",
                            CURLOPT_HTTPHEADER => array(
                                'authorization: Bearer '.$accessToken,
                                'content-type: application/json'
                            ),
                            ));

                            $response = curl_exec($curl);
                            $err = curl_error($curl);

                            curl_close($curl);

                            if ($err) {
                            echo "cURL Error #:" . $err;
                            } else {
                                $res = Subscription::deleteInvoice($memberID);
                            }
                        }elseif($invoicePaymentStatus == Subscription::PAYPAL_SENT && $graceDate >= $today){
                            // echo "lbp"; exit;
                            $paidMembershipAr[] = $subscriptionID;
                            $paidMemberAr[] = $memberID;;
                        }
                    }

                }
            }
        }

        if(!empty($paidMembershipAr)){
            $lateSubaAr = array_diff($lateSubaAr, $paidMembershipAr);
        }
        if(!empty($paidMemberAr)){
            $outMemberAr = array_diff($outMemberAr, $paidMemberAr);
        }

        // var_dump($outMemberAr); exit;
        //Update payment status of subscription
        if(!empty($lateSubaAr) || !empty($outMemberAr)){

            $result1 = Member::deactivateBulkMember($outMemberAr);
            $result2 = Subscription::updateBulkPaymentStatus($lateSubaAr);

            if($result1 && $result2){

                header("Location:../cms/view/member/");

            }else{
                $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
                exit;
            }
        }

        header("Location:../cms/view/member/");

break;

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

        
        $today = date("Y-m-d");
        //Get late payment members
        $lateSubData = Subscription::getAllLateSubscription($today);

        $lateSubaAr = [];
        $outMemberAr = [];
        while($row = $lateSubData->fetch_assoc())
        {
            $lateSubaAr[] = $row['membership_id'];

            $endDate = $row['end_date'];
            $graceDate = date('Y-m-d', strtotime("+7 days", strtotime($endDate)));

            if($graceDate < $today){

                $outMemberAr[] = $row['member_id'];
            }

            $invoiceIdNum = $row['invoice_id_number'];
            $paypalInvoiceNum = $row['invoice_number'];
            $payStatus = $row['payment_status'];
            $status = $row['invoice_status'];
            if(!empty($paypalInvoiceNum) && $status != "D"){
                // var_dump($paypalInvoiceNum); exit;

            /**
             * To get the access token
             ***/

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, 'https://api.sandbox.paypal.com/v1/oauth2/token');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_USERPWD, PAYPAL_CREDENTIALS['sandbox']['client_id'] . ':' . PAYPAL_CREDENTIALS['sandbox']['client_secret']);
            
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Accept-Language: en_US';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            
            $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $data = json_decode($response);
                    $accessToken = $data->access_token;
                    // echo $accessToken; exit;


                    //Search invoice details
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/search-invoices?total_required=true&page_size=1&page=1",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => '{
                    "invoice_number": "'.$paypalInvoiceNum.'"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'authorization: Bearer '.$accessToken,
                        'content-type: application/json'
                    ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                    echo "cURL Error #:" . $err;
                    } else {
                    // echo $response; exit;
                    $data = json_decode($response,true);
                    $invoicePaymentStatus =  $data['items'][0]['status']; 
                    // var_dump($invoicePaymentStatus); exit; 
                        // echo json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); exit;

                        $memberID = $row['member_id'];
                        $subscriptionID = $row['membership_id'];
                        $packageID = $row['package_id'];
                        $updatedBy = $user['staff_id'];
                        $method = Subscription::WEB;

                        if($invoicePaymentStatus == Subscription::PAYPAL_PAID && $graceDate >= $today){

                            $res = Subscription::renewMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy, $method);
                            // var_dump($res); exit;

                            if($res){
                                // echo $row['member_id']; exit;
                                $paidMembershipAr[] = $subscriptionID;
                                $paidMemberAr[] = $memberID;

                            }
                        }elseif($invoicePaymentStatus == Subscription::PAYPAL_PAID && $graceDate < $today){   
                            $res = Subscription::reactivateMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy, $method);
                            // var_dump($res); exit;
                            // Subscription::updateInvoice($memberID);

                            if($res){
                                $paidMembershipAr[] = $subscriptionID;
                                $paidMemberAr[] = $memberID;;
                            }
                        }elseif($invoicePaymentStatus == !Subscription::PAYPAL_PAID && $graceDate < $today){
                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/invoices/".$invoiceIdNum,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "DELETE",
                            CURLOPT_HTTPHEADER => array(
                                'authorization: Bearer '.$accessToken,
                                'content-type: application/json'
                            ),
                            ));

                            $response = curl_exec($curl);
                            $err = curl_error($curl);

                            curl_close($curl);

                            if ($err) {
                            echo "cURL Error #:" . $err;
                            } else {
                                $res = Subscription::deleteInvoice($memberID);
                            }
                        }elseif($invoicePaymentStatus == Subscription::PAYPAL_SENT && $graceDate >= $today){
                            // echo "lbp"; exit;
                            $paidMembershipAr[] = $subscriptionID;
                            $paidMemberAr[] = $memberID;;
                        }
                    }

                }
            }
        }

        if(!empty($paidMembershipAr)){
            $lateSubaAr = array_diff($lateSubaAr, $paidMembershipAr);
        }
        if(!empty($paidMemberAr)){
            $outMemberAr = array_diff($outMemberAr, $paidMemberAr);
        }

        // var_dump($outMemberAr); exit;
        //Update payment status of subscription
        if(!empty($lateSubaAr) || !empty($outMemberAr)){

            $result1 = Member::deactivateBulkMember($outMemberAr);
            $result2 = Subscription::updateBulkPaymentStatus($lateSubaAr);

            if($result1 && $result2){

                header("Location:../cms/view/member/");

            }else{
                $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
                exit;
            }
        }

        header("Location:../cms/view/member/");
    
}