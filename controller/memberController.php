<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/member.php';
include_once '../model/login.php';
include_once '../model/role.php';
include_once '../model/package.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

$objme= new Member();
$objlo = new Login();


switch ($status){

    
// Redirect to Add Member

    case "Add":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
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
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            header("Location:../cms/view/member/index.php?msg=$msg");
            exit;
        }
      
        $firstName=$_POST['first_name'];
        if (empty($firstName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'First Name can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $lastName=$_POST['last_name'];
        if (empty($lastName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Last Name can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $email=$_POST['email'];
        if (empty($email)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Email can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $gender=$_POST['gender'];
        if (empty($gender)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Gender can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $dob=$_POST['dob'];
        if (empty($dob)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date of Birth can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $nic=$_POST['nic'];
        if (empty($nic)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'NIC can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $phone=$_POST['phone'];
        if (empty($phone)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Phone number can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $address=$_POST['address'];
        if (empty($address)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Address can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $packageID=$_POST['package_id'];
        if (empty($packageID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
        }
        $membershipNumber=$_POST['membership_number'];
        if (empty($membershipNumber)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Membership number can not be empty','type'=>'warning'));
            header("Location:../cms/view/member/addMember.php?msg=$msg");
            exit;
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
       $staffID=$_REQUEST['staff_id'];

       $result = Member::checkUpdateEmail($email,$staffID);
       if($result == true){
           echo(json_encode(['Result' => true]));
       }else {
           echo(json_encode(['Result' => false]));
       }
break; 
    
}

?>
