<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/itemModel.php';?>
<!--- header end ---->
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $staff_id=$userDetails['staff_id'];
    
    $objca = new CommonFun();
    $reCat=$objca->viewCategory();
    //Request Item Id
    $item_id = $_REQUEST['item_id'];
    
    $objit = new item();
    $resultx = $objit->displayItem($item_id);
    if(!$resultx){
         die("Query DEAD ".mysqli_error($con));
    }
    $resultUp = $resultx->fetch_assoc(); 
?>
<script type="text/javascript">
    $( "#idate" ).datepicker();
</script>
<body onload="startTime()">
        <!---navbar starting ---------->
        <?php include '../common/navBar.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="Dashboard.php" >Dashboard</a></li>
                        <li><a href="item.php" >Item</a></li>
                        <li><a href="#" class="active">Add Item</a></li>
                    </ol>
                </div>
        </div>
        <!--- breadcrumb ending--------->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                <!----Admin side nav starting------>
            <?php include '../common/AdminSideNav.php'; ?>
                <!----Admin side nav ending------>
                </div>
                <div class="col-md-9" style="background-color:rgb(250,250,250); ">
                    <div>
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>View Item</b></h1>
                    </div><hr />
                    <div class="row">
                        <div class="col-md-12" id="msg" style="text-align: center">
                            <?php if(isset($_REQUEST['msg'])){ 
                                $msg= base64_decode($_REQUEST['msg']);
                            ?>
                            <span class="alert alert-danger"><?php echo $msg; ?></span>
                                
                            <?php   } ?>
                            
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div id="error_msg" style="text-align: center" >&nbsp;</div>
                            <div>&nbsp;</div>
                        </div>
                        </div>
                    </div><br />
                    <form method="post" name="ViewItem" action="../controller/itemController.php?status=View&item_id=<?php $item_id?>" enctype="multipart/form-data">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_category">Item Category</label>
                                <select name="category" id="category" class="form-control" disabled>
                                    <?php while ($rowCat=$reCat->fetch_assoc()){
                                        if($resultUp['category_id'] == $rowCat['category_id']){?>
                                    <option value="<?php echo $rowCat['category_id']?>" selected><?php echo $rowCat['category_name']?></option>
                                        <?php }else { ?>
                                    <option value="<?php echo $rowCat['category_id']?>"><?php echo $rowCat['category_name']?></option>
                                        <?php }} ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="item_name">Item Name</label>
                                <input type="text" class="form-control" id="iname" name="item_name" value="<?php echo $resultUp['item_name']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="qty" name="qty" value="<?php echo $resultUp['qty']?>" readonly>
                            </div>
                             <div class="form-group">
                                <label for="Unit Price">Unit Price</label>
                                <input type="number" class="form-control" id="up" name="unit_price" value="<?php echo $resultUp['unit_price']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Last Updated User" style="display: none">Last Updated User</label>
                                <input type="hidden" class="form-control" id="u_staff_id" name="last_updated_user" value="<?php echo $staff_id?>" readonly>
                            </div>
                            </div>
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-4"><br /><br />
                                <a class="btn btn-lg btn-info btn-block" href="Item.php" name="submit" type="submit" value="Submit">Submit</a>
                            </div>
                            <div class="col-md-4">&nbsp;</div>
                        </div>
                        </div>                       
                    </form>
                </div>
        </div>
        </div><br />
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>
<script type="text/javascript">   
    $(document).ready(function(){
        $('form').submit(function(){
            
           var category = $('#category').val();
           var iname = $('#iname').val();
            
           if(category==""){
           $('#error_msg').text("category is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#category').focus();
           return false;
           }
           if(iname==""){
           $('#error_msg').text("Item name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#iname').focus();
           return false; //
           }
           if(venue==""){
           $('#error_msg').text("Item Venue is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#evenue').focus();
           return false; //
           }
           if(description==""){
           $('#error_msg').text("Item Description is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#edes').focus();
           return false; //
           }
        });
    });
</script>