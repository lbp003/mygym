<?php
include_once 'package.php';
include_once 'member.php';
class Subscription{

     //subscription status
     CONST ACTIVE = "A";
     CONST INACTIVE = "I";
     CONST DELETED = "D";
     CONST SUSPENDED = "S";

     //payment status
     CONST PAID = "P";
     CONST LATE = "L";

     //payment method
     CONST CASH = "C";
     CONST WEB = "W";

     /** 
	* Get All Subscription Details
	* @return object $result 
	*/
    public static function displayAllSubscription(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  membership.membership_id,
                        CONCAT_WS(' ',member.first_name,member.last_name) AS member_name,
                        package.package_name,
                        membership.start_date,
                        membership.end_date,
                        membership.last_paid_date,
                        membership.status,
                        membership.payment_status
                FROM membership
                INNER JOIN member ON membership.member_id = member.member_id
                INNER JOIN package ON membership.package_id = package.package_id
                WHERE member.status != 'D'   
                ORDER BY membership.membership_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
   /** 
	* Get All Late Subscription
	* @return object $result 
	*/
    public static function getAllLateSubscription($today){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  membership.membership_id,
                        membership.end_date,
                        membership.member_id
                FROM membership
                INNER JOIN member ON membership.member_id = member.member_id
                WHERE member.status != 'D'   
                AND membership.end_date < '$today'
                ORDER BY membership.membership_id DESC";
                // echo $sql; exit;
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Update Late Subscriptions
	* @return bool 
	*/
    public static function updateBulkPaymentStatus($lateSubaAr){
        /* activate reporting */
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_ALL;

        $status = self::LATE;

        $con=$GLOBALS['con']; 
        try{
            // First of all, let's begin a transaction
            $con->begin_transaction();

            foreach($lateSubaAr as $membership_id){
                $sql = "UPDATE membership SET  membership.payment_status = ? WHERE membership_id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $status, $membership_id);
                $stmt->execute();
            }  
            $con->commit();
            return true;             
        } catch (mysqli_sql_exception $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $con->rollback();
            return false;
            echo $e->__toString();
        }        
    }

    /** 
	* Get All Subscription details by ID
	* @return object $result 
	*/
    public static function getSubscriptionDetailsByID($membershipID){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  membership.membership_id,
                        CONCAT_WS(' ',member.first_name,member.last_name) AS member_name,
                        member.first_name,
                        member.last_name,
                        package.package_name,
                        package.fee,
                        membership.package_id,
                        membership.start_date,                                                           
                        membership.end_date,
                        membership.last_paid_date,
                        membership.status,
                        membership.payment_status
                FROM membership
                INNER JOIN member ON membership.member_id = member.member_id
                INNER JOIN package ON membership.package_id = package.package_id
                WHERE membership.status != 'D'   
                AND membership.membership_id = '$membershipID'
                LIMIT 1";
                // echo $sql; exit;
        $result=$con->query($sql);
        return $result;
    }
    /** 
	* Reactivate a membership
	* @return object $result 
	*/
    function reactivateMemberSubscription($memberID, $membershipID, $packageID, $updatedBy){
        
        /* activate reporting */
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_ALL;

        $con=$GLOBALS['con']; 
        try {
            // First of all, let's begin a transaction
            $con->begin_transaction();

            //update member table
            $memberStatus = Member::ACTIVE;
 
            $sql = "UPDATE member SET package_id = ?, status = ?, updated_by = ? WHERE member_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("isii",$packageID, $memberStatus, $updatedBy, $memberID);
            $stmt->execute();

            // Get package duration
            $packageDuration = Package::getPackageDuration($packageID);
            $duration = $packageDuration->fetch_assoc();

            //subscription end date
            $date = date("Y-m-d");
            $lastPidDate = date("Y-m-d");

            $endDate = date('Y-m-d', strtotime("+".$duration['duration']." months", strtotime($date)));

            $paymentStatus = Subscription::PAID;
            $subStatus = Subscription::ACTIVE;
    
            //update membership table
            $sql = "UPDATE membership SET package_id = ?, start_date = ?, end_date = ?, last_paid_date = ?, payment_status = ?, status = ?, updated_by = ?  WHERE membership_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("isssssii",$packageID, $date, $endDate, $lastPidDate, $paymentStatus, $subStatus, $updatedBy, $membershipID);
            $stmt->execute();

            //Insert record to payment history table
            $method = Subscription::CASH;

            $stmt = $con->prepare("INSERT INTO payment_history (membership_id, member_id, start_date, end_date, paid_date, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissss", $membershipID, $memberID, $date, $endDate, $lastPidDate, $method);
            $stmt->execute();
            // If we arrive here, it means that no exception was thrown
            // i.e. no query has failed, and we can commit the transaction
            $con->commit();

            return true;

        } catch (mysqli_sql_exception $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $con->rollback();
            return false;
            echo $e->__toString();
        }
            
    }

    /** 
	* Renew a membership
	* @return bool
	*/
    function renewMemberSubscription($memberID, $membershipID, $packageID, $updatedBy){
        
        /* activate reporting */
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_ALL;

        $con=$GLOBALS['con']; 
        try {
            // First of all, let's begin a transaction
            $con->begin_transaction();

            //update member table
 
            $sql = "UPDATE member SET package_id = ?, updated_by = ? WHERE member_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("iii",$packageID, $updatedBy, $memberID);
            $stmt->execute();

            // Get package duration
            $packageDuration = Package::getPackageDuration($packageID);
            $duration = $packageDuration->fetch_assoc();

            //get subscription details by id
            $subsData = Subscription::getSubscriptionDetailsByID($membershipID);
            $row = $subsData->fetch_assoc(); 
  
            $startDate = $row['end_date'];
            $lastPidDate = date("Y-m-d");

            $endDate = date('Y-m-d', strtotime("+".$duration['duration']." months", strtotime($startDate)));

            $paymentStatus = Subscription::PAID;
    
            //update membership table
            $sql = "UPDATE membership SET package_id = ?, start_date = ?, end_date = ?, last_paid_date = ?, payment_status = ?, updated_by = ?  WHERE membership_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("issssii",$packageID, $startDate, $endDate, $lastPidDate, $paymentStatus, $updatedBy, $membershipID);
            $stmt->execute();

            //Insert record to payment history table
            $method = Subscription::CASH;

            $stmt = $con->prepare("INSERT INTO payment_history (membership_id, member_id, start_date, end_date, paid_date, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissss", $membershipID, $memberID, $startDate, $endDate, $lastPidDate, $method);
            $stmt->execute();
            // If we arrive here, it means that no exception was thrown
            // i.e. no query has failed, and we can commit the transaction
            $con->commit();

            return true;

        } catch (mysqli_sql_exception $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $con->rollback();
            return false;
            echo $e->__toString();
        }
            
    }

    /** 
	* check membership status
	* @return object $result 
	*/
    public static function checkSubscriptionStatus($memberID){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  membership.membership_id,
                        membership.status
                FROM membership
                WHERE membership.status != 'D'   
                AND membership.member_id = '$memberID'
                LIMIT 1";
                // echo $sql; exit;
        $result=$con->query($sql);
        return $result;
    }
}