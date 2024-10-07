<?php
$upload_url = str_replace('login.php','',common::APP_INSTALL_URL);
$shop_data = $site_log_objIndex->get_all_shop_dropdown();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Logs</h1>
                    <P>Here is the display of list of products log which orderd</P>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Product Logs</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Product Logs</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-default btn-xs" id="exported_files">Exported Files</button>
                    <button type="button" class="btn btn-default btn-xs" id="filter_show_btn">Filters</button>
                </div>
            </div>
            <div class="card-body">
                <div class="inex_overlay" id="inex_overlay">
                    <i class="inex_overlay_loader fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
                <div>
                    <input type="hidden" id="action" value="get_product_logs">
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="filter_main_section" style="display: none;">
                        <div class="form-group row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="language" class="col-form-label">Shop</label>
                                <select class="form-control" id="search_shop">
                                    <option value=""> - Select - </option>
                                    <?php foreach($shop_data as $s){ ?>
                                        <option value="<?=$s['shop_name']?>"><?=$s['shop_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="button" class="btn-primary btn-sm" id="search_btn">Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" id="master_div_pagination"></div>
                    </div>
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
<div class="modal fade" id="exported_files_model">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Old Exported Files</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="exported_file_list_block">
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="assets/custom/inex_datatable.js?v=<?= time() ?>" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
    $(document).ready(function () {
        $("#master_div_pagination").InexDataTable(
            'index.php',  // ajax url
            '',              // csrf_token only in laravel. set blank in core
            ['action','search_shop'],  //this is array of all ids, whose values you want to send
            function () {
                //function call before ajax call
                $("#inex_overlay").show();
            },
            function () {
                //function call after ajax responce
                $("#inex_overlay").hide();
            }
        );
    });
    $("#filter_show_btn").click(function(){
        $("#filter_main_section").toggle();
    });
    $("#exported_files").click(function(){
        // var shop_id = $("#upload_logo_shop_id").val();
        $.ajax({
            url: '<?=$upload_url?>process_on_request.php?action=get_exported_file_list',
            type: 'get',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function (result) {
                var obj = JSON.parse(result);
                if(obj.SUCCESS=='TRUE'){
                    $('#exported_file_list_block').html(obj.DATA);
                    $("#exported_files_model").modal('show');
                }else{
                    toastr.error(obj.MESSAGE);
                }
            }
        });
        
    });
    
    $("#search_btn").click(function(){
        $("#pagination_page_no").val('1');
        call_list();
    });

</script>