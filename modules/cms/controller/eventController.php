<?php
include '../common/dbconnection.php';
include '../model/eventModel.php';
include '../model/loginModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

$status=$_REQUEST['status'];

$objev= new event();


switch ($status){
    
    case "Add":
        
        $event_title=$_POST['event_title'];
        $event_date=$_POST['event_date'];
        $event_venue=$_POST['event_venue'];
        $event_description=mysql_real_escape_string($_POST['event_description']);
        
        if($_FILES['event_image']['name'] != ""){
            
            $event_image=$_FILES['event_image']['name'];
            $event_loc = $_FILES['event_image']['tmp_name'];
            $new_image = time()."_". $event_image;
        }else{
            $new_image ="";
        }
              
            //add new event
         $event_id=$objev->addEvent($event_title,$event_date,$event_venue,$event_description,$new_image);
            
            //Adding an Image into event_image folder
            if($new_image!=""){
            $destination="../images/event_image/$new_image";
            move_uploaded_file($event_loc, $destination);
    
            }
            
            $msg=base64_encode("An Event has been Added");
            header("Location:../view/event.php?msg=$msg");

        
        
break;

    case "Update":
        
        $event_title=$_POST['event_title'];
        $event_date=$_POST['event_date'];
        $event_venue=$_POST['event_venue'];
        $event_description=mysql_real_escape_string($_POST['event_description']);
        
        if($_FILES['event_image']['name'] != ""){
            
            $event_image=$_FILES['event_image']['name'];
            $event_loc = $_FILES['event_image']['tmp_name'];
            $new_image = time()."_". $event_image;
        }else{
            $new_image ="";
        }
        
        $event_id =$_REQUEST['event_id']; 
        
        //update staff
            
        $objev->updateEvent($event_title,$event_date,$event_venue,$event_description,$event_id);
            
        
            //Adding an Image into event_image folder
            if($new_image!=""){
            $destination="../images/event_image/$new_image";
            move_uploaded_file($event_loc, $destination);
            
            $objev->updateEventImage($event_id, $new_image);
            }
            
            
            $msg=base64_encode("An Event has been Updated");
            header("Location:../view/event.php?msg=$msg");
            
break;
// Activate Event
    case "Active":
        $event_id=$_REQUEST['event_id'];
        $objev->activateEvent($event_id);
        header("Location:../view/event.php");
// Deactivate Event        
        break;
    case "Deactive":
        $event_id=$_REQUEST['event_id'];
        $objev->deactivateEvent($event_id);
        header("Location:../view/event.php");
        
        break;
// View Event 
    case "View":
        
        $event_id=$_REQUEST['event_id'];
        header("Location:../view/ViewEvent.php?event_id=$event_id");
        
break;
    
}

?>
