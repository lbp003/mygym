 <?php
include '../common/dbconnection.php';
include '../model/trainingModel.php';
include '../model/loginModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

$status=$_REQUEST['status'];

$objtr= new trainings();

switch ($status){
    
    case "Add":
        
        $training_name=$_POST['training_name'];
        $training_description=mysql_real_escape_string($_POST['training_description']);
        $instructor_id=$_POST['instructor_id'];
        
        if($_FILES['training_image']['name'] != ""){
            
            $training_image=$_FILES['training_image']['name'];
            $training_loc = $_FILES['training_image']['tmp_name'];
            $new_image = time()."_". $training_image;
        }else{
            $new_image ="";
        }
              
            //add new event
         $training_id=$objtr->addTraining($training_name,$training_description,$instructor_id,$new_image);
            
            //Adding an Image into trainings_image folder
            if($new_image!=""){
            $destination="../images/training_image/$new_image";
            move_uploaded_file($$training_loc, $destination);
    
            }
            
            $msg=base64_encode("A Training has been Added");
            header("Location:../view/trainings.php?msg=$msg");

        
        
break;

    case "Update":
        
        $training_name=$_POST['training_name'];
        $training_description=mysql_real_escape_string($_POST['training_description']);
        $instructor_id=$_POST['instructor_id'];
        
        if($_FILES['training_image']['name'] != ""){
            
            $training_image=$_FILES['training_image']['name'];
            $training_loc = $_FILES['training_image']['tmp_name'];
            $new_image = time()."_". $training_image;
        }else{
            $new_image ="";
        }
        
        $training_id =$_REQUEST['training_id']; 
        echo $training_id;
        
        //update trainings
            
        $objtr->updateTraining($training_name,$training_description,$instructor_id,$training_id);
            
        
            //Adding an Image into event_image folder
            if($new_image!=""){
            $destination="../images/training_image/$new_image";
            move_uploaded_file($training_loc,$destination);
            
            $objtr->updateTrainingImage($training_id,$new_image);
            }
            
            
            $msg=base64_encode("An Training has been Updated");
            header("Location:../view/trainings.php?msg=$msg");
            
break;
// Activate Training
    case "Active":
        $training_id=$_REQUEST['training_id'];
        $objtr->activateTraining($training_id);
        header("Location:../view/trainings.php");
// Deactivate Training        
        break;
    case "Deactive":
        $training_id=$_REQUEST['training_id'];
        $objtr->deactivateTraining($training_id);
        header("Location:../view/trainings.php");
        
        break;
// View Training 
    case "View":
        
        $training_id=$_REQUEST['training_id'];
        header("Location:../view/ViewTrainings.php?training_id=$training_id");
        
break;
    
}

?>
