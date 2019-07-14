<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/staff.php';
include_once '../model/login.php';
include_once '../model/role.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use function GuzzleHttp\json_encode;

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
            $msg = json_encode(array('title'=>'Warning','message'=> "First Name can't be empty",'type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $lastName=$_POST['last_name'];
        if (empty($lastName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> "Last Name can't be empty",'type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $email=$_POST['email'];
        if (empty($email)) {
            $msg = json_encode(array('title'=>'Warning','message'=> "Email can't be empty",'type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $gender=$_POST['gender'];
        if (empty($gender)) {
            $msg = json_encode(array('title'=>'Warning','message'=> "Gender can't be empty",'type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $dob=$_POST['dob'];
        if (empty($dob)) {
            $msg = json_encode(array('title'=>'Warning','message'=> "Date of Birth can't be empty",'type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $nic=$_POST['nic'];
        if (empty($nic)) {
            $msg = json_encode(array('title'=>'Warning','message'=> "NIC can't be empty",'type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $phone=$_POST['phone'];
        if (empty($phone)) {
            $msg = json_encode(array('title'=>'Warning','message'=> "Phone number can't be empty",'type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $address=$_POST['address'];
        if (empty($address)) {
            $msg = json_encode(array('title'=>'Warning','message'=> "Address can't be empty",'type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $user_type=$_POST['user_type'];
        if (empty($user_type)) {
            $msg = json_encode(array('title'=>'Warning','message'=> "Staff Type can't be empty",'type'=>'warning'));
            header("Location:../cms/view/staff/addStaff.php?msg=$msg");
            exit;
        }
        $tmp = $_FILES['pro_pic'];

		$file = $tmp['name'];
        $file_loc = $tmp['tmp_name'];
 		$file_size = $tmp['size'];
        $file_type = $tmp['type'];
         
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $newFileName = "pro_pic_".uniqid().".".$ext;

        //upload the image to a temp folder

    if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {

        mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
    }

    move_uploaded_file($file_loc,'../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$newFileName);

    $password = mt_rand(1000000, 10000000);
    $enPassword = sha1($password);
    $lmd = date('Y-m-d H:i:s', time());
    $status = Staff::ACTIVE;


    //check the email for existing or not    
        
    if(Staff::checkEmail($email)){    

    //add new staff
    $staffID=$objst->addStaff($firstName,$lastName,$email,$gender,$dob,$nic,$phone,$address,$user_type,$newFileName, $enPassword, $lmd, $status);

    if($staffID){

    //replace html content with php variables

    $fullName = $firstName." ".$lastName;
        $content = str_replace(
            array('%fullName%', '%businessName%', '%url%', '%userName%', '%password%', '%footer%', '%path%'),
            array($fullName, SYSTEM_BUSINESS_NAME, LIVE_HOST_URL_CMS, $email, $password, EMAIL_FOOTER, '../'.PATH_IMAGE.'logo.png'),
            file_get_contents('../cms/view/mail_templates/new_employee.html')
        );
        
        // var_dump($content); exit;
        /**
         * This example shows settings to use when sending via Google's Gmail servers.
         * This uses traditional id & password authentication - look at the gmail_xoauth.phps
         * example to see how to use XOAUTH2.
         * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
         */

        //Import PHPMailer classes into the global namespace
        // use PHPMailer\PHPMailer\PHPMailer;

        require_once '../vendor/autoload.php';
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = SYSTEM_EMAIL;
        //Password to use for SMTP authentication
        $mail->Password = APP_KEY;
        //Set who the message is to be sent from
        $mail->setFrom(SYSTEM_EMAIL, SYSTEM_BUSINESS_NAME);
        //Set an alternative reply-to address
        $mail->addReplyTo(SYSTEM_EMAIL, SYSTEM_BUSINESS_NAME);
        //Set who the message is to be sent to
        $mail->addAddress($email, $fullName);
        //Set the subject line
        $mail->Subject = 'Employee Registration';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($content, __DIR__);
        //Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        // $mail->addAttachment('images/phpmailer_mini.png');
        //send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }
        //Section 2: IMAP
        //IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
        //Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
        //You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
        //be useful if you are trying to get this working on a non-Gmail IMAP server.
        function save_mail($mail)
        {
            //You can change 'Sent Mail' to any other folder or tag
            $path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
            //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
            $imapStream = imap_open($path, $mail->Username, $mail->Password);
            $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
            imap_close($imapStream);
            return $result;
        }


    }else {
        echo "failed"; exit;
    }
    
    
    //add login staff

    // $objlo->addStaffLogin($staff_email, $staff_id);
    
    
    //Adding an Image into staff_image folder
    // if($new_image!=""){
    // $destination="../images/staff_image/$new_image";
    // move_uploaded_file($staff_loc, $destination);

    // }
    
    // $msg=base64_encode("A User has been Added");
    // header("Location:../view/staff.php?msg=$msg");

}else{
    $msg = json_encode(array('title'=>'Warning','message'=> "Email address already exists",'type'=>'warning'));
        header("Location:../cms/view/staff/addStaff.php?msg=$msg");
        exit;
}


break;

    case "Update":
        
        $staff_fname=$_POST['fname'];
        $staff_lname=$_POST['lname'];
        //$staff_email=$_POST['email'];
        $gender=$_POST['gender'];
        $dob=$_POST['dob'];
        $nic=$_POST['nic'];
        $staff_tel=$_POST['tel'];
        $address=$_POST['address'];
        $role_id=$_POST['role'];
        
        if($_FILES['staff_image']['name'] != ""){
            
            $staff_image=$_FILES['staff_image']['name'];
            $staff_loc = $_FILES['staff_image']['tmp_name'];
            $new_image = time()."_". $staff_image;
        }
        
        $staff_id =$_REQUEST['staff_id']; 
        
        //update staff
            
        $objst->updateStaff($staff_fname,$staff_lname,$gender,$dob,$nic,$staff_tel,$address,$role_id,$staff_id);
            
        
        //Adding an Image into staff_image folder
        if($new_image!=""){
        $destination="../images/staff_image/$new_image";
        move_uploaded_file($staff_loc, $destination);
        
        $objst->updateStaffImage($staff_id, $new_image);
        }
        
        
        $msg=base64_encode("A User has been Updated");
        header("Location:../view/staff.php?msg=$msg");
            
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
            echo(json_encode(true));
        }else {
            echo(json_encode(false));
        }
    
}

?>
