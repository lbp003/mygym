<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/myWorkoutModel.php'; ?><!-- including staff model ----->
<?php 
// Get All staff members details for the staff tables 
$objW= new workout();
$allAE = $objW->displayAllAnatomyExercise();

$curentAnatomyId = "";
$previousAnatomyId = "";

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
                        <li><a href="#" class="active" >Send Workout</a></li>
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
            <form action="#" method="post">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                <?php while ($allRow =$allAE->fetch_assoc()){ 
                $curentAnatomyId = $allRow['anatomy_id'];
                if( $curentAnatomyId != $previousAnatomyId){ ?>

                    <div class="panel-heading" role="tab" id="<?php $allRow['anatomy_id']?>">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $allRow['anatomy_id']?>" aria-expanded="true" aria-controls="collapseOne">
                        <?php echo $allRow['anatomy_name']?>
                      </a>
                    </h4>  
                    </div> 
                    <div id="<?php echo $allRow['anatomy_id'] ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne"> 
                  <?php } ?>  
                   
                      <div class="panel-body">
                       <div class="checkbox">
                        <label>
                            <input type="checkbox" class="js-anatomy" id="anatomy-<?php  //ex_id ?>" name="exercise[]" value="<?php echo $allRow['exercise_id']?>"><?php echo $allRow['exercise_name']?>
                        </label>
                      </div>
                    </div>
                    
                        <label class="hide ja-chlid-<?php  //ex_id ?>">Label 1</label>
                        
                <?php  
                 if( $curentAnatomyId != $previousAnatomyId){ ?>
                    </div>
                <?php  } ?>        
                
             
                  
                <?php 
                
                 $previousAnatomyId = $allRow['anatomy_id'];
                 } ?>
                        </div>
                </div>
            </form>           
              </div>
        </div>
    </div>
</div>
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>
        <!-- <script type="text/javascript">
            $(document).ready(function() {
             $('.js-anatomy').on('click',function(){
                var isChecked = $(this).isChecked();
                 
                var id = $(this).attr('id');
                var ar1 =id.slice('-');
                
                if(isChecked){
                    $('.js-ex-'+ ar1[3]).removeClass('hide');
                }else{
                    $('.js-ex-'+ ar1[3]).addClass('hide');
                }
                
             });   
                
            $("#msg").delay(5000).fadeOut("slow");
            //$('#mytable').DataTable();
                });
        </script> -->
        <!-- <script type="text/javascript">
            $(document).ready(function() {
                $('#mytable').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                } );
            } );
        </script> -->