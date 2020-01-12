<?php 

include_once '../../config/dbconnection.php';
include_once '../../config/session.php';
include_once '../../config/global.php';
include_once '../../model/package.php';
include_once '../../model/member.php';
include_once '../../model/subscription.php';
include_once '../../model/role.php';

    $today = date("Y-m-d");
    $time = date("H:i:s");

    //Get due payment members

    $dueSubData = Subscription::getAllDueSubscription($today);
  
    $lateSubaAr = [];

    while($row = $dueSubData->fetch_assoc())
    {
        $lateSubaAr[] = $row['membership_id'];
    }

    if(!empty($lateSubaAr)){
        $res = Subscription::updateBulkPaymentStatus($lateSubaAr);
    }

    //getUnpaid members

    $unPaidSubData = Subscription::getAllUnpaidSubscription($today);

    $outMemberAr = [];

    while($row = $unPaidSubData->fetch_assoc())
    {
        $outMemberAr[] = $row['member_id'];
    }

    if(!empty($outMemberAr)){
        $res = Member::deactivateBulkMember($outMemberAr);
    }

    echo "Cron executed at $today $time ";
exit;

