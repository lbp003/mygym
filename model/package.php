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
                        package.image,
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

    /**
	* Get package duration
	* @return object $result
	*/
    public static function getPackageDuration($package_id){
        
        $con = $GLOBALS['con'];
        $sql = "SELECT package.duration 
                FROM package 
                WHERE package.package_id='$package_id'
                AND package.status = 'A'
                LIMIT 1";
        $result = $con->query($sql);
        if($result){
            return $result;
        }
        false;
    }

    /**
	* Insert a new package
	* @return bool
	*/
    function addPackage($packageName, $fee, $duration, $description, $status){
        $con=$GLOBALS['con'];
        $stmt = $con->prepare("INSERT INTO package (package_name, fee, duration, package_description, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $packageName, $fee, $duration, $description, $status);
        $stmt->execute();
        $last_id = $con->insert_id;
        if(isset($last_id) && !empty($last_id)){
            return $last_id;
        }else {
            return false;
        }

    }

    /**
	* Add package image
	* @return bool
	*/
    public static function addPackageImage($package_id, $image){
        $con=$GLOBALS['con'];
        $sql = "UPDATE package SET image = ? WHERE package_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $image, $package_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /**
	* Update an existing package
	* @return bool
	*/
    public static function updatePackage($dataAr){
        $con=$GLOBALS['con'];
        $sql = "UPDATE package SET package_name = ?, package_description = ?, fee = ?, duration = ?, image = ? WHERE package_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssi", $dataAr['name'], $dataAr['description'], $dataAr['fee'], $dataAr['duration'], $dataAr['img'], $dataAr['id']);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /**
	* Activate an package
	* @return bool 
	*/
    public static function activatePackage($package_id){
        $con=$GLOBALS['con'];
        $sql = "UPDATE package SET status = ? WHERE package_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::ACTIVE, $package_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /**
	* Deactivate a package
	* @return bool 
	*/
    public static function deactivatePackage($package_id){
        $con=$GLOBALS['con'];
        $sql = "UPDATE package SET status = ? WHERE package_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::INACTIVE, $package_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /**
	* Delete a package
	* @return bool 
	*/
    public static function deletePackage($package_id){
        $con=$GLOBALS['con'];
        $sql = "UPDATE package SET status = ? WHERE package_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::DELETED, $package_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /**
	* Check package name for  add new package
	* @return bool 
	*/
    public static function checkPackageName($package_name){
        $con=$GLOBALS['con'];
        $sql="  SELECT package.package_name 
                FROM package 
                WHERE package.package_name='$package_name' 
                AND package.status != 'D'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;
    }

    /**
	* Check package name for update an existing package
	* @return bool
	*/
    public static function checkUpdatePackageName($package_name, $package_id){
        $con=$GLOBALS['con'];
        $sql="  SELECT package.package_name 
                FROM package 
                WHERE package.package_name='$package_name' 
                AND package.status != 'D'
                AND package.package_id != '$package_id'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;
    }

    /**
	* Get the package data by package_id
	* @return object $result
	*/
    public static function getPackageByID($package_id){

        $con=$GLOBALS['con'];
        $sql="  SELECT
                    package.package_id,
                    package.package_name,
                    package.package_description,
                    package.duration,
                    package.fee,
                    package.image,
                    package.status
                FROM package 
                WHERE package.package_id = '$package_id'
                AND package.status != 'D'";
        $result=$con->query($sql);
        return $result;
    }
   
}