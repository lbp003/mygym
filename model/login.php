<?php

//Login class
class Login{
    /** 
	* Return All Employee Details
	* @return object $result 
	*/
    public static function validateStaffLogin($email,$password){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT 
                    staff.staff_id,
                    staff.first_name,
                    staff.last_name,
                    staff.email,
                    staff.address,
                    staff.gender,
                    staff.dob,
                    staff.nic,
                    staff.telephone,
                    staff.staff_type,
                    staff.image,
                    staff.status
                FROM staff 
                WHERE staff.email='$email' 
                AND staff.password='$password'
                AND staff.status = 'A'";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Return All member Details
	* @return object $result 
	*/
    public static function validateMemberLogin($email,$password){
        $con=$GLOBALS['con'];//To get connection string
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
                    member.image,
                    member.status,
                    package.package_id,
                    package.package_name,
                    membership.membership_id,
                    membership.start_date,
                    membership.end_date,
                    membership.last_paid_date,
                    membership.status,
                    membership.payment_status
                FROM member
                LEFT JOIN package ON member.package_id = package.package_id
                INNER JOIN membership ON member.member_id = membership.member_id 
                WHERE member.email='$email' 
                AND member.password='$password'
                AND member.status = 'A'";
        $result=$con->query($sql);
        return $result;
    }
}
