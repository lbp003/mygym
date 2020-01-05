<?php
include_once 'role.php';
class Staff{

    // User Types of the system
    CONST SUPER_ADMIN = "S";
    CONST ADMIN = "A";
    CONST MANAGER = "M";
    CONST TRAINER = "T";

    //staff status
    CONST ACTIVE = "A";
    CONST INACTIVE = "I";
    CONST DELETED = "D";
    CONST SUSPENDED = "S";
    
    /** 
	* Get All Staff Details
	* @return object $result 
	*/
    public static function displayAllStaff(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT 
                    staff.staff_id,
                    staff.first_name,
                    staff.last_name,
                    staff.email,
                    staff.address,
                    staff.gender,
                    staff.dob,
                    staff.joined_date,
                    staff.nic,
                    staff.telephone,
                    staff.staff_type,
                    staff.image,
                    staff.status
                FROM staff 
                WHERE staff.status != 'D'
                AND staff.staff_type != 'S'
                ORDER BY staff.staff_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    /** 
	* Insert a new Staff member
	* @return object $last_id
	*/
    function addStaff($firstName,$lastName,$email,$gender,$dob, $joinedDate,$nic,$phone,$address,$user_type, $enPassword, $lmd, $status){
        
        $con=$GLOBALS['con']; 
        $stmt = $con->prepare("INSERT INTO staff (first_name, last_name, email, gender, dob, joined_date, nic, telephone, address, staff_type, password, lmd, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssss", $firstName, $lastName, $email, $gender, $dob, $joinedDate, $nic, $phone, $address, $user_type, $enPassword, $lmd, $status);
        $stmt->execute();
        $last_id = $con->insert_id;
        if(isset($last_id) && !empty($last_id)){
            return $last_id;
        }else {
            return false;
        }
            
    }
    
    /** 
	* Update a existing Staff member
	* @return object $result
	*/
    public static function updateStaff($dataAr){
        // var_dump($dataAr); exit;
        $con=$GLOBALS['con']; 
        $sql = "UPDATE staff SET first_name=?, last_name=?, email=?, gender=?, dob=?, joined_date=?, nic=?, telephone=?, address=?, staff_type=?, image=?, lmd=? WHERE staff_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssssssssssi", $dataAr['fname'], $dataAr['lname'], $dataAr['email'], $dataAr['gender'], $dataAr['dob'], $dataAr['joined_date'], $dataAr['nic'], $dataAr['phone'], $dataAr['address'], $dataAr['type'], $dataAr['img'], $dataAr['lmd'], $dataAr['id']);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
    
    /** 
	* Activate an employee
	* @return object $result
	*/
    public static function activateEmployee($staff_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE staff SET status=? WHERE staff_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Staff::ACTIVE, $staff_id);
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
    public static function deactivateEmployee($staff_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE staff SET status=? WHERE staff_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Staff::INACTIVE, $staff_id);
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
    public static function deleteEmployee($staff_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE staff SET status=? WHERE staff_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Staff::DELETED, $staff_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
    
    /** 
	* Check email for  add new employee
	* @return object $result
	*/
    public static function checkEmail($email){
        $con=$GLOBALS['con'];
        $sql="  SELECT staff.email 
                FROM staff 
                WHERE staff.email='$email' 
                AND staff.status != 'D' 
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
    public static function checkUpdateEmail($email,$staff_id){
        $con=$GLOBALS['con'];
        $sql="  SELECT staff.email 
                FROM staff 
                WHERE staff.email='$email' 
                AND staff.status != 'D'
                AND staff.staff_id !='$staff_id'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }
    
    /** 
	* Get the employee data by staff_id
	* @return object $result
	*/
    public static function getEmployeeByID($staff_id){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    staff.staff_id,
                    staff.first_name,
                    staff.last_name,
                    staff.email,
                    staff.address,
                    staff.gender,
                    staff.dob,
                    staff.joined_date,
                    staff.nic,
                    staff.telephone,
                    staff.staff_type,
                    staff.image,
                    staff.status
                FROM staff 
                WHERE staff.staff_id = '$staff_id'
                AND staff.status != 'D'";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Get trainers of the gym
	* @return object $result
	*/
    public static function getTrainers(){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    staff.staff_id,
                    CONCAT_WS(' ',staff.first_name,staff.last_name) AS trainer_name
                FROM staff 
                WHERE 1=1
                AND staff.status = 'A' 
                AND staff.staff_type = 'T'";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Get staff count
	* @return object $result
	*/
    public static function getEmployeeCount($type){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    COUNT(staff.staff_id) AS staff
                FROM staff 
                WHERE 1=1
                AND staff.status = 'A' 
                AND staff.staff_type = '$type'";
        $result=$con->query($sql);
        return $result;
    }
   
    /** 
	* Get staff types count
	* @return object $result
	*/
    public static function getEmployeeTypesCount(){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    COUNT(CASE WHEN staff.staff_type = 'A' THEN 1 END) admin_count,
                    COUNT(CASE WHEN staff.staff_type = 'M' THEN 1 END) manager_count,
                    COUNT(CASE WHEN staff.staff_type = 'T' THEN 1 END) trainer_count
                FROM staff 
                WHERE 1=1
                AND staff.status = 'A'";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Check email for update email address
	* @return object $result
	*/
    public static function forgetPasswordEmailCheck($email){
        $con=$GLOBALS['con'];
        $sql="  SELECT  staff.staff_id,
                        staff.email 
                FROM staff 
                WHERE staff.email='$email' 
                AND staff.status != 'D'
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
    public static function updateStaffPassword($staff_id, $encPassword){
        $con=$GLOBALS['con'];
        $sql="  UPDATE  staff
                SET staff.password = '$encPassword' 
                WHERE staff.staff_id='$staff_id'";
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
    public static function checkPasswordByID($staff_id,$password){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT staff.staff_id 
                FROM staff 
                WHERE staff.password='$password' 
                AND staff.status != 'D'
                AND staff.staff_id ='$staff_id'
                LIMIT 1";
        $result=$con->query($sql);
       
        if($result->num_rows > 0){
            return true;
        }
        return false;
    }
   
}