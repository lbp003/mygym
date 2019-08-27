<!--- header  ---->
<?php
include '../../layout/header.php'; ?>
<?php 
    $eventData = $_SESSION['eventData'];

    if(empty($eventData['image'])){
        $path = "../../../".PATH_IMAGE."user.png"; 
    }else{ 
        $path = "../../../".PATH_IMAGE.PATH_EVENT_IMAGE.$eventData['image'];                    
    } 
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Event</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">View Event</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6" style="text-align:center">
                        <img src="<?php echo $path; ?>" width="120" height="auto" class="img-responsive img-thumbnail" />
                    </div>
                    <div class="form-group col-6">
                        <label for="event_title">Event Title</label>
                        <input type="text" class="form-control" id="event_title" name="event_title" aria-describedby="event_title" value="<?php echo $eventData['event_title'];?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" aria-describedby="date" value="<?php echo $eventData['event_date'];?>" readonly>
                    </div>           
                    <div class="form-group col-6">
                        <label for="start_time">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" aria-describedby="start_time" value="<?php echo date('H:i', strtotime($eventData['start_time']));?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="end_time">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" aria-describedby="end_time" value="<?php echo date('H:i', strtotime($eventData['end_time']));?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="venue">Venue</label>
                        <input type="text" class="form-control" id="venue" name="venue" aria-describedby="venue" value="<?php echo $eventData['event_venue'];?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" readonly><?php echo $eventData['event_description'];?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>