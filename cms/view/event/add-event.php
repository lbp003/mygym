<?php
include '../../layout/header.php'; ?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Event</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Add Event</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="addEvent" name="addEvent" action="../../../controller/eventController.php?status=Insert" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" id="event_title" name="event_title" aria-describedby="event_title" placeholder="Event Title" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="date">Date</label>
                        <input type="text" class="form-control" id="date" name="date" aria-describedby="date" autocomplete="off">
                    </div>           
                    <div class="form-group col-6">
                        <label for="start_time">Start Time (in 24H)</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" aria-describedby="start_time">
                    </div>
                    <div class="form-group col-6">
                        <label for="end_time">End Time (in 24H)</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" aria-describedby="end_time">
                    </div>
                    <div class="form-group col-6">
                        <label for="venue">Venue</label>
                        <input type="text" class="form-control" id="venue" name="venue" aria-describedby="venue" placeholder="Venue">
                    </div>
                    <div class="form-group col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="col-12">
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
        $('#addEvent').validate({
            rules: {
                venue: "required",
                date: {
                    required: true,
                    date: true,
                    min: today
                    }, 
                event_title: {
					required: true,
                    remote: "../../../controller/eventController.php?status=checkEventName"
				},
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
                    remote: "Event title is already exists"
                },
                description: {
                    required: "Please enter description"
                }
            }
        });

        // file input plugin
        $("#avatar").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showPreview: true,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="fas fa-trash-alt"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<i class="far fa-image fa-5x"></i>',
            layoutTemplates: {main2: '{preview} {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif", "jpeg"],
            minFileCount : 0,
            maxFileCount: 1,
            showUpload: true,
            previewFileType: 'any',
            initialPreviewFileType: 'image',
            maxImageWidth: 800,
            maxImageHeight: 530,
            minImageWidth: 350,
            minImageHeight: 263
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