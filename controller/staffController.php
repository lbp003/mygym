<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/staff.php';
include_once '../model/login.php';
include_once '../model/role.php';

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

    // $msg = json_encode(array('title'=>'Success','message'=>'okay','type'=>'success'));
    //         header("Location:../cms/view/staff/index.php?msg=$msg");
    //         exit;

        $firstName=$_POST['first_name'];
        $lastName=$_POST['last_name'];
        $email=$_POST['email'];
        $gender=$_POST['gender'];
        $dob=$_POST['dob'];
        $nic=$_POST['nic'];
        $phone=$_POST['phone'];
        $address=$_POST['address'];
        $user_type=$_POST['user_type'];

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


        //check the email for existing or not    
        
    if(Staff::checkEmail($email)){
echo "lbp"; exit;
        
    //add new staff
    $staffID=$objst->addStaff($staff_fname,$staff_lname,$staff_email,$gender,$dob,$nic,$staff_tel,$address,$role_id,$new_image);
    
    //add login staff

    $objlo->addStaffLogin($staff_email, $staff_id);
    
    
    //Adding an Image into staff_image folder
    if($new_image!=""){
    $destination="../images/staff_image/$new_image";
    move_uploaded_file($staff_loc, $destination);

    }
    
    $msg=base64_encode("A User has been Added");
    header("Location:../view/staff.php?msg=$msg");

}else{
    $msg=base64_encode("Existing Email Address");
    header("Location:../view/addstaff.php?msg=$msg");
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
