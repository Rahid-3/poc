<?php
$upload_url = str_replace('login.php','',common::APP_INSTALL_URL);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Page Permission</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Page Permission</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Page Permission</h3>

                <!--<div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>-->
            </div>
            <div class="card-body">
                <div class="inex_overlay" id="inex_overlay">
                    <i class="inex_overlay_loader fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
                <div>
                    <input type="hidden" id="action" value="get_page_permission_list_post">
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" id="master_div_pagination"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<div class="modal fade" id="upload_logo_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Logo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return false;">
                    <input type="hidden" name="shop_id" id="upload_logo_shop_id" value="">

                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Upload Logo</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="upload_logo_file" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="button" id="upload_logo_submit" class="btn btn-info">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_shop_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return false;">
                    <input type="hidden" name="shop_id" id="edit_shop_shop_id" value="">

                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Edit Sender Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="edit_shop_sender_email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="button" id="edit_shop_submit" class="btn btn-info">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="assets/custom/inex_datatable.js?v=<?= time() ?>" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
    $(document).ready(function () {
        $("#master_div_pagination").InexDataTable(
            'index.php',  // ajax url
            '',              // csrf_token only in laravel. set blank in core
            ['action'],  //this is array of all ids, whose values you want to send
            function () {
                //function call before ajax call
                $("#inex_overlay").show();
            },
            function () {
                //function call after ajax responce
                $("#inex_overlay").hide();
                $("input[data-bootstrap-switch]").each(function(){
                    $(this).bootstrapSwitch('state', $(this).prop('checked'));
                });
            }
        );
    });

    $(document).on('switchChange.bootstrapSwitch', '.prmsn_class', function (event, state) {
        var id = $(this).data('id');
        var field = $(this).data('field');
        var new_status = '0';
        if ($(this).bootstrapSwitch('state')) {
            new_status = '1';
        }

        $.ajax({
            url:'',
            method:'post',
            data:{'action':'change_permission_status', 'id':id, 'new_status':new_status, 'field':field},
            success: function (result) {
                var obj = JSON.parse(result);
                if(obj.SUCCESS=='TRUE'){
                    toastr.success(obj.MESSAGE);
                }else{
                    toastr.error(obj.MESSAGE);
                }
            }
        });
    });

    $(document).on('click','.upload_logo_btn', function () {
        var shop_id = $(this).data('shop_id');
        $("#upload_logo_shop_id").val(shop_id);
        $("#upload_logo_modal").modal('show');
    });
    $("#upload_logo_submit").click(function () {
        var shop_id = $("#upload_logo_shop_id").val();
        var err = 0;

        if($('#upload_logo_file').val()==''){
            err++;
            toastr.error('Please choose logo');
        }

        if(err==0){
            $("#upload_logo_submit").attr('disabled',true);
            var formData = new FormData();
            formData.append('action', 'upload_logo_file');
            formData.append('shop_id', shop_id);
            formData.append('upload_logo_file', $('#upload_logo_file')[0].files[0]);

            $.ajax({
                url: '<?=$upload_url?>process_on_request.php',
                data: formData,
                type: 'POST',
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
                success: function (result) {
                    $("#upload_logo_submit").removeAttr('disabled');
                    var obj = JSON.parse(result);
                    if(obj.SUCCESS=='TRUE'){
                        toastr.success(obj.MESSAGE);
                        $('#upload_logo_file').val('');
                        $("#upload_logo_modal").modal('hide');
                        call_list();
                    }else{
                        toastr.error(obj.MESSAGE);
                    }
                }
            });
        }
    });

    $(document).on('click','.edit_shop_btn', function () {
        var shop_id = $(this).data('shop_id');
        var sender_email = $(this).data('sender_email');
        $("#edit_shop_shop_id").val(shop_id);
        $("#edit_shop_sender_email").val(sender_email);
        $("#edit_shop_modal").modal('show');
    });
    $("#edit_shop_submit").click(function () {
        var shop_id = $("#edit_shop_shop_id").val();
        var sender_email = $("#edit_shop_sender_email").val();
        var err = 0;

        if(err==0){
            $("#edit_shop_submit").attr('disabled',true);
            var formData = new FormData();
            formData.append('action', 'edit_shop_details');
            formData.append('shop_id', shop_id);
            formData.append('sender_email', sender_email);

            $.ajax({
                url: 'index.php',
                data: formData,
                type: 'POST',
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
                success: function (result) {
                    $("#edit_shop_submit").removeAttr('disabled');
                    var obj = JSON.parse(result);
                    if(obj.SUCCESS=='TRUE'){
                        toastr.success(obj.MESSAGE);
                        $("#edit_shop_modal").modal('hide');
                        call_list();
                    }else{
                        toastr.error(obj.MESSAGE);
                    }
                }
            });
        }
    });
</script>