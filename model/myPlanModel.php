<?php

class myPlan{
    
//    function Dis(){
//        $con=$GLOBALS['con'];//To get connection string
//        $sql="SELECT * FROM event ORDER BY event_id DESC";
//        $result=$con->query($sql);
//        return $result;
//    }
   //BMI 
    function addBMI($height,$weight,$bmi,$member_id,$status){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO bmi VALUES('','$member_id','$height','$weight',NOW(),'$status')";
        $result=$con->query($sql);
        $bmi_id=$con->insert_id;
        return $bmi_id;
        
        
    }
    //Body Fat
    function addData($member_id,$axilla,$chest,$abdominal,$subscapular,$suprailiac,$tricep,$thigh,$bfp,$status){
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO bodyfat VALUES('','$axilla','$suprailiac','$chest','$tricep','$abdominal','$thigh','$subscapular','$bfp','$member_id',NOW(),'$status')";
        $result=$con->query($sql);
        $data_id=$con->insert_id;
        return $data_id;
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