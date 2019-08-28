<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/package.php';
include_once '../model/member.php';
include_once '../model/subscription.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role();

$status=$_REQUEST['status'];


switch ($status){

    case "Payment":

        
        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_SUBSCRIPTION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
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

        if(!$auth->checkPermissions(array(Role::MANAGE_SUBSCRIPTION, Role::VIEW_SUBSCRIPTION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        $today = date("Y-m-d");
        //Get late payment members
        $lateSubData = Subscription::getAllLateSubscription($today);

        $lateSubaAr = [];
        $outMemberAr = [];
        while($row = $lateSubData->fetch_assoc())
        {
            $lateSubaAr[] = $row['membership_id'];

            $endDate = $row['end_date'];
            $graceDate = date('Y-m-d', strtotime("+7 days", strtotime($endDate)));

            if($graceDate < $today){

                $outMemberAr[] = $row['member_id'];
            }
        }

        // var_dump($outMemberAr); exit;
        //Update payment status of subscription
        if(!empty($lateSubaAr) || !empty($outMemberAr)){

            $result1 = Member::deactivateBulkMember($outMemberAr);
            $result2 = Subscription::updateBulkPaymentStatus($lateSubaAr);

            if($result1 && $result2){

                header("Location:../cms/view/subscription/");

            }else{
                $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
                exit;
            }
        }
        header("Location:../cms/view/subscription/");           
}

?>
