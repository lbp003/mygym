<?php

class Equipment{

     //Equipment status
     CONST ACTIVE = "A";
     CONST INACTIVE = "I";
     CONST DELETED = "D";


    /** 
	* Get All Equipment Details
	* @return object $result 
	*/
    public static function displayAllEquipment(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  equipment.equipment_id,
                        equipment.equipment_name,
                        equipment.equipment_description,
                        equipment.image,
                        equipment.status 
                FROM equipment 
                WHERE equipment.status != 'D' 
                ORDER BY equipment.equipment_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    /** 
	* Insert a new equipment
	* @return object $last_id
	*/
    function addEquipment($equipmentName, $description, $status){
        
        $con=$GLOBALS['con']; 
        $stmt = $con->prepare("INSERT INTO equipment (equipment_name, equipment_description, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $equipmentName, $description, $status);
        $stmt->execute();
        $last_id = $con->insert_id;
        if(isset($last_id) && !empty($last_id)){
            return $last_id;
        }else {
            return false;
        }
            
    }

    /** 
	* Add equipment image
	* @return object $result
	*/
    public static function addEquipmentImage($equipment_id, $image){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE equipment SET image = ? WHERE equipment_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $image, $equipment_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }  

    /** 
	* Update an existing equipment
	* @return object $result
	*/
    public static function updateEquipment($dataAr){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE equipment SET equipment_name = ?, equipment_description = ?, image = ? WHERE equipment_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssi", $dataAr['name'], $dataAr['description'], $dataAr['img'], $dataAr['id']);
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
    public static function activateEquipment($equipment_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE equipment SET status = ? WHERE equipment_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::ACTIVE, $equipment_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Deactivate a equipment
	* @return object $result
	*/
    public static function deactivateEquipment($equipment_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE equipment SET status = ? WHERE equipment_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::INACTIVE, $equipment_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Delete a equipment
	* @return object $result
	*/
    public static function deleteEquipment($equipment_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE equipment SET status = ? WHERE equipment_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::DELETED, $equipment_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Check equipment name for  add new equipment
	* @return object $result
	*/
    public static function checkEquipmentName($equipmentName){
        $con=$GLOBALS['con'];
        $sql="  SELECT equipment.equipment_name 
                FROM equipment 
                WHERE equipment.equipment_name='$equipmentName' 
                AND equipment.status != 'D'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Check equipment name for update an existing equipment
	* @return object $result
	*/
    public static function checkUpdateEquipmentName($equipmentName, $equipment_id){
        $con=$GLOBALS['con'];
        $sql="  SELECT equipment.equipment_name 
                FROM equipment 
                WHERE equipment.equipment_name='$equipmentName' 
                AND equipment.status != 'D'
                AND equipment.equipment_id != '$equipment_id'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Get the equipment data by equipment_id
	* @return object $result
	*/
    public static function getEquipmentByID($equipment_id){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    equipment.equipment_id,
                    equipment.equipment_name,
                    equipment.equipment_description,
                    equipment.image,
                    equipment.status
                FROM equipment 
                WHERE equipment.equipment_id = '$equipment_id'
                AND equipment.status != 'D'";
        $result=$con->query($sql);
        return $result;
    }
}