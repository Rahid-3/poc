<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index.php?do=profile" class="nav-link"><?= @$user_data[0]['first_name']; ?></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index.php?action=admin_logout" class="nav-link">Logout</a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->