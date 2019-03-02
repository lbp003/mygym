<?php

class backup{
    
    function displayAllEvent(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM event ORDER BY event_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    function addEvent($event_title,$event_date,$event_venue,$event_description,$event_image){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO event VALUES('','$event_title','$event_date','$event_venue','$event_description','$event_image','Active')";
        $result=$con->query($sql);
        $event_id=$con->insert_id;
        return $event_id;
        
        
    }
    
    function updateEvent($event_title,$event_date,$event_venue,$event_description,$event_id){
        $con = $GLOBALS['con'];
        $sql="UPDATE event SET event_title='$event_title',event_date='$event_date',event_venue='$event_venue',event_description='$event_description' WHERE event_id='$event_id'";
        $result=$con->query($sql);
    }
    
    function updateEventImage($event_id,$new_image){
        $con=$GLOBALS['con'];
        $sql="UPDATE event SET event_image='$new_image' WHERE event_id='$event_id'";
        $result =$con->query($sql);
    }
    
    function activateEvent($event_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE event SET event_status='Active' WHERE event_id='$event_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivateEvent($event_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE event SET event_status='Deactive' WHERE event_id='$event_id'";
        $result=$con->query($sql);
        return $result;
    }
            
    function displayEvent($event_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM event WHERE event_id='$event_id'";
        $result=$con->query($sql);
        return $result;
    }
   
}