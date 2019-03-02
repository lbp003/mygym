<?php
include '../common/dbconnection.php';
include '../model/myWorkoutModel.php';
include '../model/loginModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

$status=$_REQUEST['status'];

$objmyW= new workout();


switch ($status){
    
    case "Add":
        
        $exercise_name=$_POST['ename'];
        $anatomy_id=$_POST['anatomy'];


            //add new exercise
            $exercise_id=$objmyW->addWorkout($exercise_name,$anatomy_id);
                
            $msg=base64_encode("An Exercise has been Added");
            header("Location:../view/myWorkout.php?msg=$msg");
        
        
break;

    case "Update":
        
        $exercise_name=$_POST['ename'];
        $anatomy_id=$_POST['anatomy'];
        
        echo $exercise_id=$_REQUEST['exercise_id']; 
        
        //update myWorkout
            
        $objmyW->updateWorkout($exercise_name,$anatomy_id,$exercise_id);
            
        
            
            $msg=base64_encode("A Exercise has been Updated");
            header("Location:../view/myWorkout.php?msg=$msg");
            
break;
// Activate member
    case "Active":
        $exercise_id=$_REQUEST['exercise_id'];
        $objmyW->activateWorkout($exercise_id);
        header("Location:../view/myWorkout.php");
// Deactivate member        
        break;
    case "Deactive":
        $exercise_id=$_REQUEST['exercise_id'];
        $objmyW->deactivateWorkout($exercise_id);
        header("Location:../view/myWorkout.php");
        
        break;
// View myWorkout
    case "View":
        
        $member_id=$_REQUEST['exercise_id'];
        header("Location:../view/ViewmyWorkout.php?exercise_id=$exercise_id");
        
break;
    
}

?>
