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
                        member.joined_date,
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
    function addMember($firstName,$lastName,$email,$gender,$dob,$nic,$phone,$address,$packageID, $membershipNumber, $enPassword, $createdBy,$updatedBy, $lmd, $status, $joinedDate){
        
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
            $stmt = $con->prepare("INSERT INTO member (first_name, last_name, email, gender, dob, nic, telephone, address, package_id, membership_number, password, created_by, updated_by, lmd, status, joined_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssissiisss", $firstName, $lastName, $email, $gender, $dob, $nic, $phone, $address, $packageID, $membershipNumber, $enPassword, $createdBy, $updatedBy, $lmd, $status, $joinedDate);
            $stmt->execute();
            $memberID = $con->insert_id;

            // Get package duration
            $packageDuration = Package::getPackageDuration($packageID);
            $packData = $packageDuration->fetch_assoc();

            //subscription end date
            $date = date("Y-m-d");
            $lastPidDate = date("Y-m-d");
            $lmd = date('Y-m-d H:i:s', time());

            $endDate = date('Y-m-d', strtotime("+".$packData['duration']." months", strtotime($date)));

            $paymentStatus = Subscription::PAID;
            $status = Subscription::ACTIVE;

            // $con->query("INSERT INTO membership (member_id, package_id, start_date, end_date, last_paid_date, payment_status, status, created_by, updated_by, lmd) VALUES ($memberID, $packageID, $date, $endDate, $lastPidDate, $paymentStatus, $status, $createdBy, $updatedBy, $lmd)");
            $stmt = $con->prepare("INSERT INTO membership (member_id, start_date, end_date, last_paid_date, payment_status, status, created_by, updated_by, lmd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssiis", $memberID,$date,$endDate,$lastPidDate,$paymentStatus,$status,$createdBy,$updatedBy,$lmd);
            $stmt->execute();
            $membershipID = $con->insert_id;

            $method = Subscription::CASH;
            $fee = $packData['fee'];
            $currency = Subscription::LKR;

            $stmt = $con->prepare("INSERT INTO payment_history (member_id, due_date, paid_date, payment_method, lmd, amount, currency_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $memberID, $endDate, $lastPidDate, $method, $lmd, $fee, $currency);
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
        $sql = "UPDATE member SET first_name=?, last_name=?, email=?, gender=?, dob=?, nic=?, telephone=?, address=?, membership_number=?, updated_by=?, image=?, lmd=?, package_id=? WHERE member_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssssssissii", $dataAr['fname'], $dataAr['lname'], $dataAr['email'], $dataAr['gender'], $dataAr['dob'], $dataAr['nic'], $dataAr['phone'], $dataAr['address'], $dataAr['membership_num'], $dataAr['updated_by'], $dataAr['img'], $dataAr['lmd'], $dataAr['package_id'], $dataAr['id']);
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
        $status = Member::ACTIVE;
        $con=$GLOBALS['con']; 
        $sql = "UPDATE member SET status=? WHERE member_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status, $member_id);
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
        $status=Member::INACTIVE;
        $con=$GLOBALS['con']; 
        $sql = "UPDATE member SET status=? WHERE member_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status, $member_id);
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
                    member.status,
                    member.joined_date
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

        $con=$GLOBALS['con']; 
        try{
            // First of all, let's begin a transaction
            $con->begin_transaction();

            foreach($outMemberAr as $member_id){
                $sql = "UPDATE member SET  member.status = ? WHERE member_id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $status, $member_id);
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
    public static function updatePackage($packageID,$updatedBy,$memberID){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE member SET member.package_id = ?, member.updated_by = ? WHERE member.member_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iii",$packageID,$updatedBy,$memberID);
        $stmt->execute();
        if ($stmt->error) {
            // echo $stmt->error; exit;
            return false;
          }
         return true;
    }

    /** 
	* Insert a new bmi record
	* @return bool
	*/
    public static function addBMI($memberID, $weight, $height, $bmiValue, $date, $status){
        $con=$GLOBALS['con']; 
        $stmt = $con->prepare("INSERT INTO bmi (member_id, height, weight, bmi_value, date, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $memberID,$height,$weight,$bmiValue,$date,$status);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;      
    }

    /** 
	* Insert a new body fat record
	* @return bool
	*/
    public static function addBF($memberID, $chest, $axila, $tricep, $subscapular, $abdominal, $suprailiac, $thigh, $age, $bfValue, $date){
        $con=$GLOBALS['con']; 
        $stmt = $con->prepare("INSERT INTO bodyfat (axilla, suprailiac, chest, tricep, abdominal, thigh, subscapular, age, bodyfat, member_id, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssisis", $axila,$suprailiac,$chest,$tricep,$abdominal,$thigh,$subscapular,$age,$bfValue,$memberID,$date);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;      
    }
    
    /** 
	* Get member bmi data 
	* @return object $result
	*/
    public static function getBMIDataById($member_id){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    bmi_id,
                    member_id,
                    height,
                    weight,
                    bmi_value,
                    date,
                    DATE_FORMAT(date, '%Y') as year,
                    DATE_FORMAT(date, '%m') as month,
                    DATE_FORMAT(date, '%d') as day,
                    status
                FROM bmi 
                WHERE bmi.member_id = '$member_id'";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Get member bodyfat data 
	* @return object $result
	*/
    public static function getBFDataById($member_id){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    data_id,
                    member_id,
                    axilla,
                    suprailiac,
                    chest,
                    tricep,
                    abdominal,
                    thigh,
                    subscapular,
                    age,
                    bodyfat,
                    date,
                    DATE_FORMAT(date, '%Y') as year,
                    DATE_FORMAT(date, '%m') as month,
                    DATE_FORMAT(date, '%d') as day,
                    status
                FROM bodyfat 
                WHERE bodyfat.member_id = '$member_id'";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Check email for update email address
	* @return object $result
	*/
    public static function forgetPasswordEmailCheck($email){
        $con=$GLOBALS['con'];
        $sql="  SELECT  member.member_id,
                        member.email 
                FROM member 
                WHERE member.email='$email' 
                AND member.status != 'D'
                LIMIT 1";
        $result=$con->query($sql);
        if($result){
            return $result;
        }
        return false;      
    }

    /** 
	* Update password
	* @return object $result
	*/
    public static function updateMemberPassword($member_id, $encPassword){
        $con=$GLOBALS['con'];
        $sql="  UPDATE  member
                SET member.password = '$encPassword' 
                WHERE member.member_id='$member_id'";
        $result=$con->query($sql);
        if($result){
            return true;
        }
        return false;      
    }

    /** 
	* check current password
	* @return object $result
	*/
    public static function checkPasswordByID($member_id,$password){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT member.member_id 
                FROM member 
                WHERE member.password='$password' 
                AND member.status != 'D'
                AND member.member_id ='$member_id'
                LIMIT 1";
        $result=$con->query($sql);
       
        if($result->num_rows > 0){
            return true;
        }
        return false;
    }

    
}