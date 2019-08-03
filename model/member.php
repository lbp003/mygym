<?php

class Member{

    //Member status
    CONST ACTIVE = "A";
    CONST INACTIVE = "I";
    CONST DELETED = "D";
    CONST SUSPENDED = "S";

    //Gender

    CONST MALE = "M";
    CONST FEMALE = "F";
    
    // Get all member info
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
                WHERE member.status != 'D'
                ORDER BY member.member_id DESC";
        $result=$con->query($sql);
        // print_r($result); exit;
        return $result;
    }
    
    /** 
	* Insert a new member
	* @return object $last_id
	*/
    function addMember($firstName,$lastName,$email,$gender,$dob,$nic,$phone,$address,$packageID, $membershipNumber, $enPassword, $createdBy,$updatedBy, $lmd, $status){
        
        $con=$GLOBALS['con']; 
        $stmt = $con->prepare("INSERT INTO member (first_name, last_name, email, gender, dob, nic, telephone, address, package_id, membership_number, password, created_by, updated_by, lmd, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssissiiss", $firstName, $lastName, $email, $gender, $dob, $nic, $phone, $address, $packageID, $membershipNumber, $enPassword, $createdBy, $updatedBy, $lmd, $status);
        $stmt->execute();
        $last_id = $con->insert_id;
        if(isset($last_id) && !empty($last_id)){
            return $last_id;
        }else {
            return false;
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
	* Deactivate an employee
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
	* Delete an employee
	* @return object $result
	*/
    public static function deleteMember($member_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE member SET status=? WHERE member_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Member::DELETED, $member_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
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
                AND member.status != 'D'";
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
                AND member.member_id !='$member_id'";
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
}