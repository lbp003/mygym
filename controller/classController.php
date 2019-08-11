<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/class.php';
include_once '../model/role.php';
include_once '../model/package.php';

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

$objpro= new Programs();

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

    if(!$auth->checkPermissions(array(Role::MANAGE_CLASS)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class/index.php?msg=$msg");
        exit;
    }

    // //get trainers
    // $dataSet = Staff::getTrainers();
    // $trainersAr = [];
    // while($row = $dataSet->fetch_assoc())
    // {
    //     $trainersAr[$row['staff_id']] = $row['trainer_name'];
    // }

    // // print_r($trainersAr); exit;
    
    // $_SESSION['trainersData'] = $trainersAr;

    header("Location:../cms/view/class/addClass.php");


break;
    
    case "Insert":

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_CLASS)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }
      
        $className=$_POST['class_name'];
        if (empty($className)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/addClass.php?msg=$msg");
            exit;
        }
        $color=$_POST['color'];
        if (empty($color)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Color can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/addClass.php?msg=$msg");
            exit;
        }
        $description=$_POST['description'];
        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/addClass.php?msg=$msg");
            exit;
        }

        $tmp = $_FILES['avatar'];
        if(!empty($tmp['name'])){
            // print_r($tmp); exit;
            $file = $tmp['name'];
            $file_loc = $tmp['tmp_name'];
            $file_size = $tmp['size'];
            $file_type = $tmp['type'];
             
            // $ext = pathinfo($file, PATHINFO_EXTENSION);
            // $imgName = "IMG_".$memberID.".".$ext;
        }

        if(!empty($tmp['name'])){
            if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {

                mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
            }
    
            move_uploaded_file($file_loc,'../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file);
        }
       
        $status = Programs::ACTIVE;

        if(Programs::checkClassName($className)){
              //add new class
            $classID=$objpro->addClass($className, $color, $description, $status);
            
            
            
            if($classID){
                echo "lbp"; exit;
                if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {
    
                    mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
                }
        
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $imgName = "IMG_".$classID.".".$ext;

                rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_CLASS_IMAGE.$imgName);
            }                  


        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/addClass.php?msg=$msg");
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

    if(!$auth->checkPermissions(array(Role::MANAGE_STAFF)))
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
                if (!file_exists('../'.PATH_IMAGE.PATH_STAFF_IMAGE)) {
    
                    mkdir('../'.PATH_IMAGE.PATH_STAFF_IMAGE, 0777, true);
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

// Delete Staff  

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
    
}

?>
