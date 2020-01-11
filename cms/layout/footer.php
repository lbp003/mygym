<footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <small>LBP &COPY; <?php echo date("Y"); ?> | All Rights Reserved </small>
                </div>
            </div>
        </div>
    </footer>
    <!-- jquery -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <!-- proper js for bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- bootstrap 4 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- datatables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../../../public/plugin/bootbox/bootbox.min.js"></script>
    <script type="text/javascript" src="../../../public/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <!-- JqueryValidation -->
    <script type="text/javascript" src="../../../public/plugin/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../../../public/plugin/jquery-validation/additional-methods.min.js"></script>
    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/piexif.min.js" type="text/javascript"></script>
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
        This must be loaded before fileinput.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/sortable.min.js" type="text/javascript"></script>
    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for 
        HTML files. This must be loaded before fileinput.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/purify.min.js" type="text/javascript"></script>
    <!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal
        dialog. bootstrap 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- the main fileinput plugin file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/piexifjs@1.0.6/piexif.min.js"></script>
    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/fas/theme.min.js"></script>
    <!-- color picker -->
    <script src="../../../public/plugin/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
    <!-- select2 plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <!-- Hightchart plugin -->
    <script src="../../../public/plugin/Highcharts/code/highcharts.js"></script>
    <script src="../../../public/plugin/Highcharts/code/modules/exporting.js"></script>
    <script src="../../../public/plugin/Highcharts/code/modules/export-data.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {

            // deactivate confirmation
            $('.deactivate').on('click', function(event){
            event.preventDefault();
                bootbox.confirm({
                message: "Are you sure that you want to Deactivate ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                    var href = $('.deactivate').attr('href');
                    window.location.href = href;
                    }
                }
            });
            });

        //    activate confirmation
            $('.activate').on('click', function(event){
                event.preventDefault();
                    bootbox.confirm({
                    message: "Are you sure that you want to Activate ?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if(result){
                        var href = $('.activate').attr('href');
                        window.location.href = href;
                        }
                    }
                });
            });

        // delete confirmation
            $('.delete').on('click', function(event){
                event.preventDefault();
                    bootbox.confirm({
                    message: "Are you sure that you want to Delete ?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if(result){
                        var href = $('.delete').attr('href');
                        window.location.href = href;
                        }
                    }
                });
            });

            $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            })

            <?php 
            if(isset($_REQUEST['msg'])){
                $msg = base64_decode($_REQUEST['msg']);
                $msgAr = json_decode($msg, true); ?>
                var title = '<?php echo $msgAr["title"];?>';
                var message = '<?php echo $msgAr["message"];?>';
                var type = '<?php echo $msgAr["type"];?>'; 

            //notify messages
            showStatusMessage(title,message,type);

            <?php } ?>
        });

    function showStatusMessage(title,message,type){

        $.notify({
            title: title,
            message: message
        },{
            type: type,
            delay: 5000,
            placement: {
                from: "bottom",
                align: "right"
            },
            animate:{
                enter: "animated fadeInUp",
                exit: "animated fadeOutDown"
            }
        });
        }
    </script>       
    </body>
</html>