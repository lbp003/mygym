<!--- header  ---->
<?php include '../../layout/header.php'; ?>
<?php 
    $clsData = $_SESSION['clsData'];
    // var_dump($clsData); exit;
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Class</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Update Class</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
                <form method="post" id="updateClass" name="updateClass" action="../../../controller/classController.php?status=Update" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6" style="text-align:center">
                        <div class="kv-avatar">
                            <div class="file-loading">
                                <input id="avatar" name="avatar" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="class_name">Class Name</label>
                        <input type="text" class="form-control" id="class_name" name="class_name" aria-describedby="class_name" placeholder="Class Name" value="<?php echo $clsData['class_name']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="color">Color</label>
                        <input type="text" class="form-control" id="color" name="color" aria-describedby="color" placeholder="color" value="<?php echo $clsData['color']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $clsData['class_description']?></textarea>
                    </div>
                    <div class="col-12">
                        <input type="hidden" name="image" value="<?php echo $clsData['image']?>"> 
                        <input type="hidden" name="class_id" value="<?php echo $clsData['class_id']?>"> 
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
        $('#updateClass').validate({
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

        <?php 
            if(!empty($clsData['image'])){ ?>
                var path = "<?php echo "../../../".PATH_IMAGE.PATH_CLASS_IMAGE.$clsData['image']; ?>";   
                // console.log(path);
        <?php } ?>

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
            defaultPreviewContent: '<?php if(!empty($clsData['image'])){ ?><img src="'+ path +'" width="100" height="auto" class="img-responsive img-thumbnail" /> <?php }else{ ?> <i class="fas fa-user fa-7x"></i> <?php } ?>',
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