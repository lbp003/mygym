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

    /**
     * Choose package action
     */
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

        $today = date("Y-m-d");

        $membershipID = $_REQUEST['membership_id'];

        $dataSet = Subscription::getSubscriptionDetailsByID($membershipID);
        $row = $dataSet->fetch_assoc();
        
        $memberID = $row['member_id'];

        $endDate = $row['end_date'];
        $graceDate = date('Y-m-d', strtotime("+7 days", strtotime($endDate)));
        // var_dump($graceDate); exit;

        //get active packages
        $dataSet = Package::getActivePackage();
        $packagAr = [];
        while($row = $dataSet->fetch_assoc())
        {
            $packagAr[$row['package_id']] = $row['package_name'];
        }
        // print_r($packagAr); exit;
        
        $_SESSION['pacData'] = $packagAr;
        $memID = base64_encode($memberID);
        $subID = base64_encode($membershipID);

        if($graceDate >= $today){

            header("Location:../cms/view/subscription/renewMembership.php?subID=$subID&memID=$memID");
            exit;
        }else{

            header("Location:../cms/view/subscription/reactivateMembership.php?subID=$subID&memID=$memID");
            exit;
        }
        
break;

    /**
     * Reactivate the member
    */  
    case "Reactivate":

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

        $memberID = $_POST['member_id'];
        $subscriptionID = $_POST['subscription_id'];
        $updatedBy = $user['staff_id'];

        $packageID = $_POST['package'];
        if (empty($packageID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/reactivateMembership.php?msg=$msg");
            exit;
        }

        $res = Subscription::reactivateMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy);

        if($res){
            $msg = json_encode(array('title'=>'Success: ','message'=> 'Member has been reactivated','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/index.php?msg=$msg");
            exit;
        }

break;

    /**
     * Renew the membership
    */
    case "Renew":

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

        $memberID = $_POST['member_id'];
        $subscriptionID = $_POST['subscription_id'];
        $updatedBy = $user['staff_id'];

        $packageID = $_POST['package'];
        if (empty($packageID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/reactivateMembership.php?msg=$msg");
            exit;
        }

        $res = Subscription::renewMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy);

        if($res){
            $msg = json_encode(array('title'=>'Success: ','message'=> 'Member subscription has been renewed','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/index.php?msg=$msg");
            exit;
        }


break;

    /**
     * Index actiton
     */
    case "View":
        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::VIEW_SUBSCRIPTION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        
        $membershipID = $_REQUEST['membership_id'];

        $dataSet = Subscription::getSubscriptionDetailsByID($membershipID);
        $subscriptionData = $dataSet->fetch_assoc();

        $_SESSION['subscriptionData'] = $subscriptionData;

        header("Location:../cms/view/subscription/viewSubscription.php");
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
