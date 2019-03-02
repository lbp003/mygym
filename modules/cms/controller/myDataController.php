<?php
include '../common/dbconnection.php';
include '../model/memberModel.php';
include '../model/loginModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

$status=$_REQUEST['status'];

$objme= new member();


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
        
        if($_FILES['member_image']['name'] != ""){
            
            $member_image=$_FILES['member_image']['name'];
            $member_loc = $_FILES['member_image']['tmp_name'];
            $new_image = time()."_". $member_image;
        }else{
            $new_image ="";
        }

        //check the email for existing or not    
            $checkE=$objme->checkEmail($email);
            $checkE->num_rows;
            if($checkE->num_rows==0){
                
            //add new member
                $member_id=$objme->addMember($member_fname,$member_lname,$member_email,$gender,$dob,$nic,$member_tel,$address,$new_image);
            
            //add login
            $ob=new login();
            $ob->addMemberLogin($member_email, $member_id);
            
            //Adding an Image into member_image folder
            if($new_image!=""){
            $destination="../images/member_image/$new_image";
            move_uploaded_file($member_loc, $destination);
    
            }
            
            $msg=base64_encode("A User has been Added");
            header("Location:../view/Member.php?msg=$msg");

            }else{
                $msg=base64_encode("Existing Email Address");
                header("Location:../view/addMember.php?msg=$msg");
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
            
        
            //Adding an Image into staff_image folder
            if($new_image!=""){
            $destination="../images/member_image/$new_image";
            move_uploaded_file($member_loc, $destination);
            
            $objme->updateMemberImage($member_id, $new_image);
            }
            
            
            $msg=base64_encode("A User has been Updated");
            header("Location:../view/member.php?msg=$msg");
            
break;
// Activate member
    case "Active":
        $member_id=$_REQUEST['member_id'];
        $objme->activateMember($member_id);
        header("Location:../view/member.php");
// Deactivate member        
        break;
    case "Deactive":
        $member_id=$_REQUEST['member_id'];
        $objme->deactivateMember($member_id);
        header("Location:../view/member.php");
        
        break;
// View Member 
    case "View":
        
        $member_id=$_REQUEST['member_id'];
        header("Location:../view/ViewMember.php?member_id=$member_id");
        
break;
    
}

?>
