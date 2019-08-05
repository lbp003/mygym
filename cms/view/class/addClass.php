<!--- header  ---->
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
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Class</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Add Class</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="addClass" name="addClass" action="../../../controller/classController.php?status=Insert" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="class_name">Class Name</label>
                        <input type="text" class="form-control" id="class_name" name="class_name" aria-describedby="class_name" placeholder="Class Name">
                    </div>
                    <div class="form-group col-6">
                        <label for="color">Color</label>
                        <input id="color" name="color" type="text" class="form-control input-lg" value=""/>
                    </div>
                    <div class="form-group col-6">
                        <label for="Description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group col-6" style="text-align:center">
                        <div class="kv-avatar">
                            <div class="file-loading">
                                <input id="avatar" name="avatar" type="file">
                            </div>
                        </div>
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

// form validation plugin
        $('#addClass').validate({
            rules: {
                class_name: "required",
                color: "required", 
                description: "required"
            },
            messages: {
                class_name: {
                    required: "Please enter class name"
                },
                color: {
                    required: "Please pickup color"
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
        });

// color picker plugin
        $(function () {
            $('#color').colorpicker();
        });
    });
</script>