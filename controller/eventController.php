<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/event.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role();

$status=$_REQUEST['status'];

$objeve= new Event();

switch ($status){

/**
 * Redirect to Add a Event
*/

    case "Add":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_EVENT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/event/index.php?msg=$msg");
        exit;
    }

    header("Location:../cms/view/event/addEvent.php");

break;

/**
 * Insert a new gym class
 */

    case "Insert":

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_EVENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/index.php?msg=$msg");
            exit;
        }

        $eventTitle=$_POST['event_title'];

        if (empty($eventTitle)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Event Title can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/addEvent.php?msg=$msg");
            exit;
        }

        $date=$_POST['date'];

        if (empty($date)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/addEvent.php?msg=$msg");
            exit;
        }

        $today = date("Y-m-d");

        if ($date < $today) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date can not be a past date','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/addEvent.php?msg=$msg");
            exit;
        }

        $venue=$_POST['venue'];
        if (empty($venue)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Venue can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/addEvent.php?msg=$msg");
            exit;
        }

        $startTime=$_POST['start_time'];
        // check time format 24h
        if(!empty($startTime)){
            if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $startTime)) {
                $msg = json_encode(array('title'=>'Warning','message'=> 'Start time incorrect format','type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/event/addEvent.php?msg=$msg");
                exit;
            }
        }

        $endTime=$_POST['end_time'];
        // check time format 24h
        if(!empty($endTime)){
            if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $endTime)) {
                $msg = json_encode(array('title'=>'Warning','message'=> 'End time incorrect format','type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/event/addEvent.php?msg=$msg");
                exit;
            }
        }

        if(!empty($startTime) && !empty($endTime)){
            if($startTime > $endTime){
                $msg = json_encode(array('title'=>'Warning','message'=> 'Wrong start time and end time','type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/event/addEvent.php?msg=$msg");
                exit;
            }
        }

        $description=$_POST['description'];

        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/addEvent.php?msg=$msg");
            exit;
        }

        $tmp = $_FILES['avatar'];
        if(!empty($tmp['name'])){
            // print_r($tmp); exit;
            $file = $tmp['name'];
            $file_loc = $tmp['tmp_name'];
            $file_size = $tmp['size'];
            $file_type = $tmp['type'];
        }

        if(!empty($tmp['name'])){
            if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {

                mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
            }

            move_uploaded_file($file_loc,'../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file);
        }

        $status = Event::ACTIVE;

        if(Event::checkEventName($eventTitle)){
            //add new Event
            $eventID=$objeve->addEvent($eventTitle, $date, $venue, $startTime, $endTime, $description, $status);

            if($eventID){
                if(!empty($tmp['name'])){
                    if (!file_exists('../'.PATH_IMAGE.PATH_EVENT_IMAGE)) {

                        mkdir('../'.PATH_IMAGE.PATH_EVENT_IMAGE, 0777, true);
                    }

                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $imgName = "IMG_".$eventID.".".$ext;

                    // Add class image
                    if(Event::addEventImage($eventID, $imgName)){

                        rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_EVENT_IMAGE.$imgName);

                        $msg = json_encode(array('title'=>'Success','message'=>'Event registration successful','type'=>'success'));
                        $msg = base64_encode($msg);
                        header("Location:../cms/view/event/index.php?msg=$msg");
                        exit;

                    }else{
                        $msg = json_encode(array('title'=>'Warning','message'=> 'Failed to add the event image','type'=>'warning'));
                        $msg = base64_encode($msg);
                        header("Location:../cms/view/event/index.php?msg=$msg");
                        exit;
                    }
                }else{
                    $msg = json_encode(array('title'=>'Success','message'=>'Event registration successful','type'=>'success'));
                    $msg = base64_encode($msg);
                    header("Location:../cms/view/event/index.php?msg=$msg");
                    exit;
                }
            }else{
                $msg = json_encode(array('title'=>'Danger','message'=> 'Failed to add the Event','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/event/addEvent.php?msg=$msg");
                exit;
            }
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Event name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/addEvent.php?msg=$msg");
            exit;
        }

break;

/**
 *  Get the Event details for Update class
 **/

    case "Edit":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_EVENT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/event/index.php?msg=$msg");
        exit;
    }

    $eventID = $_REQUEST['event_id'];

    if(!empty($eventID)){
        //get class details
        $dataSet = Event::getEventByID($eventID);
        $eventData = $dataSet->fetch_assoc();
        // var_dump($classData); exit;

        $_SESSION['eventData'] = $eventData;

        header("Location:../cms/view/event/updateEvent.php");
        exit;
    }else {
        $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/event/index.php?msg=$msg");
        exit;
    }

break;

/**
 * Update Event details
 * **/

    case "Update":

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_EVENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/index.php?msg=$msg");
            exit;
        }

        $eventID=$_POST['event_id'];

        $eventTitle=$_POST['event_title'];

        if (empty($eventTitle)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Event Title can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/updateEvent.php?msg=$msg");
            exit;
        }

        $date=$_POST['date'];

        if (empty($date)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/updateEvent.php?msg=$msg");
            exit;
        }

        $today = date("Y-m-d");

        if ($date < $today) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Date can not be a past date','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/updateEvent.php?msg=$msg");
            exit;
        }

        $venue=$_POST['venue'];
        if (empty($venue)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Venue can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/updateEvent.php?msg=$msg");
            exit;
        }

        $startTime=$_POST['start_time'];

        // check time format 24h
        if(!empty($startTime)){
            if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $startTime)) {
                $msg = json_encode(array('title'=>'Warning','message'=> 'Start time incorrect format','type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/event/updateEvent.php?msg=$msg");
                exit;
            }
        }

        $endTime=$_POST['end_time'];
        // check time format 24h
        if(!empty($endTime)){
            if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $endTime)) {
                $msg = json_encode(array('title'=>'Warning','message'=> 'End time incorrect format','type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/event/updateEvent.php?msg=$msg");
                exit;
            }
        }

        if(!empty($startTime) && !empty($endTime)){
            if($startTime > $endTime){
                $msg = json_encode(array('title'=>'Warning','message'=> 'Wrong start time and end time','type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/event/updateEvent.php?msg=$msg");
                exit;
            }
        }

        $description=$_POST['description'];

        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/updateEvent.php?msg=$msg");
            exit;
        }

        $tmp = $_FILES['avatar'];
        if(!empty($tmp['name'])){
            // print_r($tmp); exit;
            $file = $tmp['name'];
            $file_loc = $tmp['tmp_name'];
            $file_size = $tmp['size'];
            $file_type = $tmp['type'];

            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $imgName = "IMG_".$eventID.".".$ext;      
        }

        if(!empty($tmp['name'])){
            if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {

                mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
            }
    
            move_uploaded_file($file_loc,'../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file);
        }

        if(Event::checkUpdateEventName($eventTitle, $eventID)){

            // upload the image to a temp folder

            if(!empty($imgName)){
                if (!file_exists('../'.PATH_IMAGE.PATH_EVENT_IMAGE)) {
    
                    mkdir('../'.PATH_IMAGE.PATH_EVENT_IMAGE, 0777, true);
                }

                rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_EVENT_IMAGE.$imgName);
            }

            // var_dump($imgName); exit;
            $dataAr = [
                'name' => $eventTitle,
                'date' => $date,
                'description' => $description,
                'venue' => $venue,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'img' => (!empty($imgName)) ? $imgName : NULL,
                'id' => $eventID
            ];
             //update class
            $result=Event::updateEvent($dataAr);
            if($result == true){
                $msg = json_encode(array('title'=>'Success :','message'=> 'Event has been updated','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/event/index.php?msg=$msg");
                exit;
            }else {
                $msg = json_encode(array('title'=>'Warning :','message'=> 'Update failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/event/updateEvent.php?msg=$msg");
                exit;
            }


        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Event name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/updateEvent.php?msg=$msg");
            exit;
        }

break;

/**
 * View Event
 */
    case "View":

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::VIEW_EVENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/index.php?msg=$msg");
            exit;
        }

        $eventID = $_REQUEST['event_id'];

        if(!empty($eventID)){

            //get class details
            $dataSet = Event::getEventByID($eventID);
            $eventData = $dataSet->fetch_assoc();
            // var_dump($classData); exit;

            $_SESSION['eventData'] = $eventData;

            header("Location:../cms/view/event/viewEvent.php");
            exit;
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Activate event
 * */

    case "Activate":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_EVENT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/event/index.php?msg=$msg");
        exit;
    }

    $eventID=$_REQUEST['event_id'];

    $response = Event::activateEvent($eventID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Event has been activated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/event/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/event/index.php?msg=$msg");
        exit;
    }

break;

/**
 * Dectivate event
 */

    case "Deactivate":

    if(!$user)
    {
        $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }

    if(!$auth->checkPermissions(array(Role::MANAGE_EVENT)))
    {
        $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/event/index.php?msg=$msg");
        exit;
    }

    $eventID=$_REQUEST['event_id'];

    $response = Event::deactivateEvent($eventID);
    if($response == true){
        $msg = json_encode(array('title'=>'Success :','message'=> 'Event has been deactivated','type'=>'success'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/event/index.php?msg=$msg");
        exit;
    }else{
        $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
        $msg = base64_encode($msg);
        header("Location:../cms/view/event/index.php?msg=$msg");
        exit;
    }

break;

/**
 * Delete event
 */

    case "Delete":

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_EVENT)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/index.php?msg=$msg");
            exit;
        }

        $eventID=$_REQUEST['event_id'];

        $response = Event::deleteEvent($eventID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been deleted','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/event/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Index actiton
 */

        default:

            if(!$user)
            {
                $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/index/index.php?msg=$msg");
                exit;
            }

            if(!$auth->checkPermissions(array(Role::MANAGE_EVENT, Role::VIEW_EVENT)))
            {
                $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
                exit;
            }

            header("Location:../cms/view/event/");
}

?>
