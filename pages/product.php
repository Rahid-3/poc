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
                    <button type="button" class="btn btn-default btn-xs" id="add_new_btn">Add Product</button>
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
                                    <tr><td>1</td><td>Ranbir Kapoor</td><td>ranbir@gmail.com</td><td>8888888888</td><td>11 Sep 2024</td><td><button type="button" class="btn btn-primary btn-xs edit-student-btn" data-id="17">Edit</button> <button type="button" class="btn btn-danger btn-xs delete-student-btn" data-id="17">Delete</button></td></tr>
                                    <tr><td>2</td><td>Sunny</td><td>sanny@gmail.com</td><td>1234567890</td><td>11 Sep 2024</td><td><button type="button" class="btn btn-primary btn-xs edit-student-btn" data-id="16">Edit</button> <button type="button" class="btn btn-danger btn-xs delete-student-btn" data-id="16">Delete</button></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Form HTML (to be dynamically added) -->
<script id="add-product-form-template" type="text/x-handlebars-template">
    <div class="card">
        <div class="card-header">
            <h4>Add Shopify 2k Variants Creation</h4>
            <button type="button" class="close" id="close_form">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <form class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_new_product_info">

                <div class="form-group row">
                    <label for="pro_shop" class="col-sm-2 col-form-label">Shop</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="pro_shop" id="pro_shop">
                            <option value="">Select Shop</option>
                            <option value="Shop 1">Shop 1</option>
                            <option value="Shop 2">Shop 2</option>
                            <option value="Shop 3">Shop 3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="pro_title" class="col-sm-2 col-form-label">Product Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="pro_title" id="pro_title" placeholder="Product Title">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="pro_desc" class="col-sm-2 col-form-label">Product Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="pro_desc" id="pro_desc" placeholder="Product Description">
                    </div>
                </div>

                <div id="variant-container">
                    <div class="form-group row variant-group" id="variant-1">
                        <label for="tags" class="col-sm-2 col-form-label">Product Variant 1</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="pro_nm_opt1" id="pro_nm_opt1" placeholder="Product Option Name 1" autocomplete="off">
                            <div class="tags-input-container" id="tags-input-container1">
                                <input type="text" class="form-control" id="tag-input1" placeholder="Add tags..." autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-variant-btn" class="btn btn-primary">Add New Variant</button>

                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-info">Add Product</button>
                        <button type="button" class="btn btn-danger" id="close_form">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</script>

