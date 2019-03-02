<?php

class workout{
    
    function displayAllWorkout(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM exercise e, anatomy a WHERE e.anatomy_id=a.anatomy_id ORDER BY e.exercise_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    function displayAllExercise(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM exercise";
        $result=$con->query($sql);
        return $result;
    }
    function displayAllAnatomy(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM anatomy";
        $result=$con->query($sql);
        return $result;
    }
    
    function displayAllAnatomyExercise(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM anatomy a,exercise e WHERE a.anatomy_id = e.anatomy_id";
        $result=$con->query($sql);
        return $result;
    }
    
    function addWorkout($exercise_name,$anatomy_id){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO exercise VALUES('','$exercise_name','$anatomy_id','Active')";
        $result=$con->query($sql);
        $exercise_id=$con->insert_id;
        return $exercise_id;
        
        
    }
    
    function updateWorkout($exercise_name,$anatomy_id,$exercise_id){
        $con = $GLOBALS['con'];
        $sql="UPDATE exercise SET exercise_name='$exercise_name',anatomy_id='$anatomy_id' WHERE exercise_id='$exercise_id'";
        $result=$con->query($sql);
    }
    
    
    function activateWorkout($exercise_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE exercise SET exercise_status='Active' WHERE exercise_id='$exercise_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivateWorkout($exercise_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE exercise SET exercise_status='Deactive' WHERE exercise_id='$exercise_id'";
        $result=$con->query($sql);
        return $result;
    }         
    
    function displayWorkout($exercise_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM exercise e,anatomy a WHERE e.anatomy_id=a.anatomy_id AND exercise_id='$exercise_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    
    
}