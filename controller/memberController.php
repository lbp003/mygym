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
        $msg = SESSION_TIMED_OUT;
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
            $msg = SESSION_TIMED_OUT;
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
            $memberID=$objme->addMember($firstName,$lastName,$email,$gender,$dob,$nic,$phone,$address,$packageID, $membershipNumber, $enPassword, $createdBy, $updatedBy, $lmd, $status, $joinedDate);
            
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
            
                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Member Registration';
                        $mail->Body    = $mailBody;
            
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

// Get the emmber details for Update member

    case "Edit":

    if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
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
        //get member details
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
            $msg = SESSION_TIMED_OUT;
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
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
        $lastName=$_POST['last_name'];
        if (empty($lastName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Last Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
        $email=$_POST['email'];
        if (empty($email)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
        $gender=$_POST['gender'];
        if (empty($gender)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Gender can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
        $dob=$_POST['dob'];
        if (empty($dob)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date of Birth can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
        $nic=$_POST['nic'];
        if (empty($nic)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'NIC can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
        $phone=$_POST['phone'];
        if (empty($phone)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Phone number can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
        $address=$_POST['address'];
        if (empty($address)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Address can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
        $packageID=$_POST['package'];
        if (empty($packageID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
        $membershipNumber=$_POST['membership_number'];
        if (empty($membershipNumber)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Membership number can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }

        $image=$_POST['image'];

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
                'img' => (!empty($imgName)) ? $imgName : $image,
                'lmd' => $lmd,
                'id' => $memberID,
                'package_id' => $packageID
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
                header("Location:../cms/view/member/update-member.php?msg=$msg");
                exit;
            }
    
    
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email address already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/member/update-member.php?msg=$msg");
            exit;
        }
            
break;

    // View Member
    case "View":
            
         if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
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
            //get member details
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

            header("Location:../cms/view/member/view-member.php");
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
        $msg = SESSION_TIMED_OUT;
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
        $msg = SESSION_TIMED_OUT;
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
        $msg = SESSION_TIMED_OUT;
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
           echo (json_encode(true));
       }else {
           echo (json_encode(false));
       }
break;  

       //check update email exists

    case "checkUpdateEmail":

       $email=$_REQUEST['email'];
       $memberID=$_REQUEST['member_id'];

       $result = Member::checkUpdateEmail($email,$memberID);
       if($result == true){
           echo (json_encode(true));
       }else {
           echo (json_encode(false));
       }
break;

       //check insert member BMI 

    case "BMI":
        
        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../web/view/index/login.php?msg=$msg");
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
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../web/view/index/login.php?msg=$msg");
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
            $msg = SESSION_TIMED_OUT;
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

break;

    /**
     * change password
     */
    case "changePw":
        
        if(!$user)
        {
            header("Location:../web/view/index/login.php");
            exit;
        }

        $memberID = $user['member_id'];

        $password = trim($_POST['pwd']); 
        if (empty($password)) {
            $msg= "Password empty";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/change-pw.php?msg_pw=$msg");
            exit;
        }

        $encCurrentPassword = sha1($password);

        if(Member::checkPasswordByID($memberID,$encCurrentPassword) == false){
            $msg= "Current password does not match";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/change-pw.php?msg_pw=$msg");
            exit;
        }

        $newPassword = trim($_POST['newPwd']);
        if (empty($newPassword)) {
            $msg= "Password empty";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/change-pw.php?msg_pw=$msg");
            exit;
        }

        $conNewPassword = trim($_POST['conNewPwd']);
        if (empty($conNewPassword)) {
            $msg= "Password empty";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/change-pw.php?msg_pw=$msg");
            exit;
        }

        if($newPassword !== $conNewPassword){
            $msg= "Passwords not matching";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/change-pw.php?msg_pw=$msg");
            exit;
        }

        if(strlen($newPassword) < 6 || strlen($newPassword) > 32){
            $msg= "Your password must be between 6 to 32 characters.";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/change-pw.php?msg_pw=$msg");
            exit;
        }

        $encPassword = sha1($newPassword);

        if(Member::updateMemberPassword($memberID,$encPassword)){
            $msg= "Password successfully updated.";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/change-pw.php?msg_pw=$msg");
            exit;
        }else{
            $msg= "Password update failed";
            $msg= base64_encode($msg);
            header("Location:../web/view/index/change-pw.php?msg_pw=$msg");
            exit;
        }
break; 

    default:

         if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
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