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
                    <div id="master_product_varinat"></div>
                    
                  </div>
               
            </div>
         </div>
      </div>
   </section>
</div>

<script>
$(document).ready(function() {
    //getProductList();
    //console.log("change");
    const id = $("#product_id").val();
    console.log(id);
    getProductVariantList(id);
});
function  getProductVariantList(id){
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
            $("#master_product_varinat").html(obj.DATA);
            //Find Last ID
            if(result.length > 0){
                
            }
            // End Find Last ID
        }
    });
}

</script>
<script>
        const data = [
            { id: 162, title: "m / Red / Cotton", price: 1, shopifyId: "gid://shopify/ProductVariant/47244169806061", actions: "Edit Delete" },
            { id: 163, title: "m / Red / Silk", price: 2, shopifyId: "gid://shopify/ProductVariant/47244169838829", actions: "Edit Delete" },
            { id: 164, title: "m / Green / Cotton", price: 3, shopifyId: "gid://shopify/ProductVariant/47244169871597", actions: "Edit Delete" },
            { id: 165, title: "m / Green / Silk", price: 4, shopifyId: "gid://shopify/ProductVariant/47244169904365", actions: "Edit Delete" },
            { id: 166, title: "l / Red / Cotton", price: 5, shopifyId: "gid://shopify/ProductVariant/47244169937133", actions: "Edit Delete" },
            { id: 167, title: "l / Red / Silk", price: 6, shopifyId: "gid://shopify/ProductVariant/47244169969901", actions: "Edit Delete" },
            { id: 168, title: "l / Green / Cotton", price: 7, shopifyId: "gid://shopify/ProductVariant/47244170002669", actions: "Edit Delete" },
            { id: 169, title: "l / Green / Silk", price: 8, shopifyId: "gid://shopify/ProductVariant/47244170035437", actions: "Edit Delete" },
        ];

        const rowsPerPage = 4;
        let currentPage = 1;

        function displayTableData(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedData = data.slice(start, end);

            const tableBody = document.getElementById("table-body");
            tableBody.innerHTML = "";

            paginatedData.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `<td>${row.id}</td><td>${row.title}</td><td>${row.price}</td><td>${row.shopifyId}</td><td>${row.actions}</td>`;
                tableBody.appendChild(tr);
            });
        }

        function setupPagination() {
            const pageCount = Math.ceil(data.length / rowsPerPage);
            const pagination = document.getElementById("pagination");

            pagination.innerHTML = "";
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement("li");
                li.innerText = i;
                li.classList.add(i === currentPage ? "active" : "");
                li.addEventListener("click", () => {
                    currentPage = i;
                    displayTableData(currentPage);
                    updatePagination();
                });
                pagination.appendChild(li);
            }
        }

        function updatePagination() {
            const paginationItems = document.querySelectorAll(".pagination li");
            paginationItems.forEach((item, index) => {
                item.classList.toggle("active", index + 1 === currentPage);
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            displayTableData(currentPage);
            setupPagination();
        });
    </script>