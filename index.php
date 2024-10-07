<?php

include 'controller/permission_ctl.php';
$permissionCtl = new permission_ctl();
$userPermission = $permissionCtl->permission;

function checkUserPermission($module, $action) {
	global $userPermission;
	if ($action == 'side_bar') {
		if (isset($userPermission[$module]) && !empty($userPermission[$module]) && $userPermission[$module] != 'none') {
			return true;
		} else {
			return false;
		}
	} else if ($action == 'actions') {
		if (isset($userPermission[$module]) && !empty($userPermission[$module]) && $userPermission[$module] == 'write') {
			return true;
		} else {
			return false;
		}

	} else if ($action == 'link') {
		if (in_array($module, ['admin-list', 'module-list'])) {
			$module = 'admin';
		} else if (in_array($module, ['shop_installation'])) {
			$module = 'diamond_shop_installation';
		}
		else if (in_array($module, ['app-logs'])) {
			$module = 'app_logs';
		}
		else if (in_array($module, ['main-option'])) {
			$module = 'main_option';
		}
		else if (in_array($module, ['sub_option'])) {
			$module = 'sub_option';
		}
		if (isset($userPermission[$module]) && !empty($userPermission[$module]) && $userPermission[$module] != 'none') {
			return true;
		} else {
			return false;
		}
	}
}


include 'controller/site_log_ctl.php';
$site_log_objIndex = new site_log_ctl();

include 'controller/index_ctl.php';
$objIndex = new index_ctl();

// include 'controller/rb_index_ctl.php';
// $rb_objIndex = new rb_index_ctl();

// include 'controller/dl_index_ctl.php';
// $dl_objIndex = new dl_index_ctl();

// include 'controller/jl_index_ctl.php';
// $jl_objIndex = new jl_index_ctl();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include 'pages/site-head-tag-links.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include 'pages/site-error-msg.php'; ?>
	<?php include 'pages/site-header.php'; ?>
	<?php include 'pages/site-sidebar.php'; ?>
	<?php (isset($_GET['do']) && file_exists("pages/".$_GET['do'].".php")) ? include("pages/".$_GET['do'].".php") : include("pages/dashboard.php"); ?>
	<?php include 'pages/site-footer.php'; ?>

	<?php include 'pages/site-body-tag-links.php'; ?>
</div>
<!-- ./wrapper -->



</body>
</html>

