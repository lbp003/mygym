<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../../model/event.php'; ?>
<?php 
$allEvent = Event::displayAllEvent();
// $row = $allevent->fetch_assoc();
// print_r($allEvent); exit;
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Event</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allEvent){
                        die("Query DEAD ".mysqli_error($con));
                    }
         
                    while($row = $allEvent->fetch_assoc()) {
                        
                        if($row['status']==Event::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Event::INACTIVE){
                            $status="Inactive";
                        }
                        
                ?>
                <tr>
                    <td><?php if (!empty($row['image'])){echo "<img src='../../../public/image/event_image/{$row['image']}' width='70' height='auto' class='img-responsive img-thumbnail' />";}else{echo "<i class='far fa-3x fa-calendar-check'></i>";}?></td>
                    <td><?php echo ucwords($row['event_title']); ?></td>
                    <td><?php echo $row['event_date']; ?></td>
                    <td><?php echo $row['event_venue']; ?></td>
                    <td><span class="badge <?php if($row['status']==Event::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                        <a data-toggle="tooltip" data-placement="top" title="View" href="../../../controller/eventController.php?event_id=<?php echo $row['event_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                        <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../../controller/eventController.php?event_id=<?php echo $row['event_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                    <?php 
                        $eventID = $row['event_id']; 

                        if($row['status']==Event::ACTIVE){ ?>
                            <a class="deactivate" data-toggle="tooltip" data-placement="top" title="Deactivate" href="../../../controller/eventController.php?event_id=<?php echo $eventID;?>&status=Deactivate"><i class="fas fa-ban text-warning"></i></a>
                    <?php        
                        }elseif($row['status']==Event::INACTIVE){ ?>
                            <a class="activate" data-toggle="tooltip" data-placement="top" title="Activate" href="../../../controller/eventController.php?event_id=<?php echo $eventID;?>&status=Activate"><i class="far fa-check-circle text-success"></i></a>
                    <?php } ?>
                        <a class="delete" data-toggle="tooltip" data-placement="top" title="Delete" href="../../../controller/eventController.php?event_id=<?php echo $eventID;?>&status=Delete"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php include '../../layout/footer.php';?>
<script type="text/javascript">
    $(document).ready(function() {
      var table = $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                text: '+ ADD EVENT',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "../../../controller/eventController.php?status=Add";
                }
            },
            ],
            select: false
        } );
    } );
</script>