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
               <div id="master_div_product">
                  <div class="card-body">
                     <div class="form-group row">
                        <label for="pro_shop" class="col-sm-2 col-form-label">Shop</label>
                        <div class="col-sm-10" id="allshoplist"></div>
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
                     <div class="form-group row">
                        <label for="pro_status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                           <select class="form-control" name="pro_status" id="pro_status">
                                <option value="DRAFT">Draft</option>
                                <option value="ACTIVE">Active</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="pro_type" class="col-sm-2 col-form-label">Product Type</label>
                        <div class="col-sm-10">
                           <input type="text" class="form-control" name="pro_type" id="pro_type" placeholder="Product Type">
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="pro_vender" class="col-sm-2 col-form-label">Product Vender</label>
                        <div class="col-sm-10">
                           <input type="text" class="form-control" name="pro_vender" id="pro_vendor" placeholder="Vender">
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="pro_tag" class="col-sm-2 col-form-label">Product Tag</label>
                        <div class="col-sm-10">
                           <input type="text" class="form-control" name="pro_tag" id="pro_tag" placeholder="Product Tag">
                           <div id="tagsContainers"></div>
                        </div>
                     </div>
                     <div class="form-group row" id="alert" style="color:red;display:none;font-size:16px;font-weight:bold;margin-bottom: 3px;">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                           <div id="alert1">The limit is 2000 product variant combinations. You cannot add more tags.</div>
                        </div>
                     </div>
                     <div id="variant-container">
                        <!-- <div class="form-group row variant-group" id="variant-1">
                           <label for="tags" class="col-sm-2 col-form-label">Product Variant 1</label>
                           <div class="col-sm-10">
                              <input type="text" class="form-control mb-1" name="pro_nm_opt1" id="pro_nm_opt1" placeholder="Product Option Name 1" autocomplete="off">
                              <div class="tags-input-container" id="tags-input-container1">
                                 <input type="text" class="form-control" id="tag-input1" placeholder="Add tags..." autocomplete="off">
                              </div>
                           </div>
                        </div> -->
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
                        <!-- <div class="row">
                           <div class="col-sm-2"></div>
                           <div class="col-sm-10" id="product-variant-combinations-inner1"></div>
                        </div> -->
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
    const tagsInputs = document.getElementById('pro_tag');
const tagsContainers = document.getElementById('tagsContainers');

// Function to create a tag
function createTags(tagText) {
    const tagsElements = document.createElement('span');
    tagsElements.classList.add('tagpro');
    tagsElements.textContent = tagText;

    const deleteButton = document.createElement('button');
    deleteButton.classList.add('delete-button');
    deleteButton.textContent = 'x';
    deleteButton.addEventListener('click', () => {
        tagsElements.remove();
    });

    tagsElements.appendChild(deleteButton);
    tagsContainers.appendChild(tagsElements);
}

// Function to check if the tag already exists
function TagExists(tagText) {
    const existingTags = tagsContainers.getElementsByClassName('tagpro');
    for (let i = 0; i < existingTags.length; i++) {
        const existingTagText = existingTags[i].firstChild.textContent.trim(); // Only get the tag's text
        if (existingTagText === tagText) {
            return true; // Tag already exists
        }
    }
    return false; // Tag does not exist
}

