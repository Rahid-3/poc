<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Admin Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Admin User List</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-default btn-xs" id="add_new_btn">Add Admin</button>
                    <!--<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>-->
                </div>
            </div>
            <div class="card-body">
                <div class="inex_overlay" id="inex_overlay">
                    <i class="inex_overlay_loader fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
                <div>
                    <input type="hidden" id="action" value="get_shop">
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

<div class="modal fade" id="add_new_admin_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="admin_title">Add Admin User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data" onsubmit="return check_add_new_val();">
                    <input type="hidden" name="action" value="add_admin_post">

                    <div class="form-group row">
                        <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="" required="required">
                        </div>
                    </div>
                    <div class="form-group row password_div">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" id="password" placeholder="" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type ="hidden" name="admin_id" id="admin_id">
                        <label for="language" class="col-sm-2 col-form-label">Is Super Admin</label>
                        <div class="col-sm-10 custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="is_super_admin" name="is_super_admin" >
                            <label class="custom-control-label" for="is_super_admin"></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Is Status</label>
                        <div class="col-sm-10 custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="status" name="status" >
                            <label class="custom-control-label" for="status"></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-info" id="submit">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
        $("#add_new_admin_modal").find('form')[0].reset();
        $("#add_new_admin_modal").modal('show');
    });
    $(document).on('click', '.edit_admin', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '',
            method: 'post',
            data: {
                'action': 'select_admin',
                'id': id
            },
            success: function(result) {
                var obj = JSON.parse(result);
                if (obj.SUCCESS == 'TRUE') {
                    $('#first_name').val(obj.ADMIN[0].first_name);
                    $('#last_name').val(obj.ADMIN[0].last_name);
                    $('#email').val(obj.ADMIN[0].email);
                    if (obj.ADMIN[0].status == 1) {
                        $('#status').prop('checked', true);
                    }
                    if (obj.ADMIN[0].is_super_admin == 1) {
                        $('#is_super_admin').prop('checked', true);
                    } 
                    $("#add_new_admin_modal").modal('show');
                    $('#submit').text('Edit');
                    $('#admin_title').text('Edit Admin Title');
                    $('#admin_id').val(obj.ADMIN[0].id);
                    $('.password_div').remove();
                } else {
                    toastr.error(obj.MESSAGE);
                }
            }
        }); 
    });
    $(document).on('click', '.delete_admin', function() {
        var result = confirm("Do want to delete this?");
    if (result) {
    //Logic to delete the item

        let id = $(this).data('id');
        $.ajax({
            url: '',
            method: 'post',
            data: {
                'action': 'delete_admin',
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
    $(document).on('change', '.superadmin_status', function(e) {
       var result = confirm("Do You want to Change Status?");
      if (result) {
        let id = $(this).attr('id').replace("customSwitch","");
        let status = $(this).is(":checked") == true ? 1:0;
        $.ajax({
            url: '',
            method: 'post',
            data: {
                'action': 'superadmin_status',
                'id': id,
                'super_admin_status' : status,
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
    } else {
        location.reload();
    }
    });

    $(document).on('change', '.status', function(e) {
       var result = confirm("Do You want to Change Status?");
      if (result) {
        let id = $(this).attr('id').replace("statusSwitch","");
        let status = $(this).is(":checked") == true ? 1:0;
        $.ajax({
            url: '',
            method: 'post',
            data: {
                'action': 'status',
                'id': id,
                'status' : status,
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
    } else {
        location.reload();
    }
    });

    function check_add_new_val() {
        var first_name = $("#first_name").val().trim();
        var last_name = $("#last_name").val().trim();
        var email = $("#email").val().trim();
        var password = $("#password").val().trim();
        var err = 0;
        if (first_name == '') {
            err++;
            toastr.error('Please enter first name');
        } else if (last_name == '') {
            err++;
            toastr.error('Please enter last name');
        } else if (email == '') {
            err++;
            toastr.error('Please enter email');
        } else if (password == '') {
            err++;
            toastr.error('Please enter password');
        }
        if (err == 0) {
            return true;
        } else {
            return false;
        }
    }
</script>