<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/staff.php';
include_once '../model/login.php';
include_once '../model/role.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

$objst= new Staff();
$objlo = new Login();


switch ($status){
    
    case "Add":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_STAFF)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        header("Location:../cms/view/staff/index.php?msg=$msg");
        exit;
    }

        $firstName=$_POST['first_name'];
        if (empty($firstName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'First Name can not be empty','type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $lastName=$_POST['last_name'];
        if (empty($lastName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Last Name can not be empty','type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $email=$_POST['email'];
        if (empty($email)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email can not be empty','type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $gender=$_POST['gender'];
        if (empty($gender)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Gender can not be empty','type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $dob=$_POST['dob'];
        if (empty($dob)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date of Birth can not be empty','type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $nic=$_POST['nic'];
        if (empty($nic)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'NIC can not be empty','type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $phone=$_POST['phone'];
        if (empty($phone)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Phone number can not be empty','type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $address=$_POST['address'];
        if (empty($address)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Address can not be empty','type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $user_type=$_POST['user_type'];
        if (empty($user_type)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Staff Type can not be empty','type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }

    $password = mt_rand(1000000, 10000000);
    $enPassword = sha1($password);
    $lmd = date('Y-m-d H:i:s', time());
    $status = Staff::ACTIVE;


    //check the email for existing or not    
        
    if(Staff::checkEmail($email)){    

    //add new staff
    $staffID=$objst->addStaff($firstName,$lastName,$email,$gender,$dob,$nic,$phone,$address,$user_type, $enPassword, $lmd, $status);

    if($staffID){

    $fullName = $firstName." ".$lastName;
    $mailBody="<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#444; background:#ffffff; line-height:20px; padding-bottom:20px;'>"
    . "<h2> Hi ".$fullName." ,</h2>"
    . "<p>Your employee account has been created in ".SYSTEM_BUSINESS_NAME. " Please find below credentials to access your account.</p>"
    . "<table width='100%' style='margin-top:20px' cellpadding='10' cellspacing='0'>"
    . "<tr style='background:#F5F5F5'>"
    . "<td width='30%'>URL :</td>"
    . "<td width='70%'>".LIVE_HOST_URL_CMS."</td>"
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
            $mail->Host       = 'smtp.live.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'peramuna49@hotmail.com';                     // SMTP username
            $mail->Password   = 'lbp@hotmail';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 25;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('peramuna49@hotmail.com', 'Mailer');
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
            $mail->Subject = 'Employee Registration';
            $mail->Body    = $mailBody;
            // $mail->AltBody = 'Employee Registration';

            if($mail->send()){
                    $msg = json_encode(array('title'=>'Success','message'=> 'Employee registration successful','type'=>'success'));
                    header("Location:../cms/view/staff/index.php?msg=$msg");
                    exit;
            }
            
        } catch (Exception $e) {
               //write email errors to  a text file 
               $logFile = ERROR_LOG.'email_error_'.date('YmdH').'.txt';
               @file_put_contents($logFile, "Mailer Error: " . $mail->ErrorInfo, FILE_APPEND | LOCK_EX);
   
               $msg = json_encode(array('title'=>'Danger','message'=> 'Employee registration failed','type'=>'danger'));
               header("Location:../cms/view/staff/addStaff.php?msg=$msg");
               exit;            
        }
    }else {
        $msg = json_encode(array('title'=>'Danger','message'=> 'Employee registration failed','type'=>'danger'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
}else{
    $msg = json_encode(array('title'=>'Warning','message'=> 'Email address already exists','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
}


break;

// Get the employee details for Update Employee

    case "Edit":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_STAFF)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        header("Location:../cms/view/staff/index.php?msg=$msg");
        exit;
    }

    $staffID = $_REQUEST['staff_id'];
    if(!empty($staffID)){
        //get employee details
        $dataSet = Staff::getEmployeeByID($staffID);
        $employeeData = $dataSet->fetch_assoc();

        $_SESSION['empData'] = $employeeData;
    
        header("Location:../cms/view/staff/updateStaff.php");
        exit;
    }else {
        $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
        header("Location:../cms/view/staff/index.php?msg=$msg");
        exit;
    }

    break;

// Update the Employee details

    case "Update":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_STAFF)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        header("Location:../cms/view/staff/index.php?msg=$msg");
        exit;
    }

    $staffID=$_POST['staff_id'];

    $firstName=$_POST['first_name'];
    if (empty($firstName)) {
        $msg = json_encode(array('title'=>'Warning','message'=> 'First Name can not be empty','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
    $lastName=$_POST['last_name'];
    if (empty($lastName)) {
        $msg = json_encode(array('title'=>'Warning','message'=> 'Last Name can not be empty','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
    $email=$_POST['email'];
    if (empty($email)) {
        $msg = json_encode(array('title'=>'Warning','message'=> 'Email can not be empty','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
    $gender=$_POST['gender'];
    if (empty($gender)) {
        $msg = json_encode(array('title'=>'Warning','message'=> 'Gender can not be empty','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
    $dob=$_POST['dob'];
    if (empty($dob)) {
        $msg = json_encode(array('title'=>'Warning','message'=> 'Date of Birth can not be empty','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
    $nic=$_POST['nic'];
    if (empty($nic)) {
        $msg = json_encode(array('title'=>'Warning','message'=> 'NIC can not be empty','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
    $phone=$_POST['phone'];
    if (empty($phone)) {
        $msg = json_encode(array('title'=>'Warning','message'=> 'Phone number can not be empty','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
    $address=$_POST['address'];
    if (empty($address)) {
        $msg = json_encode(array('title'=>'Warning','message'=> 'Address can not be empty','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
    $user_type=$_POST['user_type'];
    if (empty($user_type)) {
        $msg = json_encode(array('title'=>'Warning','message'=> 'Staff Type can not be empty','type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
    }
    $tmp = $_FILES['avatar'];

    $file = $tmp['name'];
    $file_loc = $tmp['tmp_name'];
    $file_size = $tmp['size'];
    $file_type = $tmp['type'];
     
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $imgName = "IMG_".$staffID.".".$ext;

    $lmd = date('Y-m-d H:i:s', time());

    if(Staff::checkUpdateEmail($email, $staffID)){

        // upload the image to a temp folder

        if (!file_exists('../'.PATH_IMAGE.PATH_STAFF_IMAGE)) {

            mkdir('../'.PATH_IMAGE.PATH_STAFF_IMAGE, 0777, true);
        }

        move_uploaded_file($file_loc,'../'.PATH_IMAGE.PATH_STAFF_IMAGE.$imgName);
        echo "lbp"; exit;    
         //update staff
        $result=$objst->updateStaff($firstName,$lastName,$email,$gender,$dob,$nic,$phone,$address,$user_type, $imgName, $lmd, $staffID);


    }else {
        $msg = json_encode(array('title'=>'Warning','message'=> 'Email address already exists','type'=>'warning'));
        header("Location:../cms/view/staff/updateStaff.php?msg=$msg");
        exit;
    }

break;

// Activate Staff
    case "Active":
        $staff_id=$_REQUEST['staff_id'];
        $response = $objst->activateStaff($staff_id);
        if(!$response==""){
            $objlo->activateStaffLogin($staff_id);
        }
        header("Location:../view/staff.php");
// Deactivate Staff        
        break;
    case "Deactive":
        $staff_id=$_REQUEST['staff_id'];
        $response = $objst->deactivateStaff($staff_id);
        if(!$response==""){
            $objlo->deactivateStaffLogin($staff_id);
        }
        header("Location:../view/staff.php");
        
        break;
// View Staff 
    case "View":
        
        $staff_id=$_REQUEST['staff_id'];
        header("Location:../view/ViewStaff.php?staff_id=$staff_id");
        
break;

        //check email exists

    case "checkEmail":

        $email=$_REQUEST['email'];
        $result = Staff::checkEmail($email);
        if($result == true){
            echo(json_encode(['Result' => true]));
        }else {
            echo(json_encode(['Result' => false]));
        }
    
}

?>
