<?php
include '../common/dbconnection.php';
include '../model/packageModel.php';
include '../model/loginModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

$status=$_REQUEST['status'];

$objpa= new package();


switch ($status){
    
    case "Add":
        
        $package_name=$_POST['package_name'];
        $package_description=mysql_real_escape_string($_POST['package_description']);
        $package_ammount=$_POST['package_ammount'];
        $duration = $_POST['duration'];
        if($_FILES['package_image']['name'] != ""){
            
            $package_image=$_FILES['package_image']['name'];
            $package_loc = $_FILES['package_image']['tmp_name'];
            $new_image = time()."_". $package_image;
        }else{
            $new_image ="";
        }
              
            //add new package
         $package_id=$objpa->addPackage($package_name,$package_description,$package_ammount,$duration,$new_image);
         echo $package_id;
            
            //Adding an Image into event_image folder
            if($new_image!=""){
            $destination="../images/package_image/$new_image";
            move_uploaded_file($package_loc, $destination);
    
            }
            
            $msg=base64_encode("A Package has been Added");
            header("Location:../view/package.php?msg=$msg");
//            echo base64_decode($msg);

        
        
break;

    case "Update":
        
         $package_name=$_POST['package_name'];
         $package_description=mysql_real_escape_string($_POST['package_description']);
         $price=$_POST['package_ammount'];
        $duration = $_POST['duration'];
        if($_FILES['package_image']['name'] != ""){
            
            $package_image=$_FILES['package_image']['name'];
            $package_loc = $_FILES['package_image']['tmp_name'];
            $new_image = time()."_". $package_image;
        }else{
            $new_image ="";
        }
        
        $package_id=$_REQUEST['package_id']; 
        
        //update package
            
            $objpa->updatePackage($package_name,$package_description,$price,$duration,$package_id);
            
        
            //Adding an Image into package_image folder
            if($new_image!=""){
            $destination="../images/package_image/$new_image";
            move_uploaded_file($package_loc, $destination);
            
            $objpa->updatePackageImage($package_id, $new_image);
            }
            
            
            $msg=base64_encode("A Package has been Updated");
            header("Location:../view/package.php?msg=$msg");
            
break;
// Activate Event
    case "Active":
        $package_id=$_REQUEST['package_id'];
        $objpa->activatePackage($package_id);
        header("Location:../view/package.php");
// Deactivate Event        
        break;
    case "Deactive":
        $package_id=$_REQUEST['package_id'];
        $objpa->deactivatePackage($package_id);
        header("Location:../view/package.php");
        
        break;
// View Event 
    case "View":
        
        $package_id=$_REQUEST['package_id'];
        header("Location:../view/ViewPackage.php?package_id=$package_id");
        
break;
    
}

?>
