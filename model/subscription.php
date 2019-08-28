<?php

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
                        membership.payment_status,
                        CONCAT_WS(' ',staff.first_name,staff.last_name) AS staff_name
                FROM membership
                INNER JOIN staff ON membership.created_by = staff.staff_id
                INNER JOIN member ON membership.member_id = member.member_id
                INNER JOIN package ON membership.package_id = package.package_id
                WHERE member.status != 'D'   
                ORDER BY membership.membership_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    // /** 
	// * Insert new member subscription
	// * @return object $membership_id
	// */
    // function addMembership($memberID,$packageID,$date,$endDate,$lastPidDate,$paymentStatus,$status,$createdBy,$updatedBy,$lmd){
        
    //     $con=$GLOBALS['con']; 
    //     $stmt = $con->prepare("INSERT INTO membership (member_id, package_id, start_date, end_date, last_paid_date, payment_status, status, created_by, updated_by, lmd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    //     $stmt->bind_param("iisssssiis", $memberID,$packageID,$date,$endDate,$lastPidDate,$paymentStatus,$status,$createdBy,$updatedBy,$lmd);
    //     $stmt->execute();
    //     $last_id = $con->insert_id;
    //     if(isset($last_id) && !empty($last_id)){
    //         return $last_id;
    //     }else {
    //         return false;
    //     }
    // }
    
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
}