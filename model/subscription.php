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
     CONST PENDING = "U";
     CONST LATE = "L";

     //payment method
     CONST CASH = "C";
     CONST WEB = "W";

    //Paypal payment status
    CONST PAYPAL_PAID = "PAID";
    CONST PAYPAL_SENT = "SENT";

    //Payment Status
    CONST SUCCESS = "S";
    CONST FAILED = "F";

    //Currency
    CONST LKR = 'LKR';
    CONST USD = 'USD';

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
                INNER JOIN package ON member.package_id = package.package_id
                WHERE member.status != 'D'   
                ORDER BY membership.membership_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
   /** 
	* Get All Late Subscription
	* @return object $result 
	*/
    public static function getAllDueSubscription($today){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  membership.membership_id,
                        membership.end_date,
                        membership.member_id,
                        invoice.invoice_number,
                        invoice.invoice_id_number,
                        invoice.status as invoice_status,
                        membership.payment_status,
                        member.package_id
                FROM membership
                INNER JOIN member ON membership.member_id = member.member_id
                LEFT JOIN invoice ON invoice.member_id = membership.member_id
                WHERE member.status != 'D'   
                AND membership.end_date = '$today'
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
                        member.member_id,
                        member.first_name,
                        member.last_name,
                        member.email,
                        member.telephone,
                        package.package_name,
                        package.fee,
                        member.package_id,
                        membership.start_date,                                                           
                        membership.end_date,
                        membership.last_paid_date,
                        membership.status,
                        membership.payment_status
                FROM membership
                INNER JOIN member ON membership.member_id = member.member_id
                INNER JOIN package ON member.package_id = package.package_id
                WHERE membership.status != 'D'   
                AND member.status != 'D'  
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
    public static function reactivateMemberSubscription($memberID, $membershipID, $packageID, $updatedBy, $method){
        
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
            $packageData = $packageDuration->fetch_assoc();

            //subscription end date
            $date = date("Y-m-d");
            $lastPidDate = date("Y-m-d");

            $endDate = date('Y-m-d', strtotime("+".$packageData['duration']." months", strtotime($date)));

            $paymentStatus = Subscription::PAID;
            $subStatus = Subscription::ACTIVE;
    
            //update membership table
            $sql = "UPDATE membership SET start_date = ?, end_date = ?, last_paid_date = ?, payment_status = ?, status = ?, updated_by = ?  WHERE membership_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssssii", $date, $endDate, $lastPidDate, $paymentStatus, $subStatus, $updatedBy, $membershipID);
            $stmt->execute();

            //Insert record to payment history table
            $fee = $packageData['fee'];
            $currency = Subscription::LKR;

            $stmt = $con->prepare("INSERT INTO payment_history (member_id, due_date, paid_date, payment_method, amount, currency_type) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $memberID, $date, $lastPidDate, $method, $fee, $currency);
            $stmt->execute();
            $payHistoryID = $con->insert_id;

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
    public static function renewMemberSubscription($memberID, $membershipID, $packageID, $updatedBy,$method){
        
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
            $packageData = $packageDuration->fetch_assoc();

            //get subscription details by id
            $subsData = Subscription::getSubscriptionDetailsByID($membershipID);
            $row = $subsData->fetch_assoc(); 
  
            $startDate = $row['end_date'];
            $lastPidDate = date("Y-m-d");

            $endDate = date('Y-m-d', strtotime("+".$packageData['duration']." months", strtotime($startDate)));

            $paymentStatus = Subscription::PAID;
    
            //update membership table
            $sql = "UPDATE membership SET start_date = ?, end_date = ?, last_paid_date = ?, payment_status = ?, updated_by = ?  WHERE membership_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssssii", $startDate, $endDate, $lastPidDate, $paymentStatus, $updatedBy, $membershipID);
            $stmt->execute();

            //Insert record to payment history table
            $fee = $packageData['fee'];
            $currency = Subscription::LKR;

            $stmt = $con->prepare("INSERT INTO payment_history (member_id, due_date, paid_date, payment_method, amount, currency_type) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $memberID, $startDate, $lastPidDate, $method, $fee, $currency);
            $stmt->execute();
            $payHistoryID = $con->insert_id;
            // var_dump($payHistoryID); exit;

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


    public static function addInvoice($invoiceNum,$id,$memberID,$today,$updatedBy,$membershipID){
        /* activate reporting */
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_ALL;

        $paymentStatus = self::PENDING;
        $status = self::ACTIVE;

        $con=$GLOBALS['con']; 
        try{
            // First of all, let's begin a transaction
            $con->begin_transaction();

            /** 
            * ADD sent invoices 
            */
            $stmt = $con->prepare("INSERT INTO invoice (invoice_number, invoice_id_number, member_id, sent_date, created_by, status) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE member_id = VALUES(member_id)");
            $stmt->bind_param("ssisis", $invoiceNum,$id, $memberID, $today, $updatedBy, $status);
            $stmt->execute();
            $invoiceID = $con->insert_id;

            /** 
            * Change Payement Status
            **/
            $sql = "UPDATE membership SET payment_status = ?  WHERE membership_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $paymentStatus, $membershipID);
            $stmt->execute();
           
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
	* Delete a sent invoice
	* @return object $result
	*/
    public static function deleteInvoice($invoiceID){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE invoice SET status=? WHERE invoice_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Subscription::DELETED, $invoiceID);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Get invoice details
	* @return object $result
	*/
    public static function getInvoiceDetails($member_id){

        mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

        $con=$GLOBALS['con']; 
        $sql = "SELECT invoice_number, invoice_id_number FROM invoice WHERE member_id = ? ORDER BY lmd DESC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $member_id);
        $stmt->execute();
        $result = mysqli_stmt_get_result($stmt);
        if ($stmt->error) {
            return false;
          }
        return $result;  
    }

    /** 
	* Get All payment history Details
	* @return object $result 
	*/
    public static function displayAllPaymentHistory(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  payment_history.payment_id,
                        CONCAT_WS(' ',member.first_name,member.last_name) AS member_name,
                        payment_history.amount,
                        payment_history.currency_type,
                        payment_history.payment_method,
                        payment_history.due_date,
                        payment_history.paid_date,
                        payment_history.status
                FROM payment_history
                INNER JOIN member ON payment_history.member_id = member.member_id
                WHERE member.status != 'D'   
                ORDER BY payment_history.payment_id DESC";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Get  paymjent count
	* @return object $result
	*/
    public static function getPaymentCountByMothod(){

        $xAxis = [];
        $web = [];
        $cash = [];
        $dataSet = [];
        
        $thisMnth = date("Y-m");
        $lastMnth = date("Y-m", strtotime("-1 months"));
        $lastTwMnth = date("Y-m", strtotime("-2 months"));
        $lastThrMnth = date("Y-m", strtotime("-3 months"));
        $lastFurMnth = date("Y-m", strtotime("-4 months"));

        $mnth1 = date("M");
        $mnth2 = date("M", strtotime("-1 months"));
        $mnth3 = date("M", strtotime("-2 months"));
        $mnth4 = date("M", strtotime("-3 months"));
        $mnth5 = date("M", strtotime("-4 months"));

        $xAxis = [$mnth5, $mnth4, $mnth3, $mnth2, $mnth1]; 

        // var_dump($xAxis); exit;

        $con=$GLOBALS['con'];
        $sql="  SELECT
                    COUNT(CASE WHEN payment_history.payment_method = 'W' && DATE_FORMAT(paid_date, '%Y-%m') = '$thisMnth' THEN 1 END) thisMnth_Web_count,
                    COUNT(CASE WHEN payment_history.payment_method = 'C' && DATE_FORMAT(paid_date, '%Y-%m') = '$thisMnth' THEN 1 END) thisMnth_cash_count,
                    COUNT(CASE WHEN payment_history.payment_method = 'W' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastMnth' THEN 1 END) lastMnth_Web_count,
                    COUNT(CASE WHEN payment_history.payment_method = 'C' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastMnth' THEN 1 END) lastMnth_cash_count,
                    COUNT(CASE WHEN payment_history.payment_method = 'W' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastTwMnth' THEN 1 END) lastTwMnth_Web_count,
                    COUNT(CASE WHEN payment_history.payment_method = 'C' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastTwMnth' THEN 1 END) lastTwMnth_cash_count,
                    COUNT(CASE WHEN payment_history.payment_method = 'W' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastThrMnth' THEN 1 END) lastThrMnth_Web_count,
                    COUNT(CASE WHEN payment_history.payment_method = 'C' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastThrMnth' THEN 1 END) lastThrMnth_cash_count,
                    COUNT(CASE WHEN payment_history.payment_method = 'W' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastFurMnth' THEN 1 END) lastFurMnth_Web_count,
                    COUNT(CASE WHEN payment_history.payment_method = 'C' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastFurMnth' THEN 1 END) lastFurMnth_cash_count
                FROM payment_history 
                INNER JOIN member ON payment_history.member_id = member.member_id
                WHERE 1=1
                AND member.status != 'D'";
        $result=$con->query($sql);

        $row = $result->fetch_assoc();

        $web = [
            $row['lastFurMnth_Web_count'],
            $row['lastThrMnth_Web_count'],
            $row['lastTwMnth_Web_count'],
            $row['lastMnth_Web_count'],
            $row['thisMnth_Web_count']

        ];

        $cash = [
            $row['lastFurMnth_cash_count'],
            $row['lastThrMnth_cash_count'],
            $row['lastTwMnth_cash_count'],
            $row['lastMnth_cash_count'],
            $row['thisMnth_cash_count']

        ];

        $dataSet = [ 
            'xAxis' => $xAxis ,
            'web' => $web , 
            'cash' => $cash
        ];

        return $dataSet;
    }

    /** 
	* Get sum of paid amount
	* @return object $result
	*/
    public static function getPaidAmountByCurrency(){

        $xAxis = [];
        $web = [];
        $cash = [];
        $dataSet = [];
        
        $thisMnth = date("Y-m");
        $lastMnth = date("Y-m", strtotime("-1 months"));
        $lastTwMnth = date("Y-m", strtotime("-2 months"));
        $lastThrMnth = date("Y-m", strtotime("-3 months"));
        $lastFurMnth = date("Y-m", strtotime("-4 months"));

        $mnth1 = date("M");
        $mnth2 = date("M", strtotime("-1 months"));
        $mnth3 = date("M", strtotime("-2 months"));
        $mnth4 = date("M", strtotime("-3 months"));
        $mnth5 = date("M", strtotime("-4 months"));

        $xAxis = [$mnth5, $mnth4, $mnth3, $mnth2, $mnth1]; 

        // var_dump($xAxis); exit;

        $con=$GLOBALS['con'];
        $sql="  SELECT
                    SUM(CASE WHEN payment_history.currency_type = 'USD' && DATE_FORMAT(paid_date, '%Y-%m') = '$thisMnth' THEN amount END) thisMnth_Web_sum,
                    SUM(CASE WHEN payment_history.currency_type = 'LKR' && DATE_FORMAT(paid_date, '%Y-%m') = '$thisMnth' THEN amount END) thisMnth_cash_sum,
                    SUM(CASE WHEN payment_history.currency_type = 'USD' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastMnth' THEN amount END) lastMnth_Web_sum,
                    SUM(CASE WHEN payment_history.currency_type = 'LKR' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastMnth' THEN amount END) lastMnth_cash_sum,
                    SUM(CASE WHEN payment_history.currency_type = 'USD' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastTwMnth' THEN amount END) lastTwMnth_Web_sum,
                    SUM(CASE WHEN payment_history.currency_type = 'LKR' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastTwMnth' THEN amount END) lastTwMnth_cash_sum,
                    SUM(CASE WHEN payment_history.currency_type = 'USD' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastThrMnth' THEN amount END) lastThrMnth_Web_sum,
                    SUM(CASE WHEN payment_history.currency_type = 'LKR' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastThrMnth' THEN amount END) lastThrMnth_cash_sum,
                    SUM(CASE WHEN payment_history.currency_type = 'USD' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastFurMnth' THEN amount END) lastFurMnth_Web_sum,
                    SUM(CASE WHEN payment_history.currency_type = 'LKR' && DATE_FORMAT(paid_date, '%Y-%m') = '$lastFurMnth' THEN amount END) lastFurMnth_cash_sum
                FROM payment_history 
                INNER JOIN member ON payment_history.member_id = member.member_id
                WHERE 1=1
                AND member.status != 'D'";
        $result=$con->query($sql);

        $row = $result->fetch_assoc();

        $web = [
            $row['lastFurMnth_Web_sum'],
            $row['lastThrMnth_Web_sum'],
            $row['lastTwMnth_Web_sum'],
            $row['lastMnth_Web_sum'],
            $row['thisMnth_Web_sum']

        ];

        $cash = [
            $row['lastFurMnth_cash_sum'],
            $row['lastThrMnth_cash_sum'],
            $row['lastTwMnth_cash_sum'],
            $row['lastMnth_cash_sum'],
            $row['thisMnth_cash_sum']

        ];

        $dataSet = [ 
            'xAxis' => $xAxis ,
            'web' => $web , 
            'cash' => $cash
        ];

        return $dataSet;
    }

    /** 
	* Get All unpaid Subscription
	* @return object $result 
	*/
    public static function getAllUnpaidSubscription($today){

        mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

        $con=$GLOBALS['con']; 
        $sql="  SELECT  membership.membership_id,
                        membership.end_date,
                        membership.member_id,
                        invoice.invoice_number,
                        invoice.invoice_id_number,
                        invoice.status as invoice_status,
                        membership.payment_status,
                        member.package_id
                FROM membership
                INNER JOIN member ON membership.member_id = member.member_id
                LEFT JOIN invoice ON invoice.member_id = membership.member_id
                WHERE member.status != 'D'   
                AND DATE(DATE_ADD(end_date, INTERVAL 11 DAY)) = ?
                ORDER BY membership.membership_id DESC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = mysqli_stmt_get_result($stmt);
        if ($stmt->error) {
            return false;
          }
        return $result;  
    }

    /** 
	* Get All expiring invoices
	* @return object $result 
	*/
    public static function getAllExpiringInvoices($today){

        mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

        $con=$GLOBALS['con']; 
        $sql="  SELECT  invoice.invoice_id,
                        invoice.invoice_number,
                        invoice.member_id,
                        invoice.sent_date,
                        invoice.invoice_id_number,
                        invoice.status,
                        membership.end_date,
                        membership.membership_id
                FROM invoice
                INNER JOIN member ON member.member_id = invoice.member_id
                INNER JOIN membership ON membership.member_id = member.member_id
                WHERE invoice.status = 'A'   
                AND DATE(DATE_ADD(membership.end_date, INTERVAL 11 DAY)) = ?
                ORDER BY invoice.invoice_id DESC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = mysqli_stmt_get_result($stmt);
        if ($stmt->error) {
            return false;
          }
        return $result;  
    }

    
    /** 
	* Get All active invoices
	* @return object $result 
	*/
    public static function getAllActiveInvoices(){

        mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

        $con=$GLOBALS['con']; 
        $sql="  SELECT  invoice.invoice_id,
                        invoice.invoice_number,
                        invoice.member_id,
                        invoice.sent_date,
                        invoice.invoice_id_number,
                        invoice.status,
                        member.package_id,
                        membership.membership_id
                FROM invoice
                INNER JOIN member ON member.member_id = invoice.member_id
                INNER JOIN membership ON membership.member_id = member.member_id
                WHERE invoice.status = 'A'   
                ORDER BY invoice.invoice_id DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = mysqli_stmt_get_result($stmt);
        if ($stmt->error) {
            return false;
          }
        return $result;  
    }

        /** 
	* Reactivate a membership
	* @return object $result 
	*/
    public static function updatePaypalMemberSubscription($memberID, $membershipID, $packageID, $invoiceIdNum, $paypalInvoiceNum, $fee){
        
        /* activate reporting */
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_ALL;

        $con=$GLOBALS['con']; 
        try {
            // First of all, let's begin a transaction
            $con->begin_transaction();

            //update member table
            $memberStatus = Member::ACTIVE;
 
            $sql = "UPDATE member SET package_id = ?, status = ? WHERE member_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("isi",$packageID, $memberStatus, $memberID);
            $stmt->execute();

            // Get package duration
            $packageDuration = Package::getPackageDuration($packageID);
            $packageData = $packageDuration->fetch_assoc();

            //get subscription details by id
            $subsData = Subscription::getSubscriptionDetailsByID($membershipID);
            $row = $subsData->fetch_assoc(); 

            $startDate = $row['end_date'];
            $lastPidDate = date("Y-m-d");

            $endDate = date('Y-m-d', strtotime("+".$packageData['duration']." months", strtotime($startDate)));

            $paymentStatus = Subscription::PAID;
    
            //update membership table
            $sql = "UPDATE membership SET start_date = ?, end_date = ?, last_paid_date = ?, payment_status = ?  WHERE membership_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssssi", $startDate, $endDate, $lastPidDate, $paymentStatus, $membershipID);
            $stmt->execute();

            //Insert record to payment history table
            $currency = Subscription::USD;
            $method = Subscription::WEB;

            $stmt = $con->prepare("INSERT INTO payment_history (member_id, due_date, paid_date, payment_method, amount, currency_type, invoice_number, invoice_id_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssss", $memberID, $startDate, $lastPidDate, $method, $fee, $currency, $paypalInvoiceNum, $invoiceIdNum);
            $stmt->execute();
            $payHistoryID = $con->insert_id;

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
	* deleting unpaid invoices
	* @return bool
	*/
    public static function deleteUnpaidInvoice($invoiceID,$membershipID){
        
        /* activate reporting */
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_ALL;

        $con=$GLOBALS['con']; 
        try {
            // First of all, let's begin a transaction
            $con->begin_transaction();

            //update invoice table
            $sql = "UPDATE invoice SET status=? WHERE invoice_id=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $status = Subscription::DELETED, $invoiceID);
            $stmt->execute();

            //update subscrption
            $paymentStatus = Subscription::LATE;
    
            //update membership table
            $sql = "UPDATE membership SET payment_status = ? WHERE membership_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $paymentStatus, $membershipID);
            $stmt->execute();


            // var_dump($payHistoryID); exit;

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

}