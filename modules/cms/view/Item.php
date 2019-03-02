<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/itemModel.php'; ?><!-- including staff model ----->
<?php 
// Get All item details for the item tables 
$objitem= new item();
$AllItem = $objitem->displayAllItem();

?>
    <script>
            function disConfirm(str){
                var r=confirm("Do You Want to "+str+"?");
                if(!r){
                    return false;
                    
                }
                
            }      
            function deleteRow(){
                var r=confirm("Do you want to DELETE the message ?");
                if(!r){
                    return false;
                    
                }   
            }
    </script>
<!----header end -----> 
<body onload="startTime()">
        <!---navbar starting ---------->
        <?php include '../common/navBar.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="Dashboard.php" >Dashboard</a></li>
                        <li><a href="#" class="active" >Item</a></li>
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
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    <div>
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b> Item List</b></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p align="left" style="font-family: monospace; padding-top: 20px">
                        <a href="addItem.php"><button class="btn btn-danger btn-lg" style="padding-bottom: 12px; "><i class="glyphicon glyphicon-user glyphicon-plus"></i>&nbsp; ADD Item</button></a>
                    </p>    
                </div>
                <div class="col-md-9">&nbsp;
<!--                    <form class="form-inline" style="float: right; padding-top: 20px">
                        <div class="form-group">
                        <label class="sr-only">search</label>
                        <input class="form-control" size="35" type="search" name="search">
                        </div>
                        <button class="btn btn-default" type="submit" name="submit">Search</button>
                    </form>-->
                </div>
            </div><hr />
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    <?php if(isset($_REQUEST['msg'])){ 
                        $msg= base64_decode($_REQUEST['msg']);
                    ?>
            <span class="alert alert-success"><?php echo $msg; ?></span>
                                
                    <?php   } ?>
                            
                </div>
            </div><br />
            <div class="row">
                <table id="mytable" class="table table-striped table-dark table-responsive" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">QTY</th>
                        <th scope="col">Price</th>
                        <th scope="col">Last Modified Time</th>                       
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!$AllItem){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        while($itemrow = $AllItem->fetch_assoc()) {
                            
                            $status = $itemrow['item_status'];
                            
                            if($itemrow['item_status']=="Activate"){
                                $status="Deactivate";
                            }else{
                                $status="Activate";
                            }
                            
                          ?>
                      <tr 
                          <?php if($itemrow['item_status'] == "Deleted"){?>
                          style="display: none"
                          <?php }?>>
                        <td><?php echo $itemrow['item_id'];?></td>
                        <td><?php echo ucfirst($itemrow['item_name']);?></td>
                        <td><?php echo ucfirst($itemrow['category_name']);?></td>
                        <td><?php echo ucfirst($itemrow['qty']);?></td>
                        <td><?php echo $itemrow['unit_price'];?></td>
                        <td><?php echo $itemrow['last_updated_time'];?></td>
                        <td>
                            <a href="../controller/itemcontroller.php?item_id=<?php echo $itemrow['item_id']?>&status=View" class="btn" style="background-color: #66cc00"><span class="glyphicon glyphicon-list"></span></a>
                            <a href="../view/updateItem.php?item_id=<?php echo $itemrow['item_id']?>&status=Update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="../controller/itemController.php?item_id=<?php echo $itemrow['item_id']?>&status=Delete" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                            <a href="../controller/itemcontroller.php?item_id=<?php echo $itemrow['item_id']?>&status=<?php echo $status; ?>" class="btn btn-danger" onclick="return disConfirm('<?php echo $status; ?>')"><?php echo $status ?></a>                   
                        </td>
                      </tr>
                     <?php  } ?>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#mytable').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                } );
            } );
        </script>
