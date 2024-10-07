<?php
$admin_data = $site_log_objIndex->get_all_admin_dropdown();
// $shop_data = $site_log_objIndex->get_all_shop_dropdown();
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>App Logs</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">App Logs</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">App Logs</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-default btn-xs" id="filter_show_btn">Filters</button>
                    <!--<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>-->
                </div>
            </div>
            <div class="card-body">
                <div class="inex_overlay" id="inex_overlay">
                    <i class="inex_overlay_loader fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
                <div>
                    <input type="hidden" id="action" value="get_app_logs_list_post">
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="filter_main_section" style="display: none;">
                        <div class="form-group row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="language" class="col-form-label">User</label>
                                <select class="form-control" id="search_user">
                                    <option value=""> - Select - </option>
                                    <?php foreach($admin_data as $admin){ ?>
                                        <option value="<?=$admin['id']?>"><?=$admin['first_name']?> <?=$admin['last_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="language" class="col-form-label">App</label>
                                <select class="form-control" id="search_app">
                                    <option value=""> - Select - </option>
                                    <option value="<?=common::APP_NAME?>"><?=common::APP_NAME?></option>
                        
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="language" class="col-form-label">Shop</label>
                                <select class="form-control" id="search_shop">
                                    <option value=""> - Select - </option>
                                    <?php foreach($shop_data as $s){ ?>
                                        <option value="<?=$s['shop_name']?>"><?=$s['shop_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label for="language" class="col-form-label">Operation</label>
                                <select class="form-control" id="search_operation">
                                    <option value=""> - Select - </option>
                                    <option value="Add">Add</option>
                                    <option value="Update">Update</option>
                                    <option value="Delete">Delete</option>
                                    <option value="Login">Login</option>
                                    <option value="Logout">Logout</option>
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
            </div>
        </div>

    </section>
</div>

<script src="assets/custom/inex_datatable.js?v=<?= time() ?>" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $("#master_div_pagination").InexDataTable(
            'index.php',  // ajax url
            '',              // csrf_token only in laravel. set blank in core
            ['action','search_user','search_app','search_shop','search_operation'],  //this is array of all ids, whose values you want to send
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
    $("#search_btn").click(function(){
        $("#pagination_page_no").val('1');
        call_list();
    });
</script>