// Event listener for keydown on the tag input
tagsInputs.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' || event.key === ',') {
        event.preventDefault(); // Prevent default form submission behavior
        const tagText = tagsInputs.value.trim();
        if (tagText !== '' && !TagExists(tagText)) {
            createTags(tagText);
            tagsInputs.value = ''; // Clear input field
        } else if (tagText === '') {
            alert('Please enter a tag.'); // Optional alert for empty input
        } else {
            alert('This tag already exists.'); // Optional alert for duplicate tag
        }
    }
});
});
</script>
<script>
   $(document).ready(function() {
       let variantCount = 0;
       let tagCounts = {}; // Store the count of tags per variant
    let limitCount = 2000;
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

        if(tagInput){
               tagInput.addEventListener('keydown', function(e) {
               if ((e.key === 'Enter' || e.key === ',') && checkTagLimit()) {
                   const tag = tagInput.value.trim().replace(/,$/, '');
                   addTag(tag);
                   e.preventDefault();
               }
           });
        }
       }
   
       function updateTagCount(variantId, count) {
           tagCounts[variantId] = count;
           const totalProductVariants = calculateTotalProductVariants();
   
           if (totalProductVariants > limitCount) {
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
           if (totalProductVariants >= limitCount) {
               alert('The limit is 2000 product variant combinations. You cannot add more tags.');
               disableTagInputs();
               return false;
           }
           return true;
       }
   
       /*
       // this code is working fine for adding varins tags
       $(document).on('click', '#add-variant-btn', function() {
           if (variantCount >= 3) {
               alert('You can add up to 3 variants only.');
               $("#add-variant-btn").attr('disabled', true);
               return;
           }
   
           variantCount++;
           const newVariant = `
               <div class="form-group row variant-group" id="variant-${variantCount}">
                   <label for="tags" class="col-sm-2 col-form-label">Product Variant Option ${variantCount}</label>
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
       */

     
       // Event handler for adding a new variant
        $(document).on('click', '#add-variant-btn', function() {
            if (variantCount >= 3) {
                alert('You can add up to 3 variants only.');
                $("#add-variant-btn").attr('disabled', true);
                return;
            }

            variantCount++;
            const newVariant = `
                <div class="form-group row variant-group" id="variant-${variantCount}">
                    <label for="pro_nm_opt${variantCount}" class="col-sm-2 col-form-label">Product Variant Option ${variantCount}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control mb-1" name="pro_nm_opt${variantCount}" id="pro_nm_opt${variantCount}" placeholder="Product Option Name ${variantCount}" autocomplete="off">
                        <div class="tags-input-container" id="tags-input-container${variantCount}">
                            <input type="text" class="form-control" id="tag-input${variantCount}" placeholder="Add tags..." autocomplete="off">
                        </div>
                        <button type="button" class="btn btn-danger remove-variant-btn" data-variant-id="${variantCount}">Close</button>
                    </div>
                </div>
            `;
            $('#variant-container').append(newVariant);

            // Initialize the new tag input for this variant
            initTagInput(`tag-input${variantCount}`, `tags-input-container${variantCount}`, variantCount);
        });

        // Event handler for removing a variant
        $(document).on('click', '.remove-variant-btn', function() {
            const variantId = $(this).data('variant-id');
            
            // Ask for confirmation
            const confirmDelete = confirm("Are you sure you want to delete this variant?");
            
            if (confirmDelete) {
                // Proceed with deletion if the user confirms
                $(`#variant-${variantId}`).remove();
                variantCount--; // Decrease the count as a variant is removed

                // Optionally, enable the add button if the count is below 3
                if (variantCount < 3) {
                    $("#add-variant-btn").attr('disabled', false);
                }

                // Re-sequence the remaining variants
                reindexVariants();
            } else {
                // Do nothing if the user cancels the action
                return false;
            }
        });

        // Function to reindex the remaining variants
        function reindexVariants() {
            let index = 1;
            // Iterate over each remaining variant and update their attributes
            $('.variant-group').each(function() {
                // Update the variant group ID
                $(this).attr('id', `variant-${index}`);
                
                // Update the label for the variant option
                $(this).find('label').attr('for', `pro_nm_opt${index}`).text(`Product Variant Option ${index}`);
                
                // Update the variant option input field
                $(this).find('input[type="text"].form-control.mb-1').attr('name', `pro_nm_opt${index}`).attr('id', `pro_nm_opt${index}`).attr('placeholder', `Product Option Name ${index}`);
                
                // Update the tags input container and input field
                $(this).find('.tags-input-container').attr('id', `tags-input-container${index}`);
                $(this).find('input.form-control:not(.mb-1)').attr('id', `tag-input${index}`);
                
                // Update the close button data-variant-id attribute
                $(this).find('.remove-variant-btn').attr('data-variant-id', index);

                // Re-initialize the tag input for the renumbered variant
                initTagInput(`tag-input${index}`, `tags-input-container${index}`, index);

                index++;
            });
            
        }

       

   
       // Initialize first variant tag input
       //initTagInput('tag-input1', 'tags-input-container1', 1);
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
   
   // Function to filter combinations by a given size
   function filterCombinationsBySize(combinations, sizeIndex, sizeValue) {
       return combinations.filter(combination => combination[sizeIndex] === sizeValue);
   }
   
   // Handle Add Product Button
   $(document).on('click', '#add_product_btn', function() {
       var productShop = $('#pro_shop').val();
       var productTitle = $('#pro_title').val();
       var productDesc = $('#pro_desc').val();
       var productStatus = $('#pro_status').val();
       var productType = $('#pro_type').val();
       var productVender = $('#pro_vendor').val();
       var productVarOpt1 = $('#pro_nm_opt1').val();
       var productVarOpt2 = $('#pro_nm_opt2').val();
       var productVarOpt3 = $('#pro_nm_opt3').val();

       var tgs = extractTagTexts('tagsContainers', '.tagpro') || [];
       console.log("This is the TAG: " + tgs);

       // Generate variant combinations
       var variant1 = extractTagTexts('tags-input-container1', '.tag') || []; // Sizes (e.g., M, L, S, XL)
       var variant2 = extractTagTexts('tags-input-container2', '.tag') || []; // Colors
       var variant3 = extractTagTexts('tags-input-container3', '.tag') || []; // Materials or any other variant

       console.log("This is the Array of the Size: " + variant1);

        productTitle.trim();
        if(productShop == "" && productTitle == ""){
            alert("Select the Shop and Product Title");
            return false;
        }
        
        // // Variant Option 1 and Its Tags Validation
        // if(variant1.length > 0){
        //     //productVarOpt1.trim();
        //     productVarOpt1 = productVarOpt1.trim();
        //     if(productVarOpt1 == ""){
        //         alert("Variant Option 1: Name is Required");
        //         return false;
        //     }
        // }
        //console.log("Option 1 varibale Rahid " + productVarOpt1);
        
        // if(productVarOpt1 == undefined){
        //     alert("Click on Add New Variant Button and Add the variant");
        //     return false;
        // }

        const variantContainer = document.getElementById('variant-container');

        // Count the number of child divs with the class 'variant-group' inside the parent container
        const variantCount = variantContainer.querySelectorAll('.variant-group').length;
        if(variantCount == 0){
            alert("Click on Add New Variant Button and Add the variant");
            return false;
        }
        // Log the count to the console
        console.log('Number of variant groups:', variantCount);

        // Variant Option 1 and Its Tags Validation
        if (productVarOpt1 != undefined) {
            // Check if productVarOpt1 is empty and variant1 is an empty array
            if (productVarOpt1.trim() === "" && Array.isArray(variant1) && variant1.length === 0) {
                alert("Product Variant Option 1: Name and Tag are required.");
                return false;
            }

            //Check if variant1 is an empty array
            if (Array.isArray(variant1) && variant1.length === 0) {
                alert("Please create a tag for Product Variant Option 1.");
                return false;
            }

            if(variant1.length > 0){
            //productVarOpt1.trim();
                productVarOpt1 = productVarOpt1.trim();
                if(productVarOpt1 == ""){
                    alert("Variant Option 1: Name is Required");
                    return false;
                }
            }
        }

        // Variant Option 2 and Its Tags Validation
        if (productVarOpt2 != undefined) {
            // Check if productVarOpt1 is empty and variant1 is an empty array
            if (productVarOpt2.trim() === "" && Array.isArray(variant2) && variant2.length === 0) {
                alert("Product Variant Option 2: Name and Tag are required.");
                return false;
            }

            //Check if variant1 is an empty array
            if (Array.isArray(variant2) && variant2.length === 0) {
                alert("Please create a tag for Product Variant Option 2.");
                return false;
            }

            if(variant2.length > 0){
            //productVarOpt1.trim();
                productVarOpt2 = productVarOpt2.trim();
                if(productVarOpt2 == ""){
                    alert("Variant Option 2: Name is Required");
                    return false;
                }
            }
        }

        // Variant Option 3 and Its Tags Validation
        if (productVarOpt3 != undefined) {
            // Check if productVarOpt1 is empty and variant1 is an empty array
            if (productVarOpt3.trim() === "" && Array.isArray(variant3) && variant3.length === 0) {
                alert("Product Variant Option 3: Name and Tag are required.");
                return false;
            }

            //Check if variant1 is an empty array
            if (Array.isArray(variant3) && variant3.length === 0) {
                alert("Please create a tag for Product Variant Option 3.");
                return false;
            }

            if(variant3.length > 0){
            //productVarOpt1.trim();
                productVarOpt3 = productVarOpt3.trim();
                if(productVarOpt3 == ""){
                    alert("Variant Option 3: Name is Required");
                    return false;
                }
            }
        }

        if(productVarOpt1 != undefined && productVarOpt2 != undefined){
            // Check if all three inputs have the same value
            // var opt1 = productVarOpt1.trim();
            // var opt2 = productVarOpt2.trim();
            if (productVarOpt1 === productVarOpt2) {
                alert("You've already used the option name: " + productVarOpt1);
                return false;
            }
        }

        if(productVarOpt1 !== undefined && productVarOpt2 !== undefined && productVarOpt3 !== undefined){
            // Trim and convert values to ensure consistent comparison
            var opt1 = productVarOpt1.trim();
            var opt2 = productVarOpt2.trim();
            var opt3 = productVarOpt3.trim();

            // Check if all three inputs have the same value
            if (opt1 === opt3) {
                alert("You've already used the option name: " + opt1);
                return false;
            }
            // Check if all three inputs have the same value
            if (opt2 === opt3) {
                alert("You've already used the option name: " + opt2);
                return false;
            }
        }
        
        
       // Filter out undefined or empty arrays (arrays with length 0)
       var allVariants = [variant1, variant2, variant3].filter(arr => Array.isArray(arr) && arr.length > 0);
   
       console.log(allVariants);
   
       var variantCombinations = generateCombinations(allVariants);
   
       // Display combinations even if size is not provided
        var combinationHtml = `<form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data" id="productForm">`;
        combinationHtml += `<table class="table table-borderless"><input type="hidden" name="action" value="add_product">`;
        combinationHtml += `<tr>`;
        combinationHtml += `<td colspan="2"><h3>Generated Product Variants for ${productShop}</h3></td>`;
        combinationHtml += '</tr>';

        combinationHtml += `<tr>`;
        combinationHtml += `<td colspan="2"><input type="hidden" name="product_Shop" value="${productShop}"/>Shop: ${productShop}</td>`;
        combinationHtml += '</tr>';

        combinationHtml += `<tr>`;
        combinationHtml += `<td colspan="2"><input type="hidden" name="product_title" value="${productTitle}"/>Product Title: ${productTitle}</td>`;
        combinationHtml += '</tr>';

        if (productDesc != "") {
            combinationHtml += `<tr>`;
            combinationHtml += `<td colspan="2"><input type="hidden" name="product_desc" value="${productDesc}"/>Product Description: ${productDesc}</td>`;
            combinationHtml += `</tr>`;
        }
        if (productStatus != "") {
            combinationHtml += `<tr>`;
            combinationHtml += `<td colspan="2"><input type="hidden" name="product_status" value="${productStatus}"/>Product Status: ${productStatus}</td>`;
            combinationHtml += `</tr>`;
        }
        if (productType != "") {
            combinationHtml += `<tr>`;
            combinationHtml += `<td colspan="2"><input type="hidden" name="product_type" value="${productType}"/>Product Type: ${productType}</td>`;
            combinationHtml += `</tr>`;
        }
        if (productVender != "") {
            combinationHtml += `<tr>`;
            combinationHtml += `<td colspan="2"><input type="hidden" name="product_vendor" value="${productVender}"/>Product Vender: ${productVender}</td>`;
            combinationHtml += `</tr>`;
        }
        if (tgs.length > 0) {
            combinationHtml += `<tr>`;
            combinationHtml += `<td colspan="2"><input type="hidden" name="product_tgs" value="${tgs.join(', ')}"/>Tags: ${tgs.join(', ')}</td>`;
            combinationHtml += `</tr>`;
        }

        if (productVarOpt1 != "" && productVarOpt1 != undefined) {
            combinationHtml += `<tr>`;
            combinationHtml += `<td colspan="2"><input type="hidden" name="product_VarOpt1" value="${productVarOpt1}"/>Product Option: ${productVarOpt1}</td>`;
            combinationHtml += `</tr>`;
        }

        if (productVarOpt2 != "" && productVarOpt2 != undefined) {
            combinationHtml += `<tr>`;
            combinationHtml += `<td colspan="2"><input type="hidden" name="product_VarOpt2" value="${productVarOpt2}"/>Product Option: ${productVarOpt2}</td>`;
            combinationHtml += `</tr>`;
        }

        if (productVarOpt3 != "" && productVarOpt3 != undefined) {
            combinationHtml += `<tr>`;
            combinationHtml += `<td colspan="2"><input type="hidden" name="product_VarOpt3" value="${productVarOpt3}"/>Product Option: ${productVarOpt3}</td>`;
            combinationHtml += `</tr>`;
        }

        // If variant1 (Size Array) has values, create combinations with size headings
        if (variant1.length > 0) {
            variant1.forEach(size => {
                // Filter combinations for the current size
                let filteredCombinations = filterCombinationsBySize(variantCombinations, 0, size);

                // Add a toggle button and container for the size combinations
                combinationHtml += `<tr><td colspan="2"><h4 class="toggle-size" style="cursor:pointer;">Size: ${size} Click to Expand all/Collapse all)</h4></td></tr>`;
                combinationHtml += `<tr class="combination-row"><td colspan="2" style="border:none;"><div class="size-combinations" style="display:none;">`; // Container to toggle

                filteredCombinations.forEach(combination => {
                    combinationHtml += `<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">`;
                    combinationHtml += `<div class="form-group row"><div class="col-sm-2 col-form-label"><span><input type="hidden" name="variat-title[]" value="${combination.join(' / ')}">${combination.join(' / ')}</span></div>`;
                    combinationHtml += `<div class="col-sm-10"><input type='text' name='variat-price[]' value='' placeholder="price" class="price-input"></div></div>`;
                    combinationHtml += `</div></div>`;
                });

                combinationHtml += `</div></td></tr>`; // Close the toggle container
            });
        } else {
            if (variant2.length > 0 || variant3.length > 0) {
                // If no sizes are added, just display the combinations without size headings
                variantCombinations.forEach(combination => {
                    combinationHtml += `<tr>`;
                    combinationHtml += `<td><input type="hidden" name="variat-title[]" value="${combination.join(' / ')}">${combination.join(' / ')}</td>`;
                    combinationHtml += `<td><input type='text' name='variat-price[]' value='' placeholder="price" class="price-input"></td>`;
                    combinationHtml += `</tr>`;
                });
            }
        }

        combinationHtml += `<tr>`;
        combinationHtml += `<td><button type="submit" id="save_product_btn" class="btn btn-info save_product_btn">Save Product</button></td>`;
        combinationHtml += `</tr>`;
        combinationHtml += '</table></form>';

        $('#product-variant-combinations-inner').html(combinationHtml);

        // Add validation for price fields
        $('#productForm').on('submit', function(e) {
            var valid = true;
            $('.price-input').each(function() {
                if ($(this).val() === '') {
                    alert('Please enter a price for all product variants.');
                    valid = false;
                    return false;  // Exit the loop once an empty field is found
                }
            });

            if (!valid) {
                e.preventDefault();  // Prevent form submission if validation fails
            }
        });

   });
   
   // Add toggle functionality for size headings
   $(document).on('click', '.toggle-size', function() {
       console.log('clicked');
       // Find the corresponding .size-combinations div for the clicked size
       $(this).closest('tr').next('tr').find('.size-combinations').slideToggle();
   });
   

});
function extractTagTexts(tagId, tg) {
       // Select the container element
       const container = document.getElementById(tagId);
   
       // Check if the container exists and has any tags
       if (container) {
           //const tags = container.querySelectorAll('.tag');
           const tags = container.querySelectorAll(tg);
           
           // If tags are found, process them
           if (tags.length > 0) {
               const tagTexts = [];
               
               // Loop through each tag and get the text content (excluding the "x" span)
               tags.forEach(tag => {
                   const tagText = tag.textContent.replace('x', '').trim();
                   tagTexts.push(tagText);
               });
               
               return tagTexts;
           } else {
               console.log('No tags found.');
               return [];
           }
       } else {
           console.log('Container not found or empty.');
           return [];
       }
   }
