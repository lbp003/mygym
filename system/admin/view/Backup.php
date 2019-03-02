<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php
        $connect = new PDO("mysql:host=localhost;dbname=zgym", "root", "");
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $results = $statement->execute();
        $result = $statement->fetchAll();
?>
    <script>
            function disConfirm(str){
                var r=confirm("Do You Want to "+str+"?");
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
                        <li><a href="#" class="active" >Backup</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b> Backup Database</b></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    <?php if(isset($_REQUEST['msg'])){ 
                        $msg= base64_decode($_REQUEST['msg']);
                    ?>
                    <span><?php echo $msg; ?></span>                                
                    <?php   } ?>                            
                </div>
            </div><br /><br />
            <section>
                <form method="post" id="export_form" action="../controller/backupController.php?status=Backup">
                    <div class="col-md-12">
                        <label>
                            <input type="checkbox" id="checkAll" name="checkAll" value="checkAll"/>&nbsp; Select All
                        </label>
                    </div>
                 <br />
                <?php
                foreach($result as $table){ ?>
                    <div class="col-md-4">
                       <div class="checkbox">
                        <label>
                            <input type="checkbox" class="checkbox_table" name="table[]" value="<?php echo $table["Tables_in_zgym"]; ?>" /> <?php echo $table["Tables_in_zgym"]; ?>
                        </label>
                         </div> 
                    </div>
                <?php
                }
                ?>
                <div class="col-md-12">
                  <button type="submit" name="submit" id="submit" class="btn btn-danger btn-lg" style="margin-top: 50px; float: right;"><i class="glyphicon glyphicon-floppy-save"></i>&nbsp; Export Now</button>
                </div>
                </form>
            </section>
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
//Select all checkboxes
                $("#checkAll").click(function(){
                    $('input:checkbox').not(this).prop('checked', this.checked);
                });
//client side validation for checkbox
                $('#submit').click(function(){
                  var count = 0;
                  $('.checkbox_table').each(function(){
                   if($(this).is(':checked'))
                   {
                    count = count + 1;
                   }
                  });
                  if(count > 0)
                  {
                   $('#export_form').submit();
                  }
                  else
                  {
                   alert("Please Select Atleast one table for Export");
                   return false;
                  }
                 });
            } );
        </script>
