<?php 

$activeAdminCount = $objIndex->activeAdminCount();
$superAdminCount = $objIndex->superAdminCount();
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <!--<div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>-->
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
  
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Admins</h3>
                </div>
            </div>
            <div class="row">
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= (isset($activeAdminCount[0]['active_admin']) ? $activeAdminCount[0]['active_admin'] : 0) ?></h3>
                            <p>Active Admins</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-user"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= (isset($superAdminCount[0]['super_admin']) ? $superAdminCount[0]['super_admin'] : 0) ?></h3>
                            <p>Super Admins</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
           
<!-- 
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Jewelry Loader</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div> -->
                <!-- ./col -->
<!-- 
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Diamond Loader</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div> -->
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div>
    </section>
    <!-- /.content -->
</div>