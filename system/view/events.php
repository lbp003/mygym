<?php include '../common/header.php';?> <!----- header including ----->
<?php include '../common/navBar.php';?> <!---- navbar including ------>
<?php // include '../admin/common/dbconnection.php';?>
<?php include '../admin/model/eventModel.php';?><!---- event model including----->
<?php 
$objEve = new event();
$reEvent = $objEve->displayAllEvent();

?>
<div class="container">
        
        <?php while ($resultEvent=$reEvent->fetch_assoc()){?>
    <div class="col-md-12"><br/>
        <div class="thumbnail" id="eventSec"><br />
                        <?php 
                            if($resultEvent['event_image']==""){
                            ?>
            <img class="img-responsive center-block" src="../images/abc.jpg" width="450px" height="auto" style="display: none"/>
                        <?php     }else{
                                $path="../admin/images/event_image/".$resultEvent['event_image']; 
                            ?>
                           
            <img class="img-responsive center-block" src="<?php echo $path; ?>" width="450px" height="auto"/>
                    <?php } ?>
            <div class="eventSec">
                <h1><?php echo $resultEvent['event_title'];?></h1>
                <h3><b>Venue: <?php echo $resultEvent['event_venue'];?> | Date: <?php echo $resultEvent['event_date'];?></b></h3>              
                    <p>
                    <?php echo $resultEvent['event_description'];?>
                    </p>
            </div>            
        </div><hr />       
    </div>
    <?php } ?>
       
</div>
<?php include '../common/footer.php';?> <!---- footer including ------>
