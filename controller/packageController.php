<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/package.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role();

$status=$_REQUEST['status'];

$objpack= new Package();

switch ($status){

/**
 * Redirect to Add a Package
*/

    case "Add":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/package/addPackage.php");

break;

/**
 * Insert a new gym class
 */

    case "Insert":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

        $packageName=$_POST['package_name'];

        if (empty($packageName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/addPackage.php?msg=$msg");
            exit;
        }

        $fee=$_POST['fee'];

        if (empty($fee)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package fee can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/addPackage.php?msg=$msg");
            exit;
        }

        if (!is_numeric($fee)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Fee should be a numeric value','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/addPackage.php?msg=$msg");
            exit;
        }

        $duration=$_POST['duration'];

        if (empty($duration)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Duration can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/addPackage.php?msg=$msg");
            exit;
        }

        if (!is_numeric($duration) || $duration > 12) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Duration must be numeric and less or equal to 12','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/addPackage.php?msg=$msg");
            exit;
        }

        $description=$_POST['description'];

        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/addPackage.php?msg=$msg");
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

        $status = Package::ACTIVE;

        if(Package::checkPackageName($packageName)){
            //add new Package
            $packageID=$objpack->addPackage($packageName, $fee, $duration, $description, $status);

            if($packageID){
                if(!empty($tmp['name'])){
                    if (!file_exists('../'.PATH_IMAGE.PATH_PACKAGE_IMAGE)) {

                        mkdir('../'.PATH_IMAGE.PATH_PACKAGE_IMAGE, 0777, true);
                    }

                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $imgName = "IMG_".$packageID.".".$ext;

                    // Add package image
                    if(Package::addPackageImage($packageID, $imgName)){

                        rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_PACKAGE_IMAGE.$imgName);

                        $msg = json_encode(array('title'=>'Success','message'=>'Package registration successful','type'=>'success'));
                        $msg = base64_encode($msg);
                        header("Location:../cms/view/package/index.php?msg=$msg");
                        exit;

                    }else{
                        $msg = json_encode(array('title'=>'Warning','message'=> 'Failed to add the package image','type'=>'warning'));
                        $msg = base64_encode($msg);
                        header("Location:../cms/view/package/index.php?msg=$msg");
                        exit;
                    }
                }else{
                    $msg = json_encode(array('title'=>'Success','message'=>'Package registration successful','type'=>'success'));
                    $msg = base64_encode($msg);
                    header("Location:../cms/view/package/index.php?msg=$msg");
                    exit;
                }
            }else{
                $msg = json_encode(array('title'=>'Danger','message'=> 'Failed to add the Package','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/package/addPackage.php?msg=$msg");
                exit;
            }
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/addPackage.php?msg=$msg");
            exit;
        }

break;

/**
 *  Get the Package details for Update class
 **/

    case "Edit":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

        $packageID = $_REQUEST['package_id'];

        if(!empty($packageID)){
            //get class details
            $dataSet = Package::getPackageByID($packageID);
            $packData = $dataSet->fetch_assoc();
            // var_dump($classData); exit;

            $_SESSION['packData'] = $packData;

            header("Location:../cms/view/package/updatePackage.php");
            exit;
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Update Package details
 * **/

    case "Update":

         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

        $packageID=$_POST['package_id'];

        $packageName=$_POST['package_name'];

        if (empty($packageName)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package Name can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/updatePackage.php?msg=$msg");
            exit;
        }

        $fee=$_POST['fee'];

        if (empty($fee)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package fee can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/updatePackage.php?msg=$msg");
            exit;
        }

        if (!is_numeric($fee)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Fee should be a numeric value','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/updatePackage.php?msg=$msg");
            exit;
        }

        $duration=$_POST['duration'];

        if (empty($duration)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Duration can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/updatePackage.php?msg=$msg");
            exit;
        }

        if (!is_numeric($duration) || $duration > 12) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Duration must be numeric and less or equal to 12','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/updatePackage.php?msg=$msg");
            exit;
        }

        $description=$_POST['description'];

        if (empty($description)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Description can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/updatePackage.php?msg=$msg");
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
            $imgName = "IMG_".$packageID.".".$ext;      
        }

        if(!empty($tmp['name'])){
            if (!file_exists('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY)) {

                mkdir('../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY, 0777, true);
            }
    
            move_uploaded_file($file_loc,'../'.PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file);
        }

        if(Package::checkUpdatePackageName($packageName, $packageID)){

            // upload the image to a temp folder

            if(!empty($imgName)){
                if (!file_exists('../'.PATH_IMAGE.PATH_PACKAGE_IMAGE)) {
    
                    mkdir('../'.PATH_IMAGE.PATH_PACKAGE_IMAGE, 0777, true);
                }

                rename("../".PATH_PUBLIC.SYSTEM_TEMP_DIRECTORY.$file, "../".PATH_IMAGE.PATH_PACKAGE_IMAGE.$imgName);
            }

            // var_dump($imgName); exit;
            $dataAr = [
                'name' => $packageName,
                'fee' => $fee,
                'description' => $description,
                'duration' => $duration,
                'img' => (!empty($imgName)) ? $imgName : NULL,
                'id' => $packageID
            ];
             //update class
            $result=Package::updatePackage($dataAr);
            if($result == true){
                $msg = json_encode(array('title'=>'Success :','message'=> 'Package has been updated','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/package/index.php?msg=$msg");
                exit;
            }else {
                $msg = json_encode(array('title'=>'Warning :','message'=> 'Update failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/package/updatePackage.php?msg=$msg");
                exit;
            }
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package name already exists','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/updatePackage.php?msg=$msg");
            exit;
        }

break;

/**
 * View Package
 */
    case "View":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::VIEW_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

        $packageID = $_REQUEST['package_id'];

        if(!empty($packageID)){

            //get package details
            $dataSet = Package::getPackageByID($packageID);
            $packData = $dataSet->fetch_assoc();

            $_SESSION['packData'] = $packData;

            header("Location:../cms/view/package/viewPackage.php");
            exit;
        }else {
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Activate package
 * */

    case "Activate":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

        $packageID=$_REQUEST['package_id'];

        $response = Package::activatePackage($packageID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Package has been activated','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Dectivate package
 */

    case "Deactivate":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

        $packageID=$_REQUEST['package_id'];

        $response = Package::deactivatePackage($packageID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Package has been deactivated','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Delete package
 */

    case "Delete":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }


        if(!$auth->checkPermissions(array(Role::MANAGE_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

        $packageID=$_REQUEST['package_id'];

        $response = Package::deletePackage($packageID);
        if($response == true){
            $msg = json_encode(array('title'=>'Success :','message'=> 'Class has been deleted','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning :','message'=> 'Error','type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/package/index.php?msg=$msg");
            exit;
        }

break;

/**
 * Index actiton
 */

    case "index":

        if(!$user)
        {
            $msg = SESSION_TIMED_OUT;
            $msg = base64_encode($msg);
            header("Location:../cms/view/index/index.php?msg=$msg");
            exit;
        }

        if(!$auth->checkPermissions(array(Role::MANAGE_PACKAGE, Role::VIEW_PACKAGE)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/package/");

break;
}

?>
