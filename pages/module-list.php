<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Permission Module List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">All Modules</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data" >
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permission Module List</h3>
                    <div class="card-tools">
                        
                    <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input common_permission" id="write_permission" name="common" value="write" checked >
                            <label for="write_permission" class="form-check-label font-weight-bold ml-1 mr-4">Write</label><br>
                            <input type="radio" class="form-check-input common_permission" id="read_permission" name="common" value="read" >
                            <label for="read_permission" class="form-check-label font-weight-bold ml-1 mr-4">Read</label><br>
                            <input type="radio" class="form-check-input common_permission" id="none_permission" name="common" value="none" >
                            <label for="none_permission" class="form-check-label font-weight-bold ml-1 mr-4">None</label> 
                        </div>  
                        <input  class="btn btn-primary" type= "submit" name="submit" value="Update Permission">
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="action" value="update_permission">
                    <input type="hidden" name="admin_id" value="<?php echo $_GET['admin_id']; ?>">
                    <?php
                    echo $objIndex->get_module_list_post(); 
                    ?>
                    <div class="col-sm-12 text-center">  
                        <input  class="btn btn-primary" type= "submit" name="submit" value="Update Permission">
                    </div>
                </div>
            </div>
        </form>        
    </section>
</div>
<script>
    $(document).ready(function () {
        $(".common_permission").change(function(){
            $(".permission_list input[type='radio']:not('."+$(this).attr('id')+"')").removeAttr('checked').prop("checked", false);
            $("." + $(this).attr('id')).attr('checked', 'checked').prop("checked", true);
        });
        // $("#master_div_pagination").InexDataTable(
        //     'index.php',  // ajax url
        //     '',              // csrf_token only in laravel. set blank in core
        //     ['action'],  //this is array of all ids, whose values you want to send
        //     function () {
        //         //function call before ajax call
        //         $("#inex_overlay").show();
        //     },
        //     function () {
        //         //function call after ajax responce
        //         $("#inex_overlay").hide();
        //     }
        // );
    });
</script>