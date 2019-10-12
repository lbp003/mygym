<?php
include_once 'package.php';
include_once 'subscription.php';
class Member{

    //Member status
    CONST ACTIVE = "A";
    CONST INACTIVE = "I";
    CONST DELETED = "D";
    CONST SUSPENDED = "S";

    //Gender

    CONST MALE = "M";
    CONST FEMALE = "F";

    /* Get all member info
	* @return object $result
	*/
    public static function displayAllMember(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  
                        member.member_id,
                        member.first_name,
                        member.last_name,
                        member.email,
                        member.address,
                        member.telephone,
                        member.gender,
                        member.nic,
                        member.image,
                        member.status,
                        package.package_name
                FROM member
                LEFT JOIN package ON member.package_id = package.package_id
                INNER JOIN membership ON member.member_id = membership.member_id
                WHERE member.status != 'D'
                ORDER BY member.member_id DESC";
        $result=$con->query($sql);
        // print_r($result); exit;
        return $result;
    }
    
    /** 
	* Insert a new member
	* @return bool
	*/
    function addMember($firstName,$lastName,$email,$gender,$dob,$nic,$phone,$address,$packageID, $membershipNumber, $enPassword, $createdBy,$updatedBy, $lmd, $status){
        
        /* activate reporting */
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_ALL;

        $con=$GLOBALS['con']; 
        try {
            // First of all, let's begin a transaction
            $con->begin_transaction();
        
            // A set of queries; if one fails, an exception should be thrown
            // $con->query("INSERT INTO member (first_name, last_name, email, gender, dob, nic, telephone, address, package_id, membership_number, password, created_by, updated_by, lmd, status) VALUES ($firstName, $lastName, $email, $gender, $dob, $nic, $phone, $address, $packageID, $membershipNumber, $enPassword, $createdBy, $updatedBy, $lmd, $status)");
            // $memberID = $con->insert_id;
            $stmt = $con->prepare("INSERT INTO member (first_name, last_name, email, gender, dob, nic, telephone, address, package_id, membership_number, password, created_by, updated_by, lmd, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssissiiss", $firstName, $lastName, $email, $gender, $dob, $nic, $phone, $address, $packageID, $membershipNumber, $enPassword, $createdBy, $updatedBy, $lmd, $status);
            $stmt->execute();
            $memberID = $con->insert_id;

            // Get package duration
            $packageDuration = Package::getPackageDuration($packageID);
            $duration = $packageDuration->fetch_assoc();

            //subscription end date
            $date = date("Y-m-d");
            $lastPidDate = date("Y-m-d");
            $lmd = date('Y-m-d H:i:s', time());

            $endDate = date('Y-m-d', strtotime("+".$duration['duration']." months", strtotime($date)));

            $paymentStatus = Subscription::PAID;
            $status = Subscription::ACTIVE;

            // $con->query("INSERT INTO membership (member_id, package_id, start_date, end_date, last_paid_date, payment_status, status, created_by, updated_by, lmd) VALUES ($memberID, $packageID, $date, $endDate, $lastPidDate, $paymentStatus, $status, $createdBy, $updatedBy, $lmd)");
            $stmt = $con->prepare("INSERT INTO membership (member_id, start_date, end_date, last_paid_date, payment_status, status, created_by, updated_by, lmd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssiis", $memberID,$date,$endDate,$lastPidDate,$paymentStatus,$status,$createdBy,$updatedBy,$lmd);
            $stmt->execute();
            $membershipID = $con->insert_id;

            $method = Subscription::CASH;

            $stmt = $con->prepare("INSERT INTO payment_history (membership_id, member_id, start_date, end_date, paid_date, payment_method, lmd) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisssss", $membershipID, $memberID, $date, $endDate, $lastPidDate, $method, $lmd);
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
	* Update a existing  member
	* @return object $result
	*/
    public static function updateMember($dataAr){
        // var_dump($dataAr); exit;
        $con=$GLOBALS['con']; 
        $sql = "UPDATE member SET first_name=?, last_name=?, email=?, gender=?, dob=?, nic=?, telephone=?, address=?, membership_number=?, updated_by=?, image=?, lmd=? WHERE member_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssssssissi", $dataAr['fname'], $dataAr['lname'], $dataAr['email'], $dataAr['gender'], $dataAr['dob'], $dataAr['nic'], $dataAr['phone'], $dataAr['address'], $dataAr['membership_num'], $dataAr['updated_by'], $dataAr['img'], $dataAr['lmd'], $dataAr['id']);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Activate an member
	* @return object $result
	*/
    public static function activateMember($member_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE member SET status=? WHERE member_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Member::ACTIVE, $member_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
    
    /** 
	* Deactivate a member
	* @return object $result
	*/
    public static function deactivateMember($member_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE member SET status=? WHERE member_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Member::INACTIVE, $member_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Delete a member
	* @return bool
	*/
    public static function deleteMember($member_id){
        $con=$GLOBALS['con']; 
        $status = self::DELETED;
        try {
            // First of all, let's begin a transaction
            $con->begin_transaction();
        
            // A set of queries; if one fails, an exception should be thrown
            $con->query("UPDATE member SET member.status = '$status' WHERE member.member_id = '$member_id'");
            $con->query("UPDATE membership SET membership.status = '$status' WHERE membership.member_id = '$member_id'");
        
            // If we arrive here, it means that no exception was thrown
            // i.e. no query has failed, and we can commit the transaction
            $con->commit();
            return true;
        } catch (Exception $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $con->rollback();
            return false;
        }
    }

    /** 
	* Check email for  add new member
	* @return object $result
	*/
    public static function checkEmail($email){
        $con=$GLOBALS['con'];
        $sql="  SELECT member.email 
                FROM member 
                WHERE member.email='$email' 
                AND member.status != 'D'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Check email for update email address
	* @return object $result
	*/
    public static function checkUpdateEmail($email,$member_id){
        $con=$GLOBALS['con'];
        $sql="  SELECT member.email 
                FROM member 
                WHERE member.email='$email' 
                AND member.status != 'D'
                AND member.member_id !='$member_id'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Get the member data by member_id
	* @return object $result
	*/
    public static function getMemberByID($member_id){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    member.member_id,
                    member.first_name,
                    member.last_name,
                    member.email,
                    member.address,
                    member.gender,
                    member.dob,
                    member.nic,
                    member.telephone,
                    member.package_id,
                    member.membership_number,
                    member.image,
                    member.status
                FROM member 
                WHERE member.member_id = '$member_id'
                AND member.status != 'D'";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Deactivate bulk members
	* @return bool 
	*/
    public static function deactivateBulkMember($outMemberAr){
        /* activate reporting */
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_ALL;

        $status = self::INACTIVE;
        $subStatus = Subscription::INACTIVE;

        $con=$GLOBALS['con']; 
        try{
            // First of all, let's begin a transaction
            $con->begin_transaction();

            foreach($outMemberAr as $member_id){
                $sql = "UPDATE member SET  member.status = ? WHERE member_id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $status, $member_id);
                $stmt->execute();

                $sql = "UPDATE membership SET  membership.status = ? WHERE member_id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $subStatus, $member_id);
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
	* Get all members
	* @return object $result
	*/
    public static function getAllMembers(){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    member.member_id,
                    member.email,
                    CONCAT_WS(' ',member.first_name,member.last_name) AS member_name
                FROM member 
                WHERE 1=1
                AND member.status = 'A'";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Get all member name
	* @return object $result
	*/
    public static function getMemberNameByEmail($email){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    CONCAT_WS(' ',member.first_name,member.last_name) AS member_name
                FROM member 
                WHERE 1=1
                AND member.email = '$email'
                AND member.status = 'A'";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Update package
	* @return object $result
	*/
    public static function updatePackage($packageID,$updatedBy,$subscriptionID){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE member INNER JOIN membership ON membership.member_id = member.member_id SET member.package_id = ?, member.updated_by = ? WHERE membership.membership_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iii",$packageID,$updatedBy,$subscriptionID);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
}