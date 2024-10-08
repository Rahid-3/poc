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
                            <div class="card">
                                <div class="card-header">
                                    <h4>Add Shopify 2k Variants Creation</h4>
                                    <button type="button" class="close" id="close_form">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="card-body">
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

                                    <div class="form-group row" id="alert" style="color:red;display:none;font-size:16px;font-weight:bold;margin-bottom: 3px;">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <div id="alert1">The limit is 100 product variant combinations. You cannot add more tags.</div>
                                        </div>
                                    </div>

                                    <div id="variant-container">
                                        <div class="form-group row variant-group" id="variant-1">
                                            <label for="tags" class="col-sm-2 col-form-label">Product Variant 1</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1" name="pro_nm_opt1" id="pro_nm_opt1" placeholder="Product Option Name 1" autocomplete="off">
                                                <div class="tags-input-container" id="tags-input-container1">
                                                    <input type="text" class="form-control" id="tag-input1" placeholder="Add tags..." autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" id="add-variant-btn" class="btn btn-primary">Add New Variant</button>

                                    <div class="form-group row">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" id="add_product_btn" class="btn btn-info add_product_btn" disabled>Add Product</button>
                                            <button type="button" class="btn btn-danger" id="close_form">Cancel</button>
                                        </div>
                                    </div>

                                    <div id="product-variant-combinations">
                                        <div class="row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10" id="product-variant-combinations-inner"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function() {
    let variantCount = 1;
    let tagCounts = {}; // Store the count of tags per variant

    // Close form and redirect
    $(document).on('click', '#close_form', function() {
        var newUrl = "index.php?do=product";
        window.location.href = newUrl;
    });

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

    function updateTagCount(variantId, count) {
        tagCounts[variantId] = count;
        const totalProductVariants = calculateTotalProductVariants();

        if (totalProductVariants > 100) {
            disableTagInputs();
        } else {
            enableTagInputs();
        }
    }

    function calculateTotalProductVariants() {
        return Object.values(tagCounts).reduce((acc, count) => acc * (count || 1), 1);
    }

    function disableTagInputs() {
        $('input[id^="tag-input"]').attr('disabled', true);
        $("#add_product_btn").attr('disabled', true);
        $("#alert").show();
    }

    function enableTagInputs() {
        $('input[id^="tag-input"]').attr('disabled', false);
        $("#alert").hide();
        $("#add_product_btn").attr('disabled', false);
    }

    function checkTagLimit() {
        const totalProductVariants = calculateTotalProductVariants();
        if (totalProductVariants >= 100) {
            alert('The limit is 100 product variant combinations. You cannot add more tags.');
            disableTagInputs();
            return false;
        }
        return true;
    }

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
                    <input type="text" class="form-control mb-1" name="pro_nm_opt${variantCount}" id="pro_nm_opt${variantCount}" placeholder="Product Option Name ${variantCount}" autocomplete="off">
                    <div class="tags-input-container" id="tags-input-container${variantCount}">
                        <input type="text" class="form-control" id="tag-input${variantCount}" placeholder="Add tags..." autocomplete="off">
                    </div>
                </div>
            </div>
        `;
        $('#variant-container').append(newVariant);

        // Initialize the new tag input for this variant
        initTagInput(`tag-input${variantCount}`, `tags-input-container${variantCount}`, variantCount);
    });

    // Initialize first variant tag input
    initTagInput('tag-input1', 'tags-input-container1', 1);
});
</script>


<script>
$(document).ready(function() {

    // Generate combinations from variants
    function generateCombinations(variants) {
        function combine(arr, prefix = []) {
            if (!arr.length) return [prefix];
            let [first, ...rest] = arr;
            let result = [];
            for (let value of first) {
                result = result.concat(combine(rest, [...prefix, value]));
            }
            return result;
        }
        return combine(variants);
    }

    // Handle Add Product Button
    $(document).on('click', '#add_product_btn', function() {
        var productTitle = $('#pro_title').val();
        var productDesc = $('#pro_desc').val();

        // Generate variant combinations
        var variant1 = extractTagTexts('tags-input-container1') || [];
        var variant2 = extractTagTexts('tags-input-container2') || [];
        var variant3 = extractTagTexts('tags-input-container3') || [];

        console.log("This is the Array of the Size: " + variant1);

        // Filter out undefined or empty arrays (arrays with length 0)
        var allVariants = [variant1, variant2, variant3].filter(arr => Array.isArray(arr) && arr.length > 0);

        console.log(allVariants);

        var variantCombinations = generateCombinations(allVariants);

        // Display combinations
        var combinationHtml = `<table>`;
        combinationHtml += `<tr>`;
        combinationHtml += `<td colspan="2"><h3>Generated Product Variants for ${productTitle}</h3></td>`;
        combinationHtml += '</tr>';

        combinationHtml += `<tr>`;
        combinationHtml += `<td colspan="2">Product Title: ${productTitle}</td>`;
        combinationHtml += '</tr>';

        combinationHtml += `<tr>`;
        combinationHtml += `<td colspan="2">Product Description: ${productDesc}</td>`;
        combinationHtml += '</tr>';
        variantCombinations.forEach(combination => {
            combinationHtml += `<tr>`;
            combinationHtml += `<td>${combination.join(' / ')}</td>`;
            combinationHtml += `<td><input type='text' name='${combination.join('')}' value='' placeholder="price"></td>`;
            combinationHtml += `</tr>`;
        });
        combinationHtml += `<tr>`;
        combinationHtml += `<td><button type="button" id="save_product_btn" class="btn btn-info save_product_btn">Save Product</button></td>`;
        combinationHtml += `</tr>`;
        //combinationHtml += '</table>';
        combinationHtml += '</table>';
        $('#product-variant-combinations-inner').html(combinationHtml);
    });

    function extractTagTexts(tagId) {

        // Select the container element
        const container = document.getElementById(tagId);

        // Check if the container exists and has any tags
        if (container) {
        const tags = container.querySelectorAll('.tag');
        
        // If tags are found, process them
        if (tags.length > 0) {
            const tagTexts = [];
            
            // Loop through each tag and get the text content (excluding the "x" span)
            tags.forEach(tag => {
            const tagText = tag.textContent.replace('x', '').trim();
            tagTexts.push(tagText);
            });
            
            //console.log(tagTexts); // Output: array of tag texts
            return tagTexts;
        } else {
            console.log('No tags found.');
        }
        } else {
            console.log('Container not found or empty.');
        }
    }
});
</script>