<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/memberModel.php'; ?><!-- including member model ----->
<?php 
// Get All  members details for the member tables 
$obMember= new member();
$AllMember = $obMember->displayAllMember();

?>
    <script>
            function disConfirm(str){
                var r=confirm("Do You Want to "+str+"?");
                if(!r){
                    return false;
                    
                }
                
            }
    </script>
    <script type="text/javascript">
        $(function () {
        $('[data-toggle="tooltip"]').tooltip()
            })
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
                        <li><a href="#" class="active" >Member</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b> Member List</b></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p align="left" style="font-family: monospace; padding-top: 20px">
                        <a href="addMember.php"><button class="btn btn-danger btn-lg" style="padding-bottom: 12px; "><i class="glyphicon glyphicon-user glyphicon-plus"></i>&nbsp; ADD MEMBER</button></a>
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
            </div>
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
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telephone</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!$AllMember){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $count=0;
                        while($memberrow = $AllMember->fetch_assoc()) {
                            $count++;
                            
                            
                            if($memberrow['member_image']==""){
                                $path="../images/user.png";
                            } else {
                                $path="../images/member_image/".$memberrow['member_image'];
                           
                            }
                            
                            if($memberrow['member_status']=="Active"){
                                $status="Deactive";
                            }else{
                                $status="Active";
                            }
                        ?>
                      <tr <?php  if(isset($_REQUEST['msg']) && $count==1){ ?>
                           class="success" 
                            <?php  } ?>>
                        <td>
                              <img src="<?php echo $path; ?>" width="70" height="auto" class="img-responsive img-thumbnail" />
                        </td>
                        <td><?php echo ucfirst($memberrow['member_fname']);?></td>
                        <td><?php echo ucfirst($memberrow['member_lname']);?></td>
                        <td><?php echo $memberrow['member_email'];?></td>
                        <td><?php echo ucfirst($memberrow['member_tel']);?></td>
                        <td>
                            <a href="../controller/membercontroller.php?member_id=<?php echo $memberrow['member_id']?>&status=View" class="btn" style="background-color: #66cc00" data-toggle="tooltip" data-placement="top" title="View"><span class="glyphicon glyphicon-list"></span></a>
                            <a href="../view/updateMember.php?member_id=<?php echo $memberrow['member_id']?>&status=Update" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="../controller/membercontroller.php?member_id=<?php echo $memberrow['member_id']?>&status=<?php echo $status; ?>" class="btn btn-danger" onclick="return disConfirm('<?php echo $status; ?>')">
                                <?php echo $status ?>
                            </a>
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