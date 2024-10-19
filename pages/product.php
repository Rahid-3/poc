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
                

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mb-3">
                            <div id="master_div_paginations"></div>
                        </div>
                    </div>
                        <div id="master_div_product">
                            <!-- Placeholder for the product form -->
                            <table class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Vender</th>
                                        <th>Status</th>
                                        <th>Variant</th>
                                        <th>Actions</th>
                                        <th>Process Status</th>
                                    </tr>
                                </thead>
                                <tbody id="product_list">
                                    <tr>
                                        <td colspan="7" style="text-align:center;font-weight:bold;">Select Store for the Drop Down list</td>
                                        
                                    </tr>
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
        // $.ajax({
        //     url:'index.php',
        //     method:'GET',
        //     data:{'action':'get_product_shop'},
        //     success: function (result) {
        //         //var obj = JSON.parse(result);
        //         window.location.href = newUrl;
        //     }
        // });
        window.location.href = newUrl;
    });
});
$(document).on('change', '#pro_shop', function() {
    //getProductList();
    console.log("change");
    var id = $(this).val();
    console.log(id);
    getProductList(id);
});
function  getProductList(id){
    $.ajax({
        url: 'index.php',
        method: 'POST',
        data: {
            'action': 'get_product_list',
            'id': id
        },
        success: function(result) {
            let obj = JSON.parse(result);
            console.log(obj);
            $("#product_list").html(obj.DATA);
            //Find Last ID
            if(result.length > 0){
                
            }
            // End Find Last ID
        }
    });
}
</script>
<script>
    $(document).ready(function() {
        getProductShop();
    });

    function getProductShop(){
        $.ajax({
            url: 'index.php',
            method: 'GET',
            data: {
                'action': 'get_product_shop',
            },
            success: function(result) {
                let obj = JSON.parse(result);
                //console.log(obj);
                $("#master_div_paginations").html(obj);
            }
        });
    }

</script>

