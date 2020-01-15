<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/class.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

$objpro= new Programs();

switch ($status){
   
/**
 * Redirect to Add Class
 */ 

    case "Add":

    if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
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

    header("Location:../cms/view/class/add-class.php");


break;

/**
 * Insert a new gym class
 */
    
    case "Insert":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
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
            header("Location:../cms/view/class/add-class.php?msg=$msg");
            exit;
        }
        $color=$_POST['color'];
        if (empty($color)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Color can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/add-class.php?msg=$msg");
            exit;
        }
        $description=$_POST['description'];
        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/add-class.php?msg=$msg");
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

                if(!empty($tmp['name'])){

                    if (!file_exists('../'.PATH_IMAGE.PATH_CLASS_IMAGE)) {
    
                        mkdir('../'.PATH_IMAGE.PATH_CLASS_IMAGE, 0777, true);
                    }
            
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $imgName = "IMG_".$classID.".".$ext;
    
                    // Add class image
                    if(Programs::addClassImage($classID, $imgName)){
    
                        rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_CLASS_IMAGE.$imgName);
    
                        $msg = json_encode(array('title'=>'Success','message'=>'Class registration successful','type'=>'success'));
                        $msg = base64_encode($msg);
                        header("Location:../cms/view/class/index.php?msg=$msg");
                        exit;
                        
                    }else{
                        $msg = json_encode(array('title'=>'Warning','message'=> 'Failed to add the class image','type'=>'warning'));
                        $msg = base64_encode($msg);
                        header("Location:../cms/view/class/index.php?msg=$msg");
                        exit; 
                    }
                }else{
                    $msg = json_encode(array('title'=>'Success','message'=>'Class registration successful','type'=>'success'));
                    $msg = base64_encode($msg);
                    header("Location:../cms/view/class/index.php?msg=$msg");
                    exit;
                }
            }else{
                $msg = json_encode(array('title'=>'Danger','message'=> 'Failed to add the class','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/class/add-class.php?msg=$msg");
                exit;  
            }                  
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/add-class.php?msg=$msg");
            exit;
        }    
                
break;

/**
 *  Get the class details for Update class 
 **/ 

    case "Edit":

    if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
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

    $classID = $_REQUEST['class_id'];
    if(!empty($classID)){
        //get class details
        $dataSet = Programs::getClassByID($classID);       
        $classData = $dataSet->fetch_assoc();
        // var_dump($classData); exit;
        $_SESSION['clsData'] = $classData;

        header("Location:../cms/view/class/update-class.php");
        exit;
    }else {
        $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class/index.php?msg=$msg");
        exit;
    }

break;

/**  
 * Update class details 
 * **/

    case "Update":
    
        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
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
    
        $classID=$_POST['class_id'];

        $className=$_POST['class_name'];
        if (empty($className)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/update-class.php?msg=$msg");
            exit;
        }
        $color=$_POST['color'];
        if (empty($color)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Color can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/update-class.php?msg=$msg");
            exit;
        }
        $description=$_POST['description'];
        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/update-class.php?msg=$msg");
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
            $imgName = "IMG_".$classID.".".$ext;      
        }

        if(!empty($tmp['name'])){
            if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {

                mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
            }
    
            move_uploaded_file($file_loc,'../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file);
        }
       
        if(Programs::checkUpdateClassName($className, $classID)){

            // upload the image to a temp folder

            if(!empty($imgName)){
                if (!file_exists('../'.PATH_IMAGE.PATH_CLASS_IMAGE)) {
    
                    mkdir('../'.PATH_IMAGE.PATH_CLASS_IMAGE, 0777, true);
                }

                rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_CLASS_IMAGE.$imgName);
            }
            // var_dump($imgName); exit;
            $dataAr = [
                'name' => $className,
                'description' => $description,
                'color' => $color,
                'img' => (!empty($imgName)) ? $imgName : $image,
                'id' => $classID
            ];
             //update class
            $result=Programs::updateClass($dataAr);
            if($result == true){
                $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been updated','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/class/index.php?msg=$msg");
                exit;
            }else {
                $msg = json_encode(array('title'=>'Warning :','message'=> 'Update failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/class/update-class.php?msg=$msg");
                exit;
            }
    
    
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/update-class.php?msg=$msg");
            exit;
        }
            
break;

/**
 * View Class
 */ 
    case "View":
            
        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::VIEW_CLASS)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }

        $classID = $_REQUEST['class_id'];
        if(!empty($classID)){
            //get employee details
            $dataSet = Programs::getClassByID($classID);
            $clsData = $dataSet->fetch_assoc();

            $_SESSION['clsData'] = $clsData;

            header("Location:../cms/view/class/view-class.php");
            exit;
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Activate class 
 * */ 

    case "Activate":
        
        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
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

        $classID=$_REQUEST['class_id'];

        $response = Programs::activateClass($classID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been activated','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }  

break;

/**
 * Dectivate class
 */ 

    case "Deactivate":
      
        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
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

        $classID=$_REQUEST['class_id'];

        $response = Programs::deactivateClass($classID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been deactivated','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }
        
break;

/**
 * Delete class
 */ 

    case "Delete":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
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

        $classID=$_REQUEST['class_id'];

        $response = Programs::deleteClass($classID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been deleted','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }

break;

        //check class name exists

    case "checkClassName":

        $className=$_REQUEST['class_name'];

        $result = Programs::checkClassName($className);

        if($result == true){
            echo(json_encode(true));
        }else {
            echo(json_encode(false));
        }
break;  

        //check class name exists

        case "checkUpdateClassName":

            $classID=$_REQUEST['class_id'];
            $className=$_REQUEST['class_name'];

            $result = Programs::checkUpdateClassName($className,$classID);

            if($result == true){
                echo(json_encode(true));
            }else {
                echo(json_encode(false));
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

        if(!$auth->checkPermissions(array(Role::MANAGE_CLASS, Role::VIEW_CLASS)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/class/");

break;

}

?>
