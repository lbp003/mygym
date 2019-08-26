<?php

class Event{

    //Event status
    CONST ACTIVE = "A";
    CONST INACTIVE = "I";
    CONST DELETED = "D";
    
    public static function displayAllEvent(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  event.event_id,
                        event.event_title,
                        event.event_date,
                        event.event_venue,
                        event.event_description,
                        event.image,
                        event.status
                FROM event
                WHERE event.status != 'D' 
                ORDER BY event.event_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    /** 
	* Insert a new event
	* @return object $last_id
	*/
    function addEvent($event_title, $date, $venue, $startTime, $endTime, $description, $status){
        
        $con=$GLOBALS['con']; 
        $stmt = $con->prepare("INSERT INTO event (event_title, event_date, event_venue, start_time, end_time, event_description, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $event_title, $date, $venue, $startTime, $endTime, $description, $status);
        $stmt->execute();
        $last_id = $con->insert_id;
        if(isset($last_id) && !empty($last_id)){
            return $last_id;
        }else {
            return false;
        }
            
    }

    /** 
	* Add event image
	* @return object $result
	*/
    public static function addEventImage($event_id, $image){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE event SET image=? WHERE event_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $image, $event_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
    
    /** 
	* Update an existing event
	* @return object $result
	*/
    public static function updateEvent($dataAr){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE event SET event_title = ?, class_description = ?, color = ?, image = ? WHERE event_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $dataAr['name'], $dataAr['description'], $dataAr['color'], $dataAr['img'], $dataAr['id']);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
   
    /** 
	* Activate an event
	* @return object $result
	*/
    public static function activateEvent($event_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE event SET status=? WHERE event_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::ACTIVE, $event_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Deactivate a event
	* @return object $result
	*/
    public static function deactivateEvent($event_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE event SET status=? WHERE event_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::INACTIVE, $event_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Delete a event
	* @return object $result
	*/
    public static function deleteEvent($event_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE event SET status=? WHERE event_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::DELETED, $event_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }
   
    /** 
	* Check event name for  add new event
	* @return object $result
	*/
    public static function checkEventName($event_title){
        $con=$GLOBALS['con'];
        $sql="  SELECT event.event_title 
                FROM event 
                WHERE event.event_title='$event_title' 
                AND event.status != 'D'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Check event name for update an existing event
	* @return object $result
	*/
    public static function checkUpdateEventName($event_title, $event_id){
        $con=$GLOBALS['con'];
        $sql="  SELECT event.event_title 
                FROM event 
                WHERE event.event_title='$event_title' 
                AND event.status != 'D'
                AND event.event_id != '$event_id'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Get the event data by event_id
	* @return object $result
	*/
    public static function getEventByID($event_id){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    event.event_id,
                    event.event_title,
                    event.event_description,
                    event.event_venue,
                    event.start_time,
                    event.end_time,
                    event.event_date,
                    event.image,
                    event.status
                FROM event 
                WHERE event.event_id = '$event_id'
                AND event.status != 'D'";
        $result=$con->query($sql);
        return $result;
    }
}