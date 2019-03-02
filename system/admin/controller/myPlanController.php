<?php
include '../common/dbconnection.php';
include '../model/myPlanModel.php';
include '../model/loginModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

$status=$_REQUEST['status'];

$objmp= new myPlan();


switch ($status){
    
    case "BMI":
        
        $height=$_POST['height'];
        $weight=$_POST['weight'];
        $member_id=$_REQUEST['member_id'];
        $bmi=($weight/($height*$height));
        $bmi_value=round($bmi, 1); 
        
        if ($bmi_value <= 18.5) {
              $status="Underweight";
          } elseif ($bmi_value >= 18.5 && $bmi_value <= 24.9) {
              $status="Healthy";
          } elseif ($bmi_value >= 25.0 && $bmi_value <= 29.9) {
              $status="Overweight";
          } else {
              $status="Obese";
          }   
            //add new bmi
         $bmi_id=$objmp->addBMI($height,$weight,$bmi_value,$member_id,$status);
break;

    case "Bodyfat":
        
        $dob=$_REQUEST['dob'];
        $gender=$_REQUEST['gender'];
        $member_id=$_REQUEST['member_id'];
        
        $axilla=$_POST['Axilla'];
        $chest=$_POST['Chest'];
        $abdominal=$_POST['Abdominal'];
        $subscapular=$_POST['Subscapular'];
        $suprailiac=$_POST['Suprailiac'];
        $tricep=$_POST['Tricep'];
        $thigh=$_POST['Thigh'];
        
        $age = date_diff(date_create($dob), date_create('now'))->y;
        $sof =($axilla+$chest+$abdominal+$subscapular+$suprailiac+$tricep+$thigh);
        
        //Bodyfat calculator
        if($gender=="Male"){
            
            $bodyfat=495/(1.112-(0.00043499*$sof)+(0.00000055*$sof*$sof)-(0.00028826*$age))-450;
            $bfp=round($bodyfat);
            
                if($bfp < 12){
                    $status="Lean";
                    $data_id=$objmp->addData($member_id,$axilla,$chest,$abdominal,$subscapular,$suprailiac,$tricep,$thigh,$bfp,$status);                  
                    $stat=base64_encode($status);
                    header("Location:../../view/mydata.php?stat=$stat");
                } elseif ($bfp >= 12 && $bfp < 21) {
                    $status="Acceptable";
                    $data_id=$objmp->addData($member_id,$axilla,$chest,$abdominal,$subscapular,$suprailiac,$tricep,$thigh,$bfp,$status);                  
                    $stat=base64_encode($status);
                    header("Location:../../view/mydata.php?stat=$stat");
                }elseif ($bfp >= 21 && $bfp < 26) {
                    $status="Moderately Overweight";
                    $data_id=$objmp->addData($member_id,$axilla,$chest,$abdominal,$subscapular,$suprailiac,$tricep,$thigh,$bfp,$status);                  
                    $stat=base64_encode($status);
                    header("Location:../../view/mydata.php?stat=$stat");
                } else {
                    $status="Overweight";
                    $data_id=$objmp->addData($member_id,$axilla,$chest,$abdominal,$subscapular,$suprailiac,$tricep,$thigh,$bfp,$status);                  
                    $stat=base64_encode($status);
                    header("Location:../../view/mydata.php?stat=$stat");
                }       
        } else {
            
            $bodyfat=495/(1.097-(0.00046971*$sof)+(0.00000056*$sof*$sof)-(0.00012828*$age))-450;
            $bfp= round($bodyfat);
            
            if($bfp < 17){
                    $status="Lean";
                    $data_id=$objmp->addData($member_id,$axilla,$chest,$abdominal,$subscapular,$suprailiac,$tricep,$thigh,$bfp,$status);                  
                    $stat=base64_encode($status);
                    header("Location:../../view/mydata.php?stat=$stat");
                } elseif ($bfp >= 17 && $bfp < 28) {
                    $status="Acceptable";
                    $data_id=$objmp->addData($member_id,$axilla,$chest,$abdominal,$subscapular,$suprailiac,$tricep,$thigh,$bfp,$status);                  
                    $stat=base64_encode($status);
                    header("Location:../../view/mydata.php?stat=$stat");
                }elseif ($bfp >= 28 && $bfp < 33) {
                    $status="Moderately Overweight";
                    $data_id=$objmp->addData($member_id,$axilla,$chest,$abdominal,$subscapular,$suprailiac,$tricep,$thigh,$bfp,$status);                  
                    $stat=base64_encode($status);
                    header("Location:../../view/mydata.php?stat=$stat");
                } else {
                    $status="Overweight";
                    $data_id=$objmp->addData($member_id,$axilla,$chest,$abdominal,$subscapular,$suprailiac,$tricep,$thigh,$bfp,$status);                  
                    $stat=base64_encode($status);
                    header("Location:../../view/mydata.php?stat=$stat");
                }   
        }
        
        
        
        //update staff
            
        //$objev->updateEvent($event_title,$event_date,$event_venue,$event_description,$event_id);
            
        
            
            //$msg=base64_encode("An Event has been Updated");
            //header("Location:../view/event.php?msg=$msg");
            
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
