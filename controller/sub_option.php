<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sub Option</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Sub Option</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sub Option</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-default btn-xs" id="add_new_btn">Add Sub Option</button>
                    <!--<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>-->
                </div>
            </div>
            <div class="card-body">
                <div class="inex_overlay" id="inex_overlay">
                    <i class="inex_overlay_loader fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
                <div>
                    <input type="hidden" id="action" value="get_sub_option">
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" id="master_div_pagination"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<div class="modal fade" id="add_new_shop_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Sub Option</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data" onsubmit="return validateForm();">
                    <input type="hidden" name="action" value="add_suboption">

                    <!-- Dynamic Options -->
                    <div class="form-group row">
                        <label for="main_options" class="col-sm-2 col-form-label">Select Main Option</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="main_options" id="main_options">
                                <!-- Options will be dynamically populated here -->
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sub_option" class="col-sm-2 col-form-label">Sub Option</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="sub_option" id="sub_option">
                        </div>
                    </div>

                    <!-- Add image input -->
                    <div class="form-group row">
                        <label for="suboption_image" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" name="suboption_image" id="suboption_image">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-info">Add Sub Option</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
<!-- Modal for Adding and Editing Sub Option -->
<div class="modal fade" id="sub_option_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sub Option</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="sub_option_form" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" id="action" value="edit_sub_option">
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="form-group row">
                        <label for="main_options" class="col-sm-2 col-form-label">Select Main Option</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="main_options" id="editmain_options">
                                <!-- Options will be dynamically populated here -->
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sub_option" class="col-sm-2 col-form-label">Sub Option</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="sub_option" id="editsub_option" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="suboption_image" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" name="suboption_image" id="suboption_image">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-info">Save Sub Option</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="assets/custom/inex_datatable.js?v=<?= time() ?>" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
    // $(document).ready(function() {
    //     // Initialize DataTable with AJAX call
    //     $("#master_div_pagination").InexDataTable(
    //         'index.php', // ajax url
    //         '', // csrf_token only in core PHP
    //         ['action'], // IDs whose values you want to send
    //         function() {
    //             $("#inex_overlay").show(); // Show loader
    //         },
    //         function() {
    //             $("#inex_overlay").hide(); // Hide loader
    //         }
    //     );

    //     // Show the Add New Sub Option modal
    //     $("#add_new_btn").click(function() {
    //         $("#add_new_shop_modal").modal('show');
    //         populateMainOptions(); // Populate options when opening the modal
    //     });

    //     function populateShopOptions(selectedShopId = null, isEdit = false) {
    //         $.ajax({
    //             url: "pages/main.php",
    //             method: 'GET',
    //             success: function(data) {
    //                 const $shopOptions = isEdit ? $('#editmain_options') : $('#main_options');
    //                 $shopOptions.empty();

    //                 data.forEach(function(option) {
    //                     const isSelected = option.id == selectedShopId ? 'selected' : '';
    //                     $shopOptions.append(
    //                         `<option value="${option.id}" ${isSelected}>${option.mainoption}</option>`
    //                     );
    //                 });

    //                 // If no shop is selected during add, you can select the first option
    //                 if (!selectedShopId && !isEdit && data.length > 0) {
    //                     $shopOptions.prop('selectedIndex', 0);
    //                 }
    //             },
    //             error: function() {
    //                 toastr.error('Failed to load shop options.');
    //             }
    //         });
    //     }


    //     // Populate Main Options dynamically

    //     // Validate form input
    //     function validateForm() {
    //         const mainOption = $("#main_options").val().trim();
    //         const subOption = $("#sub_option").val().trim();
    //         let hasError = false;

    //         if (!mainOption) {
    //             toastr.error('Please select a Main Option.');
    //             hasError = true;
    //         }
    //         if (!subOption) {
    //             toastr.error('Please enter a Sub Option.');
    //             hasError = true;
    //         }

    //         return !hasError;
    //     }

    //     // Handle form submission
    //     $("form").on('submit', function() {
    //         return validateForma();
    //     });
    //     $("form").on('submit', function() {
    //         return validateForm();
    //     });

    //     $(document).on('click', '.edit-sub-option-btn', function() {
    //         const id = $(this).data('id');
    //         const title = $(this).data('title');
    //         const shopId = $(this).data('shop_id');

    //         // Populate form fields in the edit modal
    //         $("#sub_option_modal #sub_option").val(title);
    //         $("#sub_option_modal #action").val('edit_sub_option');
    //         $("#sub_option_modal #edit_id").val(id);

    //         // Reset image input if needed
    //         $("#sub_option_modal #suboption_image").val('');

    //         // Populate the main options for the edit modal
    //         populateMainOptions(shopId, true, function() {
    //             $("#sub_option_modal").modal('show');
    //         });
    //     });


    //     $(document).on('click', '.edit-shop-btn', function() {
    //     var id = $(this).data('id');
    //     var mainOption = $(this).data('title');

    //     $('#edit_shop_id').val(id);
    //     $('#edit_mainoption').val(mainOption);
    //     $('#edit_mainoption').val(mainOption);

        

    //     // Populate the shop options for the edit modal
    //     populateShopOptions(shopId, true);

    //     setTimeout(function() {
    //         $('#edit_shop_modal').modal('show');
    //     }, 300); // Adjust delay as necessary
    // });

      

        // Handle deleting a sub-option
        // $(document).on('click', '.delete-shop-btn', function() {
        //     const result = confirm("Do you want to delete this?");
        //     if (result) {
        //         const id = $(this).data('id');
        //         $.ajax({
        //             url: '',
        //             method: 'post',
        //             data: {
        //                 'action': 'delete_sub_option',
        //                 'id': id
        //             },
        //             success: function(result) {
        //                 const obj = JSON.parse(result);
        //                 if (obj.SUCCESS === 'TRUE') {
        //                     toastr.success(obj.MESSAGE);
        //                 } else {
        //                     toastr.error(obj.MESSAGE);
        //                 }
        //                 call_list(); // Refresh the list
        //             }
        //         });
        //     }
        // });

    // Populate main options function, used for both add and edit modals


    $(document).ready(function() {
        $("#master_div_pagination").InexDataTable(
            'index.php', // ajax url
            '', // csrf_token only in laravel. set blank in core
            ['action'], //this is array of all ids, whose values you want to send
            function() {
                //function call before ajax call
                $("#inex_overlay").show();
            },
            function() {
                //function call after ajax responce
                $("#inex_overlay").hide();
            }
        );
    });
    $("#add_new_btn").click(function() {
        $("#add_new_shop_modal").modal('show');
        populateShopOptions(); // Function to populate the select options
    });

    function populateShopOptions(selectedShopId = null, isEdit = false) {
        $.ajax({
            url: "pages/main.php",
            method: 'GET',
            success: function(data) {
                const $shopOptions = isEdit ? $('#editmain_options') : $('#main_options');
                $shopOptions.empty();

                data.forEach(function(option) {
                    const isSelected = option.id == selectedShopId ? 'selected' : '';
                    $shopOptions.append(
                        `<option value="${option.id}" ${isSelected}>${option.mainoption}</option>`
                    );
                });

                // If no shop is selected during add, you can select the first option
                if (!selectedShopId && !isEdit && data.length > 0) {
                    $shopOptions.prop('selectedIndex', 0);
                }
            },
            error: function() {
                toastr.error('Failed to load shop options.');
            }
        });
    }


    // Form validation
    function validateForm() {
        const mainOption = $("#main_options").val().trim();
        const shopOption = $("#sub_option").val().trim();
        let hasError = false;

        if (!shopOption) {
            toastr.error('Please select a Shop Option.');
            hasError = true;
        }
        if (!mainOption) {
            toastr.error('Please enter the Main Option.');
            hasError = true;
        }

        return !hasError;
    }




    $("form").on('submit', function() {
        return validateForma();
    });
    $("form").on('submit', function() {
        return validateForm();
    });

    $(document).on('click', '.delete-shop-btn', function() {
        var result = confirm("Do want to delete this?");
        if (result) {
            //Logic to delete the item

            let id = $(this).data('id');
            $.ajax({
                url: '',
                method: 'post',
                data: {
                    'action': 'delete_sub_option',
                    'id': id
                },
                success: function(result) {
                    var obj = JSON.parse(result);
                    if (obj.SUCCESS == 'TRUE') {
                        toastr.success(obj.MESSAGE);
                    } else {
                        toastr.error(obj.MESSAGE);
                    }
                    call_list();
                }
            });
        }
    });
    $(document).on('click', '.edit-sub-option-btn', function() {
        var  id = $(this).data('id');
        var shopId = $(this).data('mainoption');
        var title = $(this).data('title');;

        $('#edit_id').val(id);
        $('#editsub_option').val(title);


        // Populate the shop options for the edit modal
        populateShopOptions(shopId, true);

        setTimeout(function() {
            $('#sub_option_modal').modal('show');
        }, 300); // Adjust delay as necessary
    });
</script>