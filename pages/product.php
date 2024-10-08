<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shopify 2k Variants Creation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Shopify 2k Variants Creation</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Shopify 2k Variants Creation</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-default btn-xs" id="add_new_btn">Add New Product</button>
                </div>
            </div>
            <div class="card-body">
                <div class="inex_overlay" id="inex_overlay">
                    <i class="inex_overlay_loader fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
                <div>
                    <input type="hidden" id="action" value="get_product_info_list_post">
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="master_div_product">
                            <!-- Placeholder for the product form -->
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr><th>#</th><th>Student Name</th><th>Email</th><th>Mobile</th><th>Date</th><th>Actions</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Mike</td><td>mike@gmail.com</td><td>8888888888</td><td>11 Sep 2024</td><td><button type="button" class="btn btn-primary btn-xs edit-student-btn" data-id="17">Edit</button> <button type="button" class="btn btn-danger btn-xs delete-student-btn" data-id="17">Delete</button></td></tr>
                                    <tr><td>2</td><td>John</td><td>john@gmail.com</td><td>1234567890</td><td>11 Sep 2024</td><td><button type="button" class="btn btn-primary btn-xs edit-student-btn" data-id="16">Edit</button> <button type="button" class="btn btn-danger btn-xs delete-student-btn" data-id="16">Delete</button></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function() {
        // Add product form display logic
        $("#add_new_btn").click(function() {
        var newUrl = "index.php?do=addproduct";
        window.location.href = newUrl;
    });
});
</script>

