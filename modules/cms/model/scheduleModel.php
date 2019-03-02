<?php

class schedule{
    
    function displayAllSchedule(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM schedule s,trainings t WHERE s.training_id = t.training_id ORDER BY schedule_id DESC";
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