<?php

class Exercise{

     //Exercise status
     CONST ACTIVE = "A";
     CONST INACTIVE = "I";
     CONST DELETED = "D";
     CONST SUSPENDED = "S";
    
    public static function displayAllExercise(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT  exercise.exercise_id,
                        exercise.exercise_name,
                        exercise.status,
                        anatomy.anatomy_name 
                FROM exercise 
                INNER JOIN anatomy ON exercise.anatomy_id = anatomy.anatomy_id
                WHERE exercise.status != 'D' 
                ORDER BY exercise.exercise_id DESC";
        $result=$con->query($sql);
        return $result;
    }

    /* Get all anatomy info
	* @return object $result
	*/
    public static function getAllAnatomy(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="  SELECT 
                    anatomy.anatomy_id,
                    anatomy.anatomy_name
                FROM anatomy
                WHERE 1=1
                ORDER BY anatomy.anatomy_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    /** 
	* Insert a new exercise
	* @return object $last_id
	*/
    function addExercise($exerciseName, $anatomy, $status){
        
        $con=$GLOBALS['con']; 
        $stmt = $con->prepare("INSERT INTO exercise (exercise_name, anatomy_id, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $exerciseName, $anatomy, $status);
        $stmt->execute();
        $last_id = $con->insert_id;
        if(isset($last_id) && !empty($last_id)){
            return $last_id;
        }else {
            return false;
        }
            
    }

    /** 
	* Update an existing exercise
	* @return object $result
	*/
    public static function updateExercise($dataAr){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE exercise SET exercise_name = ?, anatomy_id = ? WHERE exercise_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sii", $dataAr['name'], $dataAr['anatomy'], $dataAr['id']);
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
    public static function activateExercise($exercise_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE exercise SET status = ? WHERE exercise_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::ACTIVE, $exercise_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Deactivate a exercise
	* @return object $result
	*/
    public static function deactivateExercise($exercise_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE exercise SET status=? WHERE exercise_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::INACTIVE, $exercise_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Delete a exercise
	* @return object $result
	*/
    public static function deleteExercise($exercise_id){
        $con=$GLOBALS['con']; 
        $sql = "UPDATE exercise SET status=? WHERE exercise_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $status = self::DELETED, $exercise_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
          }
         return true;
    }

    /** 
	* Check exercise name for  add new exercise
	* @return object $result
	*/
    public static function checkExerciseName($exerciseName){
        $con=$GLOBALS['con'];
        $sql="  SELECT exercise.exercise_name 
                FROM exercise 
                WHERE exercise.exercise_name='$exerciseName' 
                AND exercise.status != 'D'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Check exercise name for update an existing exercise
	* @return object $result
	*/
    public static function checkUpdateExerciseName($exerciseName, $exercise_id){
        $con=$GLOBALS['con'];
        $sql="  SELECT exercise.exercise_name 
                FROM exercise 
                WHERE exercise.exercise_name='$exerciseName' 
                AND exercise.status != 'D'
                AND exercise.exercise_id != '$exercise_id'
                LIMIT 1";
        $result=$con->query($sql);
        if($result->num_rows == 0){
            return true;
        }
        return false;      
    }

    /** 
	* Get the exercise data by exercise_id
	* @return object $result
	*/
    public static function getExerciseByID($exercise_id){
        
        $con=$GLOBALS['con'];
        $sql="  SELECT
                    exercise.exercise_id,
                    exercise.exercise_name,
                    exercise.anatomy_id,
                    exercise.status
                FROM exercise 
                WHERE exercise.exercise_id = '$exercise_id'
                AND exercise.status != 'D'";
        $result=$con->query($sql);
        return $result;
    }
}