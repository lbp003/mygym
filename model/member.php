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
        $sql = "UPDATE member SET first_name=?, last_name=?, email=?, gender=?, dob=?, nic=?, telephone=?, address=?, package_id=?, membership_number=?, updated_by=?, image=?, lmd=? WHERE member_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssssssisissi", $dataAr['fname'], $dataAr['lname'], $dataAr['email'], $dataAr['gender'], $dataAr['dob'], $dataAr['nic'], $dataAr['phone'], $dataAr['address'],  $dataAr['package'], $dataAr['membership_num'], $dataAr['updated_by'], $dataAr['img'], $dataAr['lmd'], $dataAr['id']);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
    
    function updateMemberImage($member_id,$new_image){
        $con=$GLOBALS['con'];
        $sql="UPDATE member SET member_image='$new_image' WHERE member_id='$member_id'";
        $result =$con->query($sql);
    }
    
    function activateMember($member_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE member SET member_status='Active' WHERE member_id='$member_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivateMember($member_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE member SET member_status='Deactive' WHERE member_id='$member_id'";
        $result=$con->query($sql);
        return $result;
    }
            
    
    function displayMember($member_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM member m,login_member l WHERE m.member_id=l.member_id AND m.member_id='$member_id'";
        $result=$con->query($sql);
        return $result;
    }
   
    function addReg($uname,$email,$password,$activation){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO register_member VALUES('','$uname','$email','$password','$activation','Unverified')";
        $result=$con->query($sql);
        $reg_id=$con->insert_id;
        return $reg_id;
        
        
    }
    
    function regMember($reg_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM register_member WHERE reg_id='$reg_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function verifyMember($reg_id,$activation){
        
        $con=$GLOBALS['con'];
        $sql="SELECT * FROM register_member WHERE reg_id='$reg_id' AND activation_code='$activation'";
        $result=$con->query($sql);
        return $result;
    }
    
        function ConfirmMember($reg_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE register_member SET email_status='Confirmed' WHERE reg_id='$reg_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function getMember($reg_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM register_member WHERE reg_id='$reg_id'";
        $result=$con->query($sql);
        return $result;
    }
    function addOnlineMember($email){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO member VALUES('','','','$email','','','','','',4,'','Active')";
        $result=$con->query($sql);
        $member_id=$con->insert_id;
        return $member_id;
        
        
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