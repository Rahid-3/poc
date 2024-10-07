<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Main Option</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Main Option</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Main Option</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-default btn-xs" id="add_new_btn">Add Main Option</button>
                    <!--<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>-->
                </div>
            </div>
            <div class="card-body">
                <div class="inex_overlay" id="inex_overlay">
                    <i class="inex_overlay_loader fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
                <div>
                    <input type="hidden" id="action" value="get_main_option">
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
                <h4 class="modal-title">Add Main Option</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data"
                    onsubmit="return validateForm();">
                    <input type="hidden" name="action" value="add_mainoption">

                    <!-- Dynamic Options -->
                    <div class="form-group row">
                        <label for="shop_options" class="col-sm-2 col-form-label">Select Shop Option</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="shop_options" id="shop_options">
                                <!-- Options will be dynamically populated here -->
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sit_shop" class="col-sm-2 col-form-label">main option</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="mainoption" id="mainoption">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-info">Add Store</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_shop_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Main Option</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data"
                    onsubmit="return validateForm();">
                    <input type="hidden" name="action" value="edit_mainoption">
                    <input type="hidden" name="edit_id" id="edit_shop_id">

                    <!-- Dynamic Options -->
                    <div class="form-group row">
                        <label for="edit_shop_options" class="col-sm-2 col-form-label">Select Shop Option</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="shop_options" id="edit_shop_options">
                                <!-- Options will be dynamically populated here -->
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_mainoption" class="col-sm-2 col-form-label">Main Option</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="mainoption" id="edit_mainoption">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-info">Update Main Option</button>
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

    function populateShopOptions() {
        $.ajax({
            url: "pages/fetch.php",
            method: 'GET',
            success: function(data) {
                console.log(data);
                const $shopOptions = $('#shop_options');
                $shopOptions.empty();

                data.forEach(function(option) {
                    $shopOptions.append(
                        `<option value="${option.id}">${option.shop}</option>`
                    );
                });

                if (data.length >= 2) {
                    $shopOptions.prop('selectedIndex', 1);
                }
            },

            error: function() {
                toastr.error('Failed to load shop options.');
            }
        });
    }

    // Form validation
    function validateForm() {
        const sitShop = $("#mainoption").val().trim();
        const token = $("#shop_options").val().trim();
        let hasError = false;

        if (!token) {
            toastr.error('Please enter option');
            hasError = true;
        }
        if (!sitShop) {
            toastr.error('Please enter Shop Name');
            hasError = true;
        }

        return !hasError;
    }

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
                    'action': 'delete_main_option',
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
    $(document).on('click', '.edit-shop-btn', function() {
        var id = $(this).data('id');
        var shop = $(this).data('shop');
        var mainOption = $(this).data('mainoption'); // Assuming you have this attribute for the main option

        // Populate the edit modal with the current values
        $('#edit_shop_id').val(id);
        $('#edit_shop_options').val(shop); // Adjust if necessary for select options
        $('#edit_mainoption').val(mainOption);

        // Show the edit modal
        $('#edit_shop_modal').modal('show');
    });
</script>