<?php

class Package{

    //Package status
        CONST ACTIVE = "A";
        CONST INACTIVE = "I";
        CONST DELETED = "D";
    
    /** 
	* Get All Package Details
	* @return object $result 
	*/
    public static function displayAllPackage(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  package.package_id,
                        package.package_name,
                        package.fee,
                        package.duration,
                        package.status
                FROM package 
                WHERE package.status != 'D'
                ORDER BY package_id DESC";
        $result=$con->query($sql);
        return $result;
    }

    /** 
	* Get All Active packages
	* @return object $result 
	*/
    public static function getActivePackage(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  package.package_id,
                        package.package_name
                FROM package 
                WHERE package.status = 'A'";
        $result=$con->query($sql);
        return $result;
    }
    
    function addPackage($package_name,$package_description,$package_ammount,$duration,$package_image){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO package VALUES('','$package_name','$package_description','$package_ammount','$duration','$package_image','Active')";
        $result=$con->query($sql);
        $package_id=$con->insert_id;
        return $package_id;
        
        
    }
    
    function updatePackage($package_name,$package_description,$price,$duration,$package_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE package SET package_name='$package_name',package_description='$package_description',price='$price',duration='$duration' WHERE package_id='$package_id'";
        $result=$con->query($sql);
    }
    
    function updatePackageImage($package_id,$new_image){
        $con=$GLOBALS['con'];
        $sql="UPDATE package SET package_image='$new_image' WHERE package_id='$package_id'";
        $result =$con->query($sql);
    }
    
    function activatePackage($package_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE package SET package_status='Active' WHERE package_id='$package_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivatePackage($package_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE package SET package_status='Deactive' WHERE package_id='$package_id'";
        $result=$con->query($sql);
        return $result;
    }
            
    function displayPackage($package_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM package WHERE package_id='$package_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    public static function getPackageDuration($package_id){
        
        $con = $GLOBALS['con'];
        $sql = "SELECT duration 
                FROM package 
                WHERE package_id='$package_id'";
        $result = $con->query($sql);
        return $result;
    }
   
}