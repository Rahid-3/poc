<style>
        .pagination {
            display: flex;
            list-style-type: none;
            margin: 10px 0;
        }

        .pagination li {
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .pagination li.active {
            font-weight: bold;
            background-color: #0056b3;
        }

        .pagination li.disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
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
});

function getProductVariantList(id) {
    $.ajax({
        url: 'index.php',
        method: 'POST',
        data: {
            'action': 'product_variant_list',
            'id': id
        },
        success: function(result) {
            let obj = JSON.parse(result);
            console.log(obj.DATA);
            $("#table-body").html(obj.DATA);

            // Call pagination setup after table rows are populated
            const rowsPerPage = 4;
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

                const prevLi = document.createElement("li");
                prevLi.innerText = "Prev";
                prevLi.classList.toggle("disabled", currentPage === 1);
                prevLi.addEventListener("click", () => {
                    if (currentPage > 1) {
                        currentPage--;
                        displayTableData(currentPage);
                        updatePagination();
                    }
                });
                pagination.appendChild(prevLi);

                for (let i = 1; i <= pageCount; i++) {
                    const li = document.createElement("li");
                    li.innerText = i;
                    li.classList.toggle("active", i === currentPage);
                    li.addEventListener("click", () => {
                        currentPage = i;
                        displayTableData(currentPage);
                        updatePagination();
                    });
                    pagination.appendChild(li);
                }

                const nextLi = document.createElement("li");
                nextLi.innerText = "Next";
                nextLi.classList.toggle("disabled", currentPage === pageCount);
                nextLi.addEventListener("click", () => {
                    if (currentPage < pageCount) {
                        currentPage++;
                        displayTableData(currentPage);
                        updatePagination();
                    }
                });
                pagination.appendChild(nextLi);
            }

            function updatePagination() {
                const pageCount = Math.ceil(rows.length / rowsPerPage);
                const paginationItems = document.querySelectorAll(".pagination li");

                paginationItems.forEach((item, index) => {
                    if (index === 0) {
                        item.classList.toggle("disabled", currentPage === 1);
                    } else if (index === paginationItems.length - 1) {
                        item.classList.toggle("disabled", currentPage === pageCount);
                    } else {
                        item.classList.toggle("active", parseInt(item.innerText) === currentPage);
                    }
                });
            }

            // Initialize table data and pagination after rows are loaded
            displayTableData(currentPage);
            setupPagination();
        }
    });
}

</script>