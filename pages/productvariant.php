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
         <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               
                  <div class="card-body">
                    <input type="hidden" id="product_id" value="<?php echo $_GET['product_id']; ?>">
                    <div id="master_product_varinat">
                       
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mb-3 pull-left">
                                <?php if($_GET['shop_id']){ $url = "/shopify-2k-variants-creation/index.php?do=product&product_id=" . $_GET['shop_id']; } ?>
                                <a href="<?php echo $url;?>"><i class="fa fa-arrow-left mb-3" aria-hidden="true"></i> Back</a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mb-3 pull-right">
                                    <input type="text" id="variant_search_input" name="keyword" class="form-control" placeholder="Search Product">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Price</th>
                                                <th>Shopify variant Id</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">

                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <ul class="pagination" id="pagination">
                        <!-- Pagination controls will be generated here -->
                        </ul>
                    </div>
                    
                  </div>
               
            </div>
         </div>
      </div>
   </section>
</div>

<script>
$(document).ready(function() {
    // Get product ID
    const id = $("#product_id").val();
    console.log(id);
    getProductVariantList(id);

    var input = document.getElementById("variant_search_input");
        input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
                const urlSearchParams = new URLSearchParams(window.location.search);
                const SearchproductId = urlSearchParams.get('product_id');
                const shop_Id = urlSearchParams.get('shop_id');
                $query = input.value;
                var newShopUrl = "index.php?do=product&product_id=" + SearchproductId + "&shop_id=" + shop_Id
                window.history.pushState({path: newShopUrl}, '', newShopUrl);
                getProductVariantList(SearchproductId, $query);
            }
        });
});

function getProductVariantList(id, query) {
    $.ajax({
        url: 'index.php',
        method: 'POST',
        data: {
            'action': 'product_variant_list',
            'id': id,
            'query': query
        },
        success: function(result) {
            let obj = JSON.parse(result);
            console.log(obj.DATA);
            $("#table-body").html(obj.DATA);

            // Call pagination setup after table rows are populated
            const rowsPerPage = 10;
            let currentPage = 1;
            const tableBody = document.getElementById("table-body");
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
                const pagination = document.getElementById("pagination");

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