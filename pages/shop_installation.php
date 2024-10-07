<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shop Installation</h1>
                   </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Shop Installation</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Shop Installation</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-default btn-xs" id="add_new_btn">Add Shop</button>
                    <!--<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>-->
                </div>
            </div>
            <div class="card-body">
                <div class="inex_overlay" id="inex_overlay">
                    <i class="inex_overlay_loader fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
                <div>
                    <input type="hidden" id="action" value="get_shop_installation_list_post">
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

<div class="modal fade" id="add_new_shop_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add store for direct installation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data" onsubmit="return check_add_new_val();">
                    <input type="hidden" name="action" value="add_new_shop_install_token_post">

                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Shop name (without "https://")</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="sit_shop" id="sit_shop" placeholder="demo.myshopify.com">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Token</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="token" id="token" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-info">Add Store</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="edit_shop_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Shop</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data" onsubmit="return check_edit_val();">
                    <input type="hidden" name="action" value="edit_shop_install_token_post">
                    <input type="hidden" name="shop_id" id="edit_shop_id">

                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Shop name (without "https://")</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="sit_shop" id="edit_sit_shop" placeholder="demo.myshopify.com">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Token</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="token" id="edit_token" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-info">Save Changes</button>
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
    $(document).ready(function() {
        $("#master_div_pagination").InexDataTable(
            'index.php', // ajax url
            '', // csrf_token only in laravel. set blank in core
            ['action'], //this is array of all ids, whose values you want to send
            function() {
                //function call before ajax call
                $("#inex_overlay").show();
            },
            function() {
                //function call after ajax responce
                $("#inex_overlay").hide();
            }
        );
    });
    $("#add_new_btn").click(function() {
        $("#add_new_shop_modal").modal('show');
    });

    function check_add_new_val() {
        var sit_shop = $("#sit_shop").val().trim();
        var token = $("#token").val().trim();

        var err = 0;


        if (token == '') {
            err++;
            toastr.error('Please enter Token');
        }
        if (sit_shop == '') {
            err++;
            toastr.error('Please enter shop');
        }

        if (err == 0) {
            return true;
        } else {
            return false;
        }
    }

    $(document).on('click', '.copy_install_link', function() {
        var link = $(this).data('link');
        copy_text(link);
        toastr.success("Copied the Link");
    });

    function copy_text(text) {
        var input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);
        input.select();
        var result = document.execCommand('copy');
        document.body.removeChild(input);
        return result;
    }

    $(document).on('click', '.edit-shop-btn', function() {
        var id = $(this).data('id');
        var shop = $(this).data('shop');
        var token = $(this).data('token');

        // Populate the edit modal with the current values
        $('#edit_shop_id').val(id);
        $('#edit_sit_shop').val(shop);
        $('#edit_token').val(token);

        // Show the edit modal
        $('#edit_shop_modal').modal('show');
    });


    $(document).on('click', '.delete-shop-btn', function() {
        var result = confirm("Do want to delete this?");
    if (result) {
    //Logic to delete the item

        let id = $(this).data('id');
        $.ajax({
            url: '',
            method: 'post',
            data: {
                'action': 'delete_shop_install_token_post',
                'id': id
            },
            success: function(result) {
                var obj = JSON.parse(result);
                if (obj.SUCCESS == 'TRUE') {
                    toastr.success(obj.MESSAGE);
                } else {
                    toastr.error(obj.MESSAGE);
                }
                call_list();
            }
        });
    }
    });



</script>