<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/classSession.php';
include_once '../model/class.php';
include_once '../model/staff.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

$objses= new classSession();

switch ($status){

/**
 * Redirect to Add a class session
*/ 

    case "Add":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_CLASS_SESSION)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class-session/index.php?msg=$msg");
        exit;
    }

    //get trainers list
    $tDataSet = Staff::getTrainers();
    $trainersAr = [];
    while($row = $tDataSet->fetch_assoc())
    {
        $trainersAr[$row['staff_id']] = $row['trainer_name'];
    }

    //get class list
    $cDataSet = Programs::getAllActiveClass();
    $classAr = [];
    while($row = $cDataSet->fetch_assoc())
    {
        $classAr[$row['class_id']] = $row['class_name'];
    }

    // var_dump($trainersAr); exit;
    $_SESSION['classData'] = $classAr;
    $_SESSION['trainersData'] = $trainersAr;

    header("Location:../cms/view/class-session/addClassSession.php");


break;

/**
 * Insert a new gym class
 */
    
    case "Insert":

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_CLASS_SESSION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/index.php?msg=$msg");
            exit;
        }
      
        $className=$_POST['class_name'];
        if (empty($className)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }
        $color=$_POST['color'];
        if (empty($color)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Color can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }
        $description=$_POST['description'];
        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
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
            $classSessionID=$objpro->addClass($className, $color, $description, $status);        
            
            if($classSessionID){
                // echo "lbp"; exit;
                if (!file_exists('../'.PATH_IMAGE.PATH_CLASS_IMAGE)) {
    
                    mkdir('../'.PATH_IMAGE.PATH_CLASS_IMAGE, 0777, true);
                }
        
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $imgName = "IMG_".$classSessionID.".".$ext;

                // Add class image
                if(Programs::addClassImage($classSessionID, $imgName)){

                    rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_CLASS_IMAGE.$imgName);

                    $msg = json_encode(array('title'=>'Success','message'=>'Class registration successful','type'=>'success'));
                    $msg = base64_encode($msg);
                    header("Location:../cms/view/class-session/index.php?msg=$msg");
                    exit;
                    
                }else{
                    $msg = json_encode(array('title'=>'Warning','message'=> 'Failed to add the class image','type'=>'warning'));
                    $msg = base64_encode($msg);
                    header("Location:../cms/view/class-session/index.php?msg=$msg");
                    exit; 
                }
            }else{
                $msg = json_encode(array('title'=>'Danger','message'=> 'Failed to add the class','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
                exit;  
            }                  
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }    
                
break;

/**
 *  Get the class details for Update class 
 **/ 

    case "Edit":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_CLASS_SESSION)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class-session/index.php?msg=$msg");
        exit;
    }

    $classSessionID = $_REQUEST['class_id'];
    if(!empty($classSessionID)){
        //get class details
        $dataSet = Programs::getClassByID($classSessionID);       
        $classData = $dataSet->fetch_assoc();
        // var_dump($classData); exit;
        $_SESSION['clsData'] = $classData;

        header("Location:../cms/view/class-session/updateClassSession.php");
        exit;
    }else {
        $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class-session/index.php?msg=$msg");
        exit;
    }

break;

/**  
 * Update class details 
 * **/

    case "Update":
    
        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_CLASS_SESSION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/index.php?msg=$msg");
            exit;
        }
    
        $memberID=$_POST['class_id'];

        $className=$_POST['class_name'];
        if (empty($className)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }
        $color=$_POST['color'];
        if (empty($color)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Color can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }
        $description=$_POST['description'];
        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
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
            $imgName = "IMG_".$classSessionID.".".$ext;      
        }

        if(!empty($tmp['name'])){
            if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {

                mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
            }
    
            move_uploaded_file($file_loc,'../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file);
        }
       
        if(Programs::checkUpdateClassName($className, $classSessionID)){

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
                'img' => (!empty($imgName)) ? $imgName : NULL,
                'id' => $classSessionID
            ];
             //update class
            $result=Programs::updateClass($dataAr);
            if($result == true){
                $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been updated','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/class-session/index.php?msg=$msg");
                exit;
            }else {
                $msg = json_encode(array('title'=>'Warning :','message'=> 'Update failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
                exit;
            }
    
    
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }
            
break;

/**
 * View Class
 */ 
    case "View":
            
        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::VIEW_CLASS_SESSION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/index.php?msg=$msg");
            exit;
        }

        $classSessionID = $_REQUEST['class_id'];
        if(!empty($classSessionID)){
            //get employee details
            $dataSet = Programs::getClassByID($classSessionID);
            $clsData = $dataSet->fetch_assoc();

            $_SESSION['clsData'] = $clsData;

            header("Location:../cms/view/class-session/viewClassSession.php");
            exit;
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Activate class 
 * */ 

    case "Activate":
        
    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_CLASS_SESSION)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class-session/index.php?msg=$msg");
        exit;
    }

    $classSessionID=$_REQUEST['class_id'];

    $response = Programs::activateClass($classSessionID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been activated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class-session/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class-session/index.php?msg=$msg");
        exit;
    }  

break;

/**
 * Dectivate class
 */ 

    case "Deactivate":
    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_CLASS_SESSION)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class-session/index.php?msg=$msg");
        exit;
    }

    $classSessionID=$_REQUEST['class_id'];

    $response = Programs::deactivateClass($classSessionID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been deactivated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class-session/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/class-session/index.php?msg=$msg");
        exit;
    }
        
break;

/**
 * Delete class
 */ 

    case "Delete":

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_CLASS_SESSION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/index.php?msg=$msg");
            exit;
        }

        $classSessionID=$_REQUEST['class_id'];

        $response = Programs::deleteClass($classSessionID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been deleted','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Index actiton
 */

        default:

            if(!$user)
            {
                $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/index/index.php?msg=$msg");
                exit;
            }

            if(!$auth->checkPermissions(array(Role::MANAGE_CLASS_SESSION, Role::VIEW_CLASS_SESSION)))
            {
                $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
                exit;
            }

            header("Location:../cms/view/class-session/");
}

?>