</script>
<script>
    $(document).ready(function() {
        getProductList();
    });

    function getProductList(){
        $.ajax({
            url: 'index.php',
            method: 'GET',
            data: {
                'action': 'get_product_shop'
            },
            success: function(result) {
                let obj = JSON.parse(result);
                //console.log(obj);
                $("#allshoplist").html(obj);
                //Find Last ID
                if(result.length > 0){
                    
                }
                // End Find Last ID
            }
        });
    }
</script>
<script>

 // Get references to the input field, select dropdown, and the save button

 setTimeout(function() {
    const inputField = document.getElementById('pro_title');
    const selectField = document.getElementById('pro_shop');
    const saveBtn = document.getElementById('add_product_btn');

    // Ensure all elements are correctly fetched before proceeding
    if (!inputField || !selectField || !saveBtn) {
        console.error("One or more elements are not found in the DOM. Please check your HTML IDs.");
        return;
    }

    // Function to check both input field and select dropdown
    function toggleSaveButton() {
        if (inputField.value.trim() !== "" && selectField.value !== "") {
            saveBtn.disabled = false;
        } else {
            saveBtn.disabled = true;
        }
    }

    // Add event listeners to both the input field and select dropdown
    inputField.addEventListener('input', toggleSaveButton);
    selectField.addEventListener('change', toggleSaveButton);

}, 1000); // Delay the execution by 500ms (half a second)

</script>
