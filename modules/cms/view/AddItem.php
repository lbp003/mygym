<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ---->
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $staff_id=$userDetails['staff_id'];
    $objca = new CommonFun();
    $reCat=$objca->viewCategory();
    //echo $userDetails['gender'].$userDetails['dob'];
    //print_r($resultm);
?>
<?php 
//    $objRo = new CommonFun();
//    $resultRo=$objRo->viewRole();
//    $_SESSION['resultRo']=$resultRo;
//    //print_r($resultRo);
//?>
<script type="text/javascript">
    $( "#edate" ).datepicker();
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
                        <li><a href="item.php" >Item </a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Add Item</b></h1>
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
                    <form method="post" name="AddEvent" action="../controller/itemController.php?status=Add" enctype="multipart/form-data">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="item_category">Item Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option selected disabled>Select a Category</option>
                                    <?php while ($rowCat=$reCat->fetch_assoc()){?>
                                    <option value="<?php echo $rowCat['category_id']?>"><?php echo $rowCat['category_name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="item_name">Item Name</label>
                                <input type="text" class="form-control" id="iname" name="item_name" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="qty" name="qty" required>
                            </div>
                             <div class="form-group">
                                <label for="Unit Price">Unit Price</label>
                                <input type="number" class="form-control" id="up" name="unit_price" required>
                            </div>
                            <div class="form-group">
                                <label for="Created User" style="display: none">Created User</label>
                                <input type="hidden" class="form-control" id="c_staff_id" name="created_user" value="<?php echo $staff_id?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Last Updated User" style="display: none">Last Updated User</label>
                                <input type="hidden" class="form-control" id="u_staff_id" name="last_updated_user" value="<?php echo $staff_id?>" required>
                            </div>
                            </div>
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-4"><br /><br />
                                <button class="btn btn-lg btn-danger btn-block" name="reset" type="reset" value="Reset">Reset</button>
                                <button class="btn btn-lg btn-info btn-block" name="submit" type="submit" value="Submit">Submit</button>
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
           $('#error_msg').text("Event Venue is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#evenue').focus();
           return false; //
           }
           if(description==""){
           $('#error_msg').text("Event Description is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#edes').focus();
           return false; //
           }
        });
    });
</script>