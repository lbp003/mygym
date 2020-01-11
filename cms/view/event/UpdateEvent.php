<!--- header  ---->
<?php
include '../../layout/header.php'; ?>
<?php 
    $eventData = $_SESSION['eventData'];
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Update Event</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="updateEvent" name="updateEvent" action="../../../controller/eventController.php?status=Update" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6" style="text-align:center">
                        <div class="kv-avatar">
                            <div class="file-loading">
                                <input id="avatar" name="avatar" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="event_title">Event Title</label>
                        <input type="text" class="form-control" id="event_title" name="event_title" aria-describedby="event_title" value="<?php echo $eventData['event_title'];?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="date">Date</label>
                        <input type="text" class="form-control" id="date" name="date" aria-describedby="date" value="<?php echo $eventData['event_date'];?>" autocomplete="off">
                    </div>           
                    <div class="form-group col-6">
                        <label for="start_time">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" aria-describedby="start_time" value="<?php echo date('H:i', strtotime($eventData['start_time']));?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="end_time">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" aria-describedby="end_time" value="<?php echo date('H:i', strtotime($eventData['end_time']));?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="venue">Venue</label>
                        <input type="text" class="form-control" id="venue" name="venue" aria-describedby="venue" value="<?php echo $eventData['event_venue'];?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $eventData['event_description'];?></textarea>
                    </div>
                    <div class="col-12">
                        <input type="hidden" id="event_id" name="event_id" value="<?php echo $eventData['event_id'];?>">   
                        <button type="submit" class="btn btn-primary mb-2 float-right">Submit</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>

<script type="text/javascript">
    $(document).ready(function(){

        //get today
        var today = new Date().toISOString().split('T')[0];

        // Form validation
        $('#updateEvent').validate({
            rules: {
                venue: "required",
                date: {
                    required: true,
                    date: true,
                    // min: today
                    },  
                // event_title: {
				// 	required: true,
				// 	event_title: true,
                //     remote: {
                //         url: '../../../controller/classSessionController.php?status=checkSessionName',
                //         type: 'post',
                //         data: {
                //             event_title: function(){
                //                 return $("#event_title").val();
                //             }
                //         }
                //     }
				// },
                description: "required"
            },
            messages: {
                venue: {
                    required: "Please enter venue"
                },
                date: {
                    required: "Please enter Date"
                },
                event_title: {
                    required: "Please enter Event Title",
                    remote: function() { return $.validator.format("{0} is already taken", $("#event_title").val()) }
                },
                description: {
                    required: "Please enter description"
                }
            }
        });

        <?php 
            if(!empty($eventData['image'])){ ?>
                var path = "<?php echo "../../../".PATH_IMAGE.PATH_EVENT_IMAGE.$eventData['image']; ?>";   
                // console.log(path);
        <?php } ?>

        // file input plugin
        $("#avatar").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="fas fa-trash-alt"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<?php if(!empty($eventData['image'])){ ?><img src="'+ path +'" width="100" height="auto" class="img-responsive img-thumbnail" /> <?php }else{ ?> <i class="fas fa-calendar-check fa-7x"></i> <?php } ?>',
            layoutTemplates: {main2: '{preview} {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif", "jpeg"],
            minFileCount : 0,
            maxFileCount: 1,
            showUpload: true,
            previewFileType: 'any',
            initialPreviewFileType: 'image',
            minImageWidth: 345,
            minImageHeight: 230,
            maxImageWidth: 800,
            maxImageHeight: 530,
            resizeImage: true
        });

        $( "#date" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
        });
    });
</script>