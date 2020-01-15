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
        $msg = SESSION_TIMED_OUT;
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

    header("Location:../cms/view/report/staff-report.php");


break;

/**
 * get admin count
 */
    
    case "empCount":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }


        if(!$auth->checkPermissions(array(Role::MANAGE_REPORT, Role::VIEW_REPORT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/report/index.php?msg=$msg");         
            exit;
        }

        $response = Staff::getEmployeeTypesCount();
        $empCount = $response->fetch_assoc();

        echo Json_encode(['Result' => true, 'Data' => $empCount],JSON_NUMERIC_CHECK);
        exit;
              
break;

/**
 * Redirect to Class reports
 */ 

    case "Class":

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
            header("Location:../cms/view/report/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/class-report.php");


break;

/**
 * Redirect to Equipment reports
 */ 

    case "Equipment":

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
            header("Location:../cms/view/report/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/equipment-report.php");


break;


/**
 * Redirect to Event reports
 */ 

    case "Event":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }


        if(!$auth->checkPermissions(array(Role::MANAGE_EVENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/report/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/event-report.php");


break;

/**
 * Redirect to exercise reports
 */ 

    case "Exercise":

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
            header("Location:../cms/view/report/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/exercise-report.php");


break;

/**
 * Redirect to exercise reports
 */ 

    case "Package":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/report/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/package-report.php");


break;

/**
 * Redirect to Subscription reports
 */ 

    case "Subscription":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_SUBSCRIPTION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/report/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/subscription-report.php");


break;

/**
 * Redirect to payment reports
 */ 

    case "Payment":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_PAYMENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/report/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/payment-report.php");


break;

/**
 * Redirect to Member reports
 */ 

    case "Member":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_MEMBER)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/report/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/member-report.php");


break;

/**
 * Redirect to Class Session reports
 */ 

    case "classSession":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_CLASS_SESSION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/report/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/class-session-report.php");


break;

    case "PaymentData":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_REPORT, Role::VIEW_REPORT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/report/index.php?msg=$msg");         
            exit;
        }

        $response = Subscription::getPaymentCountByMothod();

        echo Json_encode(['Result' => true, 'Data' => $response]);
        exit;
            
break;

    case "revenueData":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_REPORT, Role::VIEW_REPORT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/report/index.php?msg=$msg");         
            exit;
        }

        $response = Subscription::getPaidAmountByCurrency();

        echo Json_encode(['Result' => true, 'Data' => $response]);
        exit;
        
break;

    /**
     * Redirect to User log reports
    */ 
    case "log":

        if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


    if(!$auth->checkPermissions(array(Role::VIEW_STAFF_LOGIN_LOG, Role::VIEW_MEMBER_LOGIN_LOG)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/report/index.php?msg=$msg");
        exit;
    }

    header("Location:../cms/view/report/user-login-report.php");

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

        if(!$auth->checkPermissions(array(Role::MANAGE_REPORT, Role::VIEW_REPORT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/report/");
}

