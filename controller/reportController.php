<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/staff.php';
include_once '../model/member.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

switch ($status){
   
/**
 * Redirect to Employee reports
 */ 

    case "Employee":

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
        header("Location:../cms/view/report/index.php?msg=$msg");
        exit;
    }

    header("Location:../cms/view/report/employee-report.php");


break;

/**
 * get admin count
 */
    
    case "adminCount":

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
            header("Location:../cms/view/report/index.php?msg=$msg");         
            exit;
        }
      
        $type=$_POST['type'];
        // var_dump($type); exit;

        $response = Staff::getEmployeeCount($type);
        $adminCount = $response->fetch_assoc();
        echo Json_encode(['Result' => true, 'Data' => $adminCount],JSON_NUMERIC_CHECK);
        exit;
              
break;

/**
 * get admin count
 */
            
    case "trainerCount":

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
            header("Location:../cms/view/report/index.php?msg=$msg");         
            exit;
        }

        $type=$_POST['type'];
        // var_dump($type); exit;

        $response = Staff::getEmployeeCount($type);
        $trainerCount = $response->fetch_assoc();
        echo Json_encode(['Result' => true, 'Data' => $trainerCount],JSON_NUMERIC_CHECK);
        exit;
    
break;

/**
 * get admin count
*/
    
    case "managerCount":

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
            header("Location:../cms/view/report/index.php?msg=$msg");         
            exit;
        }

        $type=$_POST['type'];
        // var_dump($type); exit;

        $response = Staff::getEmployeeCount($type);
        $managerCount = $response->fetch_assoc();
        echo Json_encode(['Result' => true, 'Data' => $managerCount],JSON_NUMERIC_CHECK);
        exit;
    
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

        if(!$auth->checkPermissions(array(Role::MANAGE_REPORT, Role::VIEW_REPORT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/");
}