<!-- Inline JavaScript for handling form and tag logic -->
<script>
$(document).ready(function() {
    var currentURL = window.location.href;
    let variantCount = 1;
    let tagCounts = {}; // Store the count of tags per variant

    // Function to load the product table
    function loadProductTable() {
        $("#master_div_product").html(`
            <table class="table table-bordered table-hover">
                <thead>
                    <tr><th>#</th><th>Student Name</th><th>Email</th><th>Mobile</th><th>Date</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Ranbir Kapoor</td><td>ranbir@gmail.com</td><td>8888888888</td><td>11 Sep 2024</td><td><button type="button" class="btn btn-primary btn-xs edit-student-btn" data-id="17">Edit</button> <button type="button" class="btn btn-danger btn-xs delete-student-btn" data-id="17">Delete</button></td></tr>
                    <tr><td>2</td><td>Sunny</td><td>sanny@gmail.com</td><td>1234567890</td><td>11 Sep 2024</td><td><button type="button" class="btn btn-primary btn-xs edit-student-btn" data-id="16">Edit</button> <button type="button" class="btn btn-danger btn-xs delete-student-btn" data-id="16">Delete</button></td></tr>
                </tbody>
            </table>
        `);
    }

    // Add product form display logic
    $("#add_new_btn").click(function() {
        var newUrl = "index.php?do=addproduct";
        history.pushState({page: "addproduct"}, "Add Product", newUrl);

        var template = $("#add-product-form-template").html();
        $("#master_div_product").html(template);

        initTagInput('tag-input1', 'tags-input-container1', 1);
    });

    // Close form and revert to product table view
    $(document).on('click', '#close_form', function() {
        history.pushState({page: "product"}, "Products", currentURL);
        loadProductTable();
    });

    // Handle browser back button
    window.onpopstate = function(event) {
        if (event.state && event.state.page === "product") {
            loadProductTable();
        }
    };

    // Initialize tag input and manage tag limits
    function initTagInput(tagInputId, tagContainerId, variantId) {
        const tagInput = document.getElementById(tagInputId);
        const tagContainer = document.getElementById(tagContainerId);
        let tags = [];

        function createTag(label) {
            const div = document.createElement('div');
            div.setAttribute('class', 'tag');
            div.textContent = label;

            const closeBtn = document.createElement('span');
            closeBtn.textContent = 'x';
            closeBtn.setAttribute('class', 'remove-tag');
            closeBtn.onclick = function() {
                removeTag(label);
            };

            div.appendChild(closeBtn);
            return div;
        }

        function addTag(tag) {
            if (tag.length > 0 && !tags.includes(tag) && checkTagLimit()) {
                tags.push(tag);
                const newTag = createTag(tag);
                tagContainer.insertBefore(newTag, tagInput);
                tagInput.value = '';

                // Update tag count for the variant
                updateTagCount(variantId, tags.length);
            }
        }

        function removeTag(tag) {
            tags = tags.filter(t => t !== tag);
            renderTags();
            updateTagCount(variantId, tags.length);
        }

        function renderTags() {
            tagContainer.querySelectorAll('.tag').forEach(tag => tag.remove());
            tags.forEach(tag => {
                const newTag = createTag(tag);
                tagContainer.insertBefore(newTag, tagInput);
            });
        }

        tagInput.addEventListener('keydown', function(e) {
            if ((e.key === 'Enter' || e.key === ',') && checkTagLimit()) {
                const tag = tagInput.value.trim().replace(/,$/, '');
                addTag(tag);
                e.preventDefault();
            }
        });
    }

    // Function to update the tag count for each variant and check total limit
    function updateTagCount(variantId, count) {
        tagCounts[variantId] = count;
        const totalProductVariants = calculateTotalProductVariants();

        if (totalProductVariants > 100) {
            alert('The limit is 100 product variant combinations. You cannot add more tags.');
            disableTagInputs();
        } else {
            enableTagInputs(); // Re-enable the inputs if under the limit
        }
    }

    // Calculate total product variants by multiplying tag counts of all variants
    function calculateTotalProductVariants() {
        const total = Object.values(tagCounts).reduce((acc, count) => acc * (count || 1), 1);
        return total;
    }

    // Disable further tag inputs
    function disableTagInputs() {
        $('input[id^="tag-input"]').attr('disabled', true);
    }

    // Enable tag inputs if tag limit is under 100 combinations
    function enableTagInputs() {
        $('input[id^="tag-input"]').attr('disabled', false);
    }

    // Check if adding a new tag will exceed the limit of 100 product variant combinations
    function checkTagLimit() {
        const totalProductVariants = calculateTotalProductVariants();
        if (totalProductVariants >= 100) {
            alert('The limit is 100 product variant combinations. You cannot add more tags.');
            return false;
        }
        return true;
    }

    // Add variant functionality
    $(document).on('click', '#add-variant-btn', function() {
        if (variantCount >= 3) {
            alert('You can add up to 3 variants only.');
            return;
        }

        variantCount++;

        const newVariant = `
            <div class="form-group row variant-group" id="variant-${variantCount}">
                <label for="tags" class="col-sm-2 col-form-label">Product Variant ${variantCount}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="pro_nm_opt${variantCount}" id="pro_nm_opt${variantCount}" placeholder="Product Option Name ${variantCount}" autocomplete="off">
                    <div class="tags-input-container" id="tags-input-container${variantCount}">
                        <input type="text" class="form-control" id="tag-input${variantCount}" placeholder="Add tags..." autocomplete="off">
                    </div>
                </div>
            </div>
        `;

        $('#variant-container').append(newVariant);
        initTagInput(`tag-input${variantCount}`, `tags-input-container${variantCount}`, variantCount);
    });

    // Initialize product table view on page load
    loadProductTable();
});
</script>




