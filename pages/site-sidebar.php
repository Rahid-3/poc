<?php
$loginUserName = $_SESSION['login_user_name'] ?? 'VDB Admin';
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="assets/custom/images/vdb-logo.png"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo ucwords($loginUserName); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                       with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="index.php?do=dashboard" class="nav-link li_site_menu_item" data-page="dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?do=profile" class="nav-link li_site_menu_item" data-page="profile">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?do=app-logs" class="nav-link li_site_menu_item" data-page="app-logs">
                        <i class="nav-icon fas fa-list"></i>
                        <p>App Logs</p>
                    </a>
                </li>
                <?php
                if ($user_data[0]['is_super_admin']) {
                    if (checkUserPermission('admin', 'side_bar')) { ?>
                        <li class="nav-item">
                            <a href="index.php?do=admin-list" class="nav-link li_site_menu_item" data-page="admin-list">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Admin </p>
                            </a>
                        </li>
                <?php }
                } ?>

                <li class="nav-item">
                    <a href="index.php?do=shop_installation" 
                    class="nav-link li_site_menu_item" data-page="shop_installation">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Shop Installation</p>
                    </a>
                </li>
<!-- Start Comment by R Dev
                <li class="nav-item">
                    <a href="index.php?do=main-option" class="nav-link li_site_menu_item" 
                    data-page="main-option">
                    <i class="nav-icon fas fa-list"></i>            
                                <p>Main option</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?do=sub_option" class="nav-link li_site_menu_item" data-page="sub_option">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Sub option</p>
                    </a>
                </li>
               End Comment by R Dev  -->
               <?php if (checkUserPermission('product', 'side_bar')) { ?>
                <li class="nav-item">
                    <a href="index.php?do=product" class="nav-link li_site_menu_item" data-page="product,addproduct,productvariant">
                     <i class="nav-icon fas fa-list"></i>                   
                          <p>Product</p>
                    </a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="index.php?action=admin_logout" class="nav-link li_site_menu_item" data-page="logout">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script>
    var current_do = '<?php echo isset($_GET['do']) ? $_GET['do'] : "dashboard" ?>';
    $(".li_site_menu_item").removeClass('active');
    $(".li_site_menu_item").each(function(k, v) {
        var _this = $(this);
        var page_arr = _this.data('page').split(',');
        if (page_arr.includes(current_do)) {
            _this.addClass('active');
        }
    });
</script>