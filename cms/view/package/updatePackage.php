<!--- header  ---->
<?php
include '../../layout/header.php'; ?>
<?php
    $packData = $_SESSION['packData'];
?> 
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Package</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Update Package</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="updatePackage" name="updatePackage" action="../../../controller/packageController.php?status=Update" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6" style="text-align:center">
                        <div class="kv-avatar">
                            <div class="file-loading">
                                <input id="avatar" name="avatar" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="package_name">Package Name</label>
                        <input type="text" class="form-control" id="package_name" name="package_name" aria-describedby="package_name" placeholder="Package Name" value="<?php echo $packData['package_name'];?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="fee">Fee</label>
                        <input type="text" class="form-control" id="fee" name="fee" aria-describedby="fee" value="<?php echo $packData['fee'];?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="duration">Duration</label>
                        <input type="number" class="form-control" id="duration" name="duration" aria-describedby="duration" value="<?php echo $packData['duration'];?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $packData['package_description'];?></textarea>
                    </div>
                    <div class="col-12">
                        <input type="hidden" id="package_id" name="package_id" aria-describedby="package_id" value="<?php echo $packData['package_id'];?>">
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

        // Form validation
        $('#updatePackage').validate({
            rules: {
                fee: {
                    required: true,
                    number: true
                }, 
                duration: {
                    required: true,
                    number: true,
                    max: 12
                }, 
                // package_name: {
				// 	required: true,
				// 	package_name: true,
                //     remote: {
                //         url: '../../../controller/classSessionController.php?status=checkSessionName',
                //         type: 'post',
                //         data: {
                //             package_name: function(){
                //                 return $("#package_name").val();
                //             }
                //         }
                //     }
				// },
                description: "required"
            },
            messages: {
                fee: {
                    required: "Please enter fee"
                },
                duration: {
                    required: "Please enter Duration"
                },
                package_name: {
                    required: "Please enter Package Name",
                    remote: function() { return $.validator.format("{0} is already taken", $("#package_name").val()) }
                },
                description: {
                    required: "Please enter description"
                }
            }
        });

        <?php 
            if(!empty($packData['image'])){ ?>
                var path = "<?php echo "../../../".PATH_IMAGE.PATH_PACKAGE_IMAGE.$packData['image']; ?>";   
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
            defaultPreviewContent: '<?php if(!empty($packData['image'])){ ?><img src="'+ path +'" width="100" height="auto" class="img-responsive img-thumbnail" /> <?php }else{ ?> <i class="fas fa-gift fa-7x"></i> <?php } ?>',
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