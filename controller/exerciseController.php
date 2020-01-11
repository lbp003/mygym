<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/exercise.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

$objexc= new Exercise();

switch ($status){
   
/**
 * Redirect to Add Exercise
 */ 

    case "Add":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_WORKOUT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/exercise/index.php?msg=$msg");
        exit;
    }

    //get anatomy list
    $dataSet = Exercise::getAllAnatomy();
    $anatomyAr = [];
    while($row = $dataSet->fetch_assoc())
    {
        $anatomyAr[$row['anatomy_id']] = $row['anatomy_name'];
    }

    $_SESSION['anatomyData'] = $anatomyAr;

    header("Location:../cms/view/exercise/addExercise.php");


break;

/**
 * Insert a new gym exercise
 */
    
    case "Insert":

         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_WORKOUT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/index.php?msg=$msg");
            exit;
        }
      
        $exerciseName=$_POST['exercise_name'];

        if (empty($exerciseName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Exercise Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/addExercise.php?msg=$msg");
            exit;
        }
        $anatomy=$_POST['anatomy'];

        if (empty($anatomy)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Anatomy can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/addExercise.php?msg=$msg");
            exit;
        }
       
        $status = Exercise::ACTIVE;

        if(Exercise::checkExerciseName($exerciseName)){
              //add new exercise
            $exerciseID=$objexc->addExercise($exerciseName, $anatomy, $status);        
            
            if($exerciseID){
        
                $msg = json_encode(array('title'=>'Success','message'=>'Exercise registration successful','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/exercise/index.php?msg=$msg");
                exit;
                    
            }else{
                $msg = json_encode(array('title'=>'Danger','message'=> 'Failed to add the exercise','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/exercise/addExercise.php?msg=$msg");
                exit;  
            }                  
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Exercise name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/addExercise.php?msg=$msg");
            exit;
        }    
                
break;

/**
 *  Get the exercise details for Update exercise 
 **/ 

    case "Edit":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_WORKOUT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/exercise/index.php?msg=$msg");
        exit;
    }

    $exerciseID = $_REQUEST['exercise_id'];

    if(!empty($exerciseID)){
        //get exercise details
        $dataSet = Exercise::getExerciseByID($exerciseID);       
        $excData = $dataSet->fetch_assoc();

         //get anatomy list
        $dataSet = Exercise::getAllAnatomy();
        $anatomyAr = [];
        while($row = $dataSet->fetch_assoc())
        {
            $anatomyAr[$row['anatomy_id']] = $row['anatomy_name'];
        }

        $_SESSION['anatomyData'] = $anatomyAr;
        $_SESSION['excData'] = $excData;

        header("Location:../cms/view/exercise/updateExercise.php");
        exit;
    }else {
        $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/exercise/index.php?msg=$msg");
        exit;
    }

break;

/**  
 * Update exercise details 
 * **/

    case "Update":
    
         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_WORKOUT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/index.php?msg=$msg");
            exit;
        }
    
        $exerciseID=$_POST['exercise_id'];

        $exerciseName=$_POST['exercise_name'];

        if (empty($exerciseName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Exercise Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/updateExercise.php?msg=$msg");
            exit;
        }
        $anatomy=$_POST['anatomy'];

        if (empty($anatomy)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Anatomy can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/updateExercise.php?msg=$msg");
            exit;
        }
       
        if(Exercise::checkUpdateExerciseName($exerciseName, $exerciseID)){

            // var_dump($imgName); exit;
            $dataAr = [
                'name' => $exerciseName,
                'anatomy' => $anatomy,
                'id' => $exerciseID
            ];
             //update exercise
            $result=Exercise::updateExercise($dataAr);
            if($result == true){
                $msg = json_encode(array('title'=>'Success :','message'=> 'Exercise has been updated','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/exercise/index.php?msg=$msg");
                exit;
            }else {
                $msg = json_encode(array('title'=>'Warning :','message'=> 'Update failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/exercise/updateExercise.php?msg=$msg");
                exit;
            }
    
    
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Exercise name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/updateExercise.php?msg=$msg");
            exit;
        }
            
break;

/**
 * View Exercise
 */ 
    case "View":
            
         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::VIEW_WORKOUT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/index.php?msg=$msg");
            exit;
        }

        $exerciseID = $_REQUEST['exercise_id'];

        if(!empty($exerciseID)){
            //get employee details
            $dataSet = Exercise::getExerciseByID($exerciseID);
            $excData = $dataSet->fetch_assoc();

            $_SESSION['excData'] = $excData;

            header("Location:../cms/view/exercise/viewExercise.php");
            exit;
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Activate exercise 
 * */ 

    case "Activate":
        
    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_WORKOUT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/exercise/index.php?msg=$msg");
        exit;
    }

    $exerciseID=$_REQUEST['exercise_id'];

    $response = Exercise::activateExercise($exerciseID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Exercise has been activated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/exercise/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/exercise/index.php?msg=$msg");
        exit;
    }  

break;

/**
 * Dectivate exercise
 */ 

    case "Deactivate":
    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }
    
    if(!$auth->checkPermissions(array(Role::MANAGE_WORKOUT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/exercise/index.php?msg=$msg");
        exit;
    }

    $exerciseID=$_REQUEST['exercise_id'];

    $response = Exercise::deactivateExercise($exerciseID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Exercise has been deactivated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/exercise/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/exercise/index.php?msg=$msg");
        exit;
    }
        
break;

/**
 * Delete exercise
 */ 

    case "Delete":

         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_WORKOUT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/index.php?msg=$msg");
            exit;
        }

        $exerciseID=$_REQUEST['exercise_id'];

        $response = Exercise::deleteExercise($exerciseID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Exercise has been deleted','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/exercise/index.php?msg=$msg");
            exit;
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


        if(!$auth->checkPermissions(array(Role::MANAGE_WORKOUT, Role::VIEW_WORKOUT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/exercise/");
}

?>
