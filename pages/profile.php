<?php
$user_data = $objIndex->check_user_by_id($_SESSION['login_user_id']);
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Personal Details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data" onsubmit="return check_personal_details_val();">
                <input type="hidden" name="action" value="edit_profile_personal_details_post" >

                <div class="card-body">
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="<?=$user_data[0]['first_name']?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="<?=$user_data[0]['last_name']?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?=$user_data[0]['email']?>">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Change Password</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data" onsubmit="return check_change_password_val();">
                <input type="hidden" name="action" value="edit_profile_change_password_post">
                
                <div class="card-body">
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>

    </section>
</div>

<script>
    function check_personal_details_val(){
        var first_name = $("#first_name").val().trim();
        var last_name = $("#last_name").val().trim();
        var email = $("#email").val().trim();
        var err = 0;

        if(email==''){
            err++;
            toastr.error('Please enter email');
        }
        if(last_name==''){
            err++;
            toastr.error('Please enter last name');
        }
        if(first_name==''){
            err++;
            toastr.error('Please enter first name');
        }

        if(err==0){
            return true;
        }else{
            return false;
        }
    }
    function check_change_password_val(){
        var password = $("#password").val().trim();
        var confirm_password = $("#confirm_password").val().trim();
        var err = 0;

        if(confirm_password==''){
            err++;
            toastr.error('Please enter confirm password');
        }
        if(password==''){
            err++;
            toastr.error('Please enter password');
        }
        if(password!='' && confirm_password!='' && password!=confirm_password){
            err++;
            toastr.error('Password and Confirm password is not matched.');
        }


        if(err==0){
            return true;
        }else{
            return false;
        }
    }



</script>