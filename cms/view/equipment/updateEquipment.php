<!--- header  ---->
<?php include '../../layout/header.php'; ?>
<?php 
    $equData = $_SESSION['equData'];
    // var_dump($equData); exit;
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Equipment</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Update Equipment</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
                <form method="post" id="updateClass" name="updateClass" action="../../../controller/equipmentController.php?status=Update" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6" style="text-align:center">
                        <div class="kv-avatar">
                            <div class="file-loading">
                                <input id="avatar" name="avatar" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="equipment_name">Equipment Name</label>
                        <input type="text" class="form-control" id="equipment_name" name="equipment_name" aria-describedby="equipment_name" placeholder="Equipment Name" value="<?php echo $equData['equipment_name']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $equData['equipment_description']?></textarea>
                    </div>
                    <div class="col-12">
                        <input type="hidden" name="equipment_id" value="<?php echo $equData['equipment_id']?>"> 
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
                equipment_name: "required",
                description: "required"
            },
            messages: {
                equipment_name: {
                    required: "Please enter class name"
                },
                description: {
                    required: "Please enter description"
                }
            }
        });

        <?php 
            if(!empty($equData['image'])){ ?>
                var path = "<?php echo "../../../".PATH_IMAGE.PATH_EQUIPMENT_IMAGE.$equData['image']; ?>";   
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
            defaultPreviewContent: '<?php if(!empty($equData['image'])){ ?><img src="'+ path +'" width="100" height="auto" class="img-responsive img-thumbnail" /> <?php }else{ ?> <i class="fas fa-user fa-7x"></i> <?php } ?>',
            layoutTemplates: {main2: '{preview} {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif", "jpeg"],
            minFileCount : 0,
            maxFileCount: 1,
            showUpload: true,
            previewFileType: 'any',
            initialPreviewFileType: 'image',
        });
    });
</script>