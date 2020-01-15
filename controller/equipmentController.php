<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/equipment.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

$objequ= new Equipment();

switch ($status){
   
/**
 * Redirect to Add Equipment
 */ 

    case "Add":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

    if(!$auth->checkPermissions(array(Role::MANAGE_EQUIPMENT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/equipment/index.php?msg=$msg");
        exit;
    }

    header("Location:../cms/view/equipment/add-equipment.php");


break;

/**
 * Insert a new gym equipment
 */
    
    case "Insert":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }


        if(!$auth->checkPermissions(array(Role::MANAGE_EQUIPMENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/index.php?msg=$msg");
            exit;
        }
      
        $equipmentName=$_POST['equipment_name'];

        if (empty($equipmentName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Equipment Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/add-equipment.php?msg=$msg");
            exit;
        }
 
        $description=$_POST['description'];

        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/add-equipment.php?msg=$msg");
            exit;
        }

        $tmp = $_FILES['avatar'];
        if(!empty($tmp['name'])){
            $file = $tmp['name'];
            $file_loc = $tmp['tmp_name'];
            $file_size = $tmp['size'];
            $file_type = $tmp['type'];
             
        }

        if(!empty($tmp['name'])){
            if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {

                mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
            }
    
            move_uploaded_file($file_loc,'../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file);
        }
       
        $status = Equipment::ACTIVE;

        if(Equipment::checkEquipmentName($equipmentName)){
              //add new equipment
            $equipmentID=$objequ->addEquipment($equipmentName, $description, $status);        
            
            if($equipmentID){

                if(!empty($tmp['name'])){
                    
                    if (!file_exists('../'.PATH_IMAGE.PATH_EQUIPMENT_IMAGE)) {
        
                        mkdir('../'.PATH_IMAGE.PATH_EQUIPMENT_IMAGE, 0777, true);
                    }
            
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $imgName = "IMG_".$equipmentID.".".$ext;

                    // Add equipment image
                    if(Equipment::addEquipmentImage($equipmentID, $imgName)){

                        rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_EQUIPMENT_IMAGE.$imgName);

                        $msg = json_encode(array('title'=>'Success','message'=>'Equipment registration successful','type'=>'success'));
                        $msg = base64_encode($msg);
                        header("Location:../cms/view/equipment/index.php?msg=$msg");
                        exit;
                        
                    }else{
                        $msg = json_encode(array('title'=>'Warning','message'=> 'Failed to add the equipment image','type'=>'warning'));
                        $msg = base64_encode($msg);
                        header("Location:../cms/view/equipment/index.php?msg=$msg");
                        exit; 
                    }
                }else{
                    $msg = json_encode(array('title'=>'Success','message'=>'Equipment registration successful','type'=>'success'));
                    $msg = base64_encode($msg);
                    header("Location:../cms/view/equipment/index.php?msg=$msg");
                    exit;
                }
            }else{
                $msg = json_encode(array('title'=>'Danger','message'=> 'Failed to add the equipment','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/equipment/add-equipment.php?msg=$msg");
                exit;  
            }                  
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Equipment name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/add-equipment.php?msg=$msg");
            exit;
        }    
                
break;

/**
 *  Get the equipment details for Update equipment 
 **/ 

    case "Edit":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

    if(!$auth->checkPermissions(array(Role::MANAGE_EQUIPMENT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/equipment/index.php?msg=$msg");
        exit;
    }

    $equipmentID = $_REQUEST['equipment_id'];

    if(!empty($equipmentID)){
        //get equipment details
        $dataSet = Equipment::getEquipmentByID($equipmentID);       
        $equData = $dataSet->fetch_assoc();
        // var_dump($classData); exit;
        $_SESSION['equData'] = $equData;

        header("Location:../cms/view/equipment/update-equipment.php");
        exit;
    }else {
        $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/equipment/index.php?msg=$msg");
        exit;
    }

break;

/**  
 * Update equipment details 
 * **/

    case "Update":
    
         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_EQUIPMENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/index.php?msg=$msg");
            exit;
        }
    
        $equipmentID=$_POST['equipment_id'];

        $equipmentName=$_POST['equipment_name'];

        if (empty($equipmentName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Equipment Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/update-equipment.php?msg=$msg");
            exit;
        }

        $description=$_POST['description'];
        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/update-equipment.php?msg=$msg");
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
            $imgName = "IMG_".$equipmentID.".".$ext;      
        }

        if(!empty($tmp['name'])){
            if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {

                mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
            }
    
            move_uploaded_file($file_loc,'../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file);
        }
       
        if(Equipment::checkUpdateEquipmentName($equipmentName, $equipmentID)){

            // upload the image to a temp folder

            if(!empty($imgName)){
                if (!file_exists('../'.PATH_IMAGE.PATH_EQUIPMENT_IMAGE)) {
    
                    mkdir('../'.PATH_IMAGE.PATH_EQUIPMENT_IMAGE, 0777, true);
                }

                rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_EQUIPMENT_IMAGE.$imgName);
            }
            // var_dump($imgName); exit;
            $dataAr = [
                'name' => $equipmentName,
                'description' => $description,
                'img' => (!empty($imgName)) ? $imgName : $image,
                'id' => $equipmentID
            ];
             //update equipment
            $result=Equipment::updateEquipment($dataAr);
            if($result == true){
                $msg = json_encode(array('title'=>'Success :','message'=> 'Equipment has been updated','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/equipment/index.php?msg=$msg");
                exit;
            }else {
                $msg = json_encode(array('title'=>'Warning :','message'=> 'Update failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/equipment/update-equipment.php?msg=$msg");
                exit;
            }
    
    
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Equipment name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/update-equipment.php?msg=$msg");
            exit;
        }
            
break;

/**
 * View Equipment
 */ 
    case "View":
            
        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::VIEW_EQUIPMENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/index.php?msg=$msg");
            exit;
        }

        $equipmentID = $_REQUEST['equipment_id'];

        if(!empty($equipmentID)){
            //get employee details
            $dataSet = Equipment::getEquipmentByID($equipmentID);
            $equData = $dataSet->fetch_assoc();

            $_SESSION['equData'] = $equData;

            header("Location:../cms/view/equipment/view-equipment.php");
            exit;
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Activate equipment 
 * */ 

    case "Activate":
        
    if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_EQUIPMENT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/equipment/index.php?msg=$msg");
        exit;
    }

    $equipmentID=$_REQUEST['equipment_id'];

    $response = Equipment::activateEquipment($equipmentID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Equipment has been activated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/equipment/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/equipment/index.php?msg=$msg");
        exit;
    }  

break;

/**
 * Dectivate equipment
 */ 

    case "Deactivate":

    if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_EQUIPMENT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/equipment/index.php?msg=$msg");
        exit;
    }

    $equipmentID=$_REQUEST['equipment_id'];

    $response = Equipment::deactivateEquipment($equipmentID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Equipment has been deactivated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/equipment/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/equipment/index.php?msg=$msg");
        exit;
    }
        
break;

/**
 * Delete equipment
 */ 

    case "Delete":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_EQUIPMENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/index.php?msg=$msg");
            exit;
        }

        $equipmentID=$_REQUEST['equipment_id'];

        $response = Equipment::deleteEquipment($equipmentID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Equipment has been deleted','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/equipment/index.php?msg=$msg");
            exit;
        }

break;

    //check equipment name exists

    case "checkEquipmentName":

        $equipmentName=$_REQUEST['equipment_name'];

        $result = Equipment::checkEquipmentName($equipmentName);

        if($result == true){
            echo(json_encode(true));
        }else {
            echo(json_encode(false));
        }
break; 


    //check equipment name exists

    case "checkUpdateEquipmentName":

        $equipmentID=$_REQUEST['equipment_id'];
        $equipmentName=$_REQUEST['equipment_name'];

        $result = Equipment::checkUpdateEquipmentName($equipmentName,$equipmentID);

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

        if(!$auth->checkPermissions(array(Role::MANAGE_EQUIPMENT, Role::VIEW_EQUIPMENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/equipment/");
}

?>
