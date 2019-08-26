<?php

class Session{

       //class Schedule status
       CONST ACTIVE = "A";
       CONST INACTIVE = "I";
       CONST DELETED = "D";
       CONST SUSPENDED = "S";


     /* Get all class seassion info
	* @return object $result
	*/
    public static function displayAllClassSession(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  class_session.class_session_id,
                        class_session.class_session_name,
                        class_session.day,
                        class_session.start_time,
                        class_session.end_time,
                        class_session.status,
                        class.class_name,
                        CONCAT_WS(' ',staff.first_name,staff.last_name) AS trainer_name
                FROM class_session
                LEFT JOIN class ON class_session.class_id = class.class_id
                LEFT JOIN staff ON class_session.instructor_id = staff.staff_id 
                WHERE class_session.status != 'D'
                ORDER BY class_session_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    /** 
	* Insert a new class session
	* @return object $last_id
	*/
    function addClassSession($sessionName, $class, $day, $startTime, $endTime, $instructor, $status){
        
        $con=$GLOBALS['con']; 
        $stmt = $con->prepare("INSERT INTO class_session (class_session_name, class_id, day, start_time, end_time, instructor_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssis", $sessionName, $class, $day, $startTime, $endTime, $instructor, $status);
        $stmt->execute();
        $last_id = $con->insert_id;
        if(isset($last_id) && !empty($last_id)){
            return $last_id;
        }else {
            return false;
        }
            
    }
    
    /** 
	* Update an existing class session
	* @return object $result
	*/
    public static function updateClassSession($dataAr){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE class_session SET class_session_name = ?, class_id = ?, day = ?, start_time = ?, end_time = ?, instructor_id = ? WHERE class_session_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sisssii", $dataAr['name'], $dataAr['class'], $dataAr['day'], $dataAr['start_time'], $dataAr['end_time'], $dataAr['instructor'], $dataAr['id']);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
   
    /** 
	* Activate an class session
	* @return object $result
	*/
    public static function activateClassSession($class_session_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE class_session SET status = ? WHERE class_session_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Session::ACTIVE, $class_session_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Deactivate a class session
	* @return object $result
	*/
    public static function deactivateClassSession($class_session_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE class_session SET status=? WHERE class_session_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Session::INACTIVE, $class_session_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Delete a class session
	* @return object $result
	*/
    public static function deleteClassSession($class_session_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE class_session SET status=? WHERE class_session_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = Session::DELETED, $class_session_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
   
    /** 
	* Check class session name for  add new class
	* @return object $result
	*/
    public static function checkSessionName($session_name){
        $con=$GLOBALS['con'];
        $sql="  SELECT class_session.class_name 
                FROM class_session 
                WHERE class_session.class_session_name='$session_name' 
                AND class_session.status != 'D'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Check class session name for update an existing class
	* @return object $result
	*/
    public static function checkUpdateSessionName($session_name, $session_id){
        $con=$GLOBALS['con'];
        $sql="  SELECT class_session.class_session_name 
                FROM class_session 
                WHERE class_session.class_name='$session_name' 
                AND class_session.status != 'D'
                AND class_session.class_session_id != '$session_id'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Get the class data by class_session_id
	* @return object $result
	*/
    public static function getClassSessionByID($class_session_id){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    class_session.class_session_id,
                    class_session.class_session_name,
                    class_session.class_id,
                    class_session.day,
                    class_session.start_time,
                    class_session.end_time,
                    class_session.instructor_id,
                    class_session.status
                FROM class_session 
                WHERE class_session.class_session_id = '$class_session_id'
                AND class_session.status != 'D'";
        $result=$con->query($sql);
        return $result;
    }
   
}