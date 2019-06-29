<?php
include '../config/dbconnection.php';
include '../config/session.php';
include '../model/staff.php';
include '../model/login.php';

$status=$_REQUEST['status'];

$objst= new Staff();
$objlo = new Login();


switch ($status){
    
    case "Add":

        $first_name=$_POST['fname'];
        $last_name=$_POST['lname'];
        $staff_email=$_POST['email'];
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
        }else{
            $new_image ="";
        }

        //check the email for existing or not    
        $checkE=$objst->checkEmail($email);
            echo $checkE->num_rows;
            if($checkE->num_rows==0){
                echo "LBP"; exit();
                
            //add new staff
            $staff_id=$objst->addStaff($staff_fname,$staff_lname,$staff_email,$gender,$dob,$nic,$staff_tel,$address,$role_id,$new_image);
            
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
