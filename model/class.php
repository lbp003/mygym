<?php

class Programs{

       //Class status
       CONST ACTIVE = "A";
       CONST INACTIVE = "I";
       CONST DELETED = "D";
    
    public static function displayAllPrograms(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT 
                    class.class_id,
                    class.class_name,
                    class.class_description,
                    class.color,
                    class.status
                FROM class 
                WHERE class.status != 'D'
                ORDER BY class.class_id DESC";
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
   
}