<?php
include '../common/dbconnection.php';
include '../model/scheduleModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

$status=$_REQUEST['status'];

$objsc= new schedule();


switch ($status){
    
    case "Add":
        
        $training_id = $_POST['training'];
        $day = $_POST['day'];
        $stime = $_POST['stime'];
        $etime = $_POST['etime'];
        $color = $_POST['color'];
                     
        //add new schedule
        $schedule_id=$objsc->addSchedule($training_id,$day,$stime,$etime,$color);            
        $msg=base64_encode("A Schedule has been Added");
        header("Location:../view/schedule.php?msg=$msg");
        
break;

    case "Update":
        
        $training_id = $_POST['training'];
        $day = $_POST['day'];
        $stime = $_POST['stime'];
        $etime = $_POST['etime'];
        $color = $_POST['color'];
                
        $schedule_id=$_REQUEST['schedule_id']; 
        
        //update schedule          
        $objsc->updateSchedule($training_id,$day,$stime,$etime,$color,$schedule_id);
        $msg=base64_encode("A schedule has been updated");
        header("Location:../view/schedule.php?msg=$msg");           
break;
// Activate Schedule
    case "Active":
        $schedule_id=$_REQUEST['schedule_id'];
        $objsc->activateSchedule($schedule_id);
        header("Location:../view/schedule.php");
        
// Deactivate Schedule        
break;
    case "Deactive":
        $schedule_id=$_REQUEST['schedule_id'];
        $objsc->deactivateSchedule($schedule_id);
        header("Location:../view/schedule.php");
        
break;
// View Schedule 
    case "View":
        
        $schedule_id=$_REQUEST['schedule_id'];
        header("Location:../view/ViewSchedule.php?schedule_id=$schedule_id");
        
break;
    
}

?>
