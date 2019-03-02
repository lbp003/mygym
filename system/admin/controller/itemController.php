<?php
include '../common/dbconnection.php';
include '../model/itemModel.php';
include '../model/loginModel.php';
include '../common/Session.php';
include '../common/CommonSql.php';

$status=$_REQUEST['status'];

$objit= new item();


switch ($status){
    
    case "Add":
        
        $item_name=$_POST['item_name'];
        $category_id=$_POST['category'];
        $qty=$_POST['qty'];
        $unit_price=$_POST['unit_price'];
        $last_updated_user=$_POST['last_updated_user'];
        $created_user = $_POST['created_user'];
          
            //add new item
         $item_id=$objit->addItem($item_name,$category_id,$qty,$unit_price,$created_user,$last_updated_user);
         
            $msg=base64_encode("An Item has been Added");
            header("Location:../view/item.php?msg=$msg");

        
        
break;

    case "Update":
        
         $item_id = $_REQUEST['item_id'];
         $item_name=$_POST['item_name'];
         $category_id=$_POST['category'];
         $qty=$_POST['qty'];
         $unit_price=$_POST['unit_price'];
         $last_updated_user=$_POST['last_updated_user'];
        
        //update staff
            
        $response = $objit->updateItem($item_name,$category_id,$qty,$unit_price,$last_updated_user,$item_id);            
        
        if(!$response){
            die("Query DEAD ".mysqli_error($con));
        }
            $msg=base64_encode("An Item has been Updated");
            header("Location:../view/item.php?msg=$msg");
            
break;
// Activate Item
    case "Activate":
        $item_id=$_REQUEST['item_id'];
        $objit->activateItem($item_id);
        header("Location:../view/item.php");
// Deactivate Item        
        break;
    case "Deactivate":
        $item_id=$_REQUEST['item_id'];
        $objit->deactivateItem($item_id);
        header("Location:../view/item.php");
        
        break;
// Delete Item
        case "Delete":
        $item_id=$_REQUEST['item_id'];
        $objit->deleteItem($item_id);
        header("Location:../view/item.php");
        
        break;
// View Item 
    case "View":
        
        $item_id=$_REQUEST['item_id'];
        header("Location:../view/ViewItem.php?item_id=$item_id");
        
break;
    
}

?>
