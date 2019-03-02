<?php

class item{
    
    function displayAllItem(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM item i, category c WHERE i.category_id = c.category_id ORDER BY item_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    function addItem($item_name,$item_category,$qty,$unit_price,$created_user,$last_updated_user){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO item VALUES('','$item_name','$item_category','$qty','$unit_price',NOW(),NOW(),'$created_user','$last_updated_user','Activate')";
        $result=$con->query($sql);
        $item_id=$con->insert_id;
        return $item_id;           
    }  
    function updateItem($item_name,$category_id,$qty,$unit_price,$last_updated_user,$item_id){
        $con = $GLOBALS['con'];
        $sql="UPDATE item SET item_name='$item_name',category_id='$category_id',qty='$qty',unit_price='$unit_price',last_updated_time=NOW(),last_updated_user='$last_updated_user' WHERE item_id='$item_id'";
        $result=$con->query($sql);
    }
    
    function activateItem($item_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE item SET item_status='Activate' WHERE item_id='$item_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deactivateItem($item_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE item  SET item_status='Deactivate' WHERE item_id='$item_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function deleteItem($item_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE item SET item_status='Deleted' WHERE item_id='$item_id'";
        $result=$con->query($sql);
        return $result;
    }
    function displayItem($item_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM item i,category c WHERE i.category_id = c.category_id AND item_id='$item_id'";
        $result=$con->query($sql);
        return $result;
    }
   
}