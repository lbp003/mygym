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

$objses= new Session();

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
      
        $sessionName=$_POST['session_name'];

        if (empty($sessionName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Session Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }

        $class=$_POST['class'];

        if (empty($class)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }
        $day=$_POST['day'];
        if (empty($day)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Day can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }

        $startTime=$_POST['start_time'];

        if (empty($startTime)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Start time can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }
        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $startTime)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Start time incorrect format','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }

        $endTime=$_POST['end_time'];

        if (empty($endTime)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'End time can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }
        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $endTime)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'End time incorrect format','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }

        if($startTime > $endTime){
            $msg = json_encode(array('title'=>'Warning','message'=> 'Wrong start time and end time','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }

        $instructor=$_POST['instructor'];

        if (empty($instructor)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Instructor can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }
       
        $status = Session::ACTIVE;

        if(Session::checkSessionName($sessionName)){
            //add new class session
            $classSessionID=$objses->addClassSession($sessionName, $class, $day, $startTime, $endTime, $instructor, $status);        
            
            if($classSessionID){

                $msg = json_encode(array('title'=>'Success','message'=>'Class session registration successful','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/class-session/index.php?msg=$msg");
                exit;
                    
            }else{
                $msg = json_encode(array('title'=>'Danger','message'=> 'Failed to add the class session','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
                exit;  
            }                  
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Session name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/addClassSession.php?msg=$msg");
            exit;
        }    
                
break;

/**
 *  Get the class session details for Update class 
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

    $classSessionID = $_REQUEST['class_session_id'];

    if(!empty($classSessionID)){
        //get class details
        $dataSet = Session::getClassSessionByID($classSessionID);       
        $sessionData = $dataSet->fetch_assoc();
        // var_dump($classData); exit;

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
        $_SESSION['sessionData'] = $sessionData;

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
 * Update class session details 
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
    
        $classSessionID=$_POST['class_session_id'];

        $sessionName=$_POST['session_name'];

        if (empty($sessionName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Session Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }

        $class=$_POST['class'];

        if (empty($class)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }
        $day=$_POST['day'];
        if (empty($day)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Day can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }

        $startTime=$_POST['start_time'];

        if (empty($startTime)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Start time can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }
        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $startTime)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Start time incorrect format','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }

        $endTime=$_POST['end_time'];

        if (empty($endTime)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'End time can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }
        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $endTime)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'End time incorrect format','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }

        if($startTime > $endTime){
            $msg = json_encode(array('title'=>'Warning','message'=> 'Wrong start time and end time','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }

        $instructor=$_POST['instructor'];

        if (empty($instructor)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Instructor can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }
       
        if(Session::checkUpdateSessionName($sessionName, $classSessionID)){

            // var_dump($imgName); exit;
            $dataAr = [
                'name' => $sessionName,
                'class' => $class,
                'day' => $day,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'instructor' => $instructor,
                'id' => $classSessionID
            ];
             //update class
            $result=Session::updateClassSession($dataAr);
            if($result == true){
                $msg = json_encode(array('title'=>'Success :','message'=> 'Class session has been updated','type'=>'success'));
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
            $msg = json_encode(array('title'=>'Warning','message'=> 'Class session name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class-session/updateClassSession.php?msg=$msg");
            exit;
        }
            
break;

/**
 * View Class session
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

        $classSessionID = $_REQUEST['class_session_id'];
            if(!empty($classSessionID)){
                
            //get class details
            $dataSet = Session::getClassSessionByID($classSessionID);       
            $sessionData = $dataSet->fetch_assoc();
            // var_dump($classData); exit;

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
            $_SESSION['sessionData'] = $sessionData;

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

    $classSessionID=$_REQUEST['class_session_id'];

    $response = Session::activateClassSession($classSessionID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Class session has been activated','type'=>'success'));
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

    $classSessionID=$_REQUEST['class_session_id'];

    $response = Session::deactivateClassSession($classSessionID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Class session has been deactivated','type'=>'success'));
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

        $classSessionID=$_REQUEST['class_session_id'];

        $response = Session::deleteClassSession($classSessionID);
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
