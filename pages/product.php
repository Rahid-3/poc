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
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mb-3 pull-left">
                                    <div id="shoplist"></div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mb-3 pull-right">
                                    <input type="text" id="product_search_input" name="keyword" class="form-control" placeholder="Search Product">
                                </div>
                            </div>
                        </div>
                        <div id="master_div_product">
                            <!-- Placeholder for the product form -->
                            <table class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>#</th>
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
                                        <td colspan="8" style="text-align:center;font-weight:bold;">Select Store for the Drop Down list</td>
                                        
                                    </tr>
                                </tbody>
                                </table>
                                <ul class="pagination" id="pagination_product">
                        <!-- Pagination controls will be generated here -->
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Edit Product Model -->
<div class="modal fade" id="edit_product_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data" onsubmit="return check_edit_val();">
                    <input type="hidden" name="action" value="edit_shop_product">
                    <input type="hidden" name="product_id" id="edit_product_id">

                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Product Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="edit_product_title" id="edit_product_title" placeholder="product name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Vender</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="edit_vender" id="edit_vender" placeholder="vender" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="language" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="edit_pro_status" id="edit_pro_status">
                                <option value="DRAFT">Draft</option>
                                <option value="ACTIVE">Active</option>
                           </select>
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
<!-- End Edit Product Model -->
<script>
$(document).ready(function() {
    $(document).on('click', '.edit-product-btn', function() {
    var id = $(this).data('id');
    var title = $(this).data('title');
    var vender = $(this).data('vender');
    var status = $(this).data('status');

    // // Populate the edit modal with the current values
    // $('#edit_shop_id').val(id);
    // $('#edit_sit_shop').val(shop);
    // $('#edit_token').val(token);

    $('#edit_product_id').val(id);
    $('#edit_product_title').val(title);
    $('#edit_vender').val(vender);
    $('#edit_pro_status').val(status);

    // Show the edit modal
    $('#edit_product_modal').modal('show');
    });
});
</script>
<script>
$(document).ready(function() {
    // Add product form display logic
    $("#add_new_btn").click(function() {
        var newUrl = "index.php?do=addproduct";
        window.location.href = newUrl;
    });
});
$(document).on('change', '#pro_shop', function() {
    //getProductList();
    console.log("change");
    var id = $(this).val();
    console.log(id);
    getProductList(id);
    // Change the URL without reloading the page
    var newShopUrl = "index.php?do=product&product_id=" + id;
    window.history.pushState({path: newShopUrl}, '', newShopUrl);
});
// function  getProductList(id){
//     $.ajax({
//         url: 'index.php',
//         method: 'POST',
//         data: {
//             'action': 'get_product_list',
//             'id': id
//         },
//         success: function(result) {
//             let obj = JSON.parse(result);
//             console.log(obj);
//             $("#product_list").html(obj.DATA);
//             //Find Last ID
//             if(result.length > 0){
                
//             }
//             // End Find Last ID
//         }
//     });
// }
function getProductList(id, $query) {
    $.ajax({
        url: 'index.php',
        method: 'POST',
        data: {
            'action': 'get_product_list',
            'id': id,
            'query': $query
        },
        success: function(result) {
            let obj = JSON.parse(result);
            //console.log(obj.DATA);
            $("#product_list").html(obj.DATA);

            // Call pagination setup after table rows are populated
            const rowsPerPage = 10;
            let currentPage = 1;
            const tableBody = document.getElementById("product_list");
            const rows = Array.from(tableBody.querySelectorAll("tr"));

            function displayTableData(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? "" : "none";
                });
            }

            function setupPagination() {
                const pageCount = Math.ceil(rows.length / rowsPerPage);
                const pagination = document.getElementById("pagination_product");

                pagination.innerHTML = "";

                const createPageItem = (text, page, isActive = false, isDisabled = false) => {
                    const li = document.createElement("li");
                    li.innerText = text;
                    if (isDisabled) {
                        li.classList.add("disabled");
                    } else {
                        li.addEventListener("click", () => {
                            currentPage = page;
                            displayTableData(currentPage);
                            updatePagination();
                        });
                    }
                    if (isActive) li.classList.add("active");
                    return li;
                };

                const prevLi = createPageItem("Prev", currentPage - 1, false, currentPage === 1);
                pagination.appendChild(prevLi);

                // Display pages with ellipses for large datasets
                const maxPagesToShow = 5; // Number of pages to display around the current page
                const half = Math.floor(maxPagesToShow / 2);

                let startPage = Math.max(1, currentPage - half);
                let endPage = Math.min(pageCount, currentPage + half);

                if (startPage > 1) {
                    pagination.appendChild(createPageItem(1, 1)); // First page
                    if (startPage > 2) {
                        pagination.appendChild(createPageItem("...", null, false, true)); // Ellipsis
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    pagination.appendChild(createPageItem(i, i, i === currentPage));
                }

                if (endPage < pageCount) {
                    if (endPage < pageCount - 1) {
                        pagination.appendChild(createPageItem("...", null, false, true)); // Ellipsis
                    }
                    pagination.appendChild(createPageItem(pageCount, pageCount)); // Last page
                }

                const nextLi = createPageItem("Next", currentPage + 1, false, currentPage === pageCount);
                pagination.appendChild(nextLi);
            }

            function updatePagination() {
                const pageCount = Math.ceil(rows.length / rowsPerPage);
                setupPagination(); // Refresh pagination display

                // Update the "disabled" status of Prev and Next buttons
                const prevLi = document.querySelector(".pagination li:first-child");
                const nextLi = document.querySelector(".pagination li:last-child");

                prevLi.classList.toggle("disabled", currentPage === 1);
                nextLi.classList.toggle("disabled", currentPage === pageCount);
            }

            // Initialize table data and pagination after rows are loaded
            displayTableData(currentPage);
            setupPagination();
        }
    });
}
</script>
<script>
    $(document).ready(function() {
        getProductShop();
        // Parse the product_id from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('product_id');

        if (productId) {
            // If product_id is in the URL, set it as the selected option
            $('#pro_shop').val(productId);

            // Fetch product data for this product_id
            getProductList(productId);
        }

        var input = document.getElementById("product_search_input");
        input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            //alert("Input added");
            const urlSearchParams = new URLSearchParams(window.location.search);
            const SearchproductId = urlSearchParams.get('product_id');
            // console.log("This for search: " + SearchproductId);
            //getProductList(SearchproductId);
            $query = input.value;
            // Change the URL without reloading the page
            //var newShopUrl = "index.php?do=product&product_id=" + SearchproductId + "&query=" + input.value;
            //var newShopUrl = "index.php?do=product&product_id=" + SearchproductId + "&query=" + input.value
            //window.history.pushState({path: newShopUrl}, '', newShopUrl);
            //document.getElementById("myBtn").click();
            //alert(input.value);
                getProductList(SearchproductId, $query);
            }
        });

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
                $("#shoplist").html(obj);
                // Ensure the previously selected product (if any) remains selected
                const urlParams = new URLSearchParams(window.location.search);
                const productId = urlParams.get('product_id');
                if (productId) {
                    $('#pro_shop').val(productId);
                }
            }
        });
    }
</script>

