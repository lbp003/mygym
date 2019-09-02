<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/member.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

switch ($status){

/**
 * send email
*/ 

    case "SendMail":

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

            if(!$auth->checkPermissions(array(Role::MANAGE_MESSAGE, Role::VIEW_MESSAGE)))
            {
                $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
                exit;
            }

            //get members list
            $tDataSet = Member::getAllMembers();
            $memberListAr = [];
            while($row = $tDataSet->fetch_assoc())
            {
                $memberListAr[$row['email']] = $row['member_name'];
            }

            $_SESSION['memberList'] = $memberListAr;

            header("Location:../cms/view/contact/");
}

?>
