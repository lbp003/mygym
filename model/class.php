<?php

class Programs{

       //Class status
       CONST ACTIVE = "A";
       CONST INACTIVE = "I";
       CONST DELETED = "D";

    /* Get all class info
	* @return object $result
	*/
    public static function displayAllPrograms(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT 
                    class.class_id,
                    class.class_name,
                    class.class_description,
                    class.color,
                    class.image,
                    class.status
                FROM class 
                WHERE class.status != 'D'
                ORDER BY class.class_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    /** 
	* Insert a new class
	* @return object $last_id
	*/
    function addClass($className, $color, $description, $status){
        
        $con=$GLOBALS['con']; 
        $stmt = $con->prepare("INSERT INTO class (class_name, class_description, color, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $className, $description, $color, $status);
        $stmt->execute();
        $last_id = $con->insert_id;
        if(isset($last_id) && !empty($last_id)){
            return $last_id;
        }else {
            return false;
        }
            
    }

    /** 
	* Add class image
	* @return object $result
	*/
    public static function addClassImage($class_id, $image){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE class SET image=? WHERE class_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $image, $class_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
    
    /** 
	* Update an existing class
	* @return object $result
	*/
    public static function updateClass($dataAr){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE class SET class_name = ?, class_description = ?, color = ?, image = ? WHERE class_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $dataAr['name'], $dataAr['description'], $dataAr['color'], $dataAr['img'], $dataAr['id']);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
   
    /** 
	* Activate an class
	* @return object $result
	*/
    public static function activateClass($class_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE class SET status=? WHERE class_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Programs::ACTIVE, $class_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Deactivate a class
	* @return object $result
	*/
    public static function deactivateClass($class_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE class SET status=? WHERE class_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Programs::INACTIVE, $class_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Delete a class
	* @return object $result
	*/
    public static function deleteClass($class_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE class SET status=? WHERE class_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Programs::DELETED, $class_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
   
    /** 
	* Check class name for  add new class
	* @return object $result
	*/
    public static function checkClassName($className){
        $con=$GLOBALS['con'];
        $sql="  SELECT class.class_name 
                FROM class 
                WHERE class.class_name='$className' 
                AND class.status != 'D'";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Check class name for update an existing class
	* @return object $result
	*/
    public static function checkUpdateClassName($className, $class_id){
        $con=$GLOBALS['con'];
        $sql="  SELECT class.class_name 
                FROM class 
                WHERE class.class_name='$className' 
                AND class.status != 'D'
                AND class.class_id != $class_id";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Get the class data by class_id
	* @return object $result
	*/
    public static function getClassByID($class_id){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    class.class_id,
                    class.class_name,
                    class.class_description,
                    class.color,
                    class.image,
                    class.status
                FROM class 
                WHERE class.class_id = '$class_id'
                AND class.status != 'D'";
        $result=$con->query($sql);
        return $result;
    }
   
}