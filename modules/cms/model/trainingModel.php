<?php

class trainings{
    
    function displayAllTrainings(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT trainings.training_id,trainings.training_name,trainings.training_description,trainings.training_image,trainings.training_status,staff.staff_fname,staff.staff_lname FROM trainings LEFT JOIN staff ON trainings.instructor_id = staff.staff_id ORDER BY trainings.training_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    function addTraining($training_name,$training_description,$instructor_id,$training_image){        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO trainings VALUES('','$training_name','$training_description','$instructor_id','$training_image','Active',3)";
        $result=$con->query($sql);
        $training_id=$con->insert_id;
        return $training_id;
        
        
    }
    
    function updateTraining($training_name,$training_description,$instructor_id,$training_id){
        $con = $GLOBALS['con'];
        $sql="UPDATE trainings SET training_name='$training_name',training_description='$training_description',instructor_id='$instructor_id' WHERE training_id='$training_id'";
        $result=$con->query($sql);
    }
    
    function updateTrainingImage($training_id,$new_image){
        $con=$GLOBALS['con'];
        $sql="UPDATE trainings SET training_image='$new_image' WHERE training_id='$training_id'";
        $result =$con->query($sql);
    }
    
    function activateTraining($training_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE trainings SET training_status='Active' WHERE training_id='$training_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivateTraining($training_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE trainings SET training_status='Deactive' WHERE training_id='$training_id'";
        $result=$con->query($sql);
        return $result;
    }
            
    function displayTraining($training_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM trainings WHERE training_id='$training_id'";
        $result=$con->query($sql);
        return $result;
    }
   
}