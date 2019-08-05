<?php

class classSession{

       //class Schedule status
       CONST ACTIVE = "A";
       CONST INACTIVE = "I";
       CONST DELETED = "D";
       CONST SUSPENDED = "S";
    
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
                LEFT JOIN staff ON class.instructor_id = staff.staff_id 
                WHERE class_session.status != 'D'
                ORDER BY class_session_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    function addSchedule($training_id,$day,$stime,$etime,$color){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO schedule VALUES('','$training_id','$day','$stime','$etime','$color','Active')";
        $result=$con->query($sql);
        $schedule_id=$con->insert_id;
        return $schedule_id;
        
        
    }
    
    function updateSchedule($training_id,$day,$stime,$etime,$color,$schedule_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE schedule SET training_id='$training_id',day='$day',start_time='$stime',end_time='$etime',color='$color' WHERE schedule_id='$schedule_id'";
        $result=$con->query($sql);
    }

    function activateSchedule($schedule_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE schedule SET schedule_status='Active' WHERE schedule_id='$schedule_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivateSchedule($schedule_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE schedule SET schedule_status='Deactive' WHERE schedule_id='$schedule_id'";
        $result=$con->query($sql);
        return $result;
    }
            
    function displaySchedule($schedule_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM schedule s,trainings t WHERE s.training_id=t.training_id && schedule_id='$schedule_id'";
        $result=$con->query($sql);
        return $result;
    }
   
}