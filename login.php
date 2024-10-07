<?php
include 'controller/site_log_ctl.php';
$site_log_objIndex = new site_log_ctl();

include 'controller/login_ctl.php';
$objLogin = new login_ctl();

$redirect_url = '';
if(isset($_SESSION['REDIRECT_URL']) && !empty($_SESSION['REDIRECT_URL'])){
	$redirect_url = $_SESSION['REDIRECT_URL'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>VDB Admin</title>
	<link rel="icon" type="image/x-icon" href="assets/custom/images/vdb-logo.png">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

	<script src="assets/plugins/jquery/jquery.min.js"></script>
	<!-- custom -->
	<link rel="stylesheet" type="text/css" href="assets/custom/bootstrap-toastr/toastr.min.css"/>
	<script src="assets/custom/bootstrap-toastr/toastr.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<img src="assets/custom/images/VDB-LOGO-NEW.png"><br><br>
		<a href=""><b>Bulk product creation tool</a>
	</div>
	<div class="card">
		<div class="card-body login-card-body">
			<p class="login-box-msg">Sign in to start your session</p>

			<form method="post" action="login.php" autocomplete="off" onsubmit="return check_val();">
				<input type="hidden" name="action" value="admin_login">
				<input type="hidden" name="redirect_url" value="<?= $redirect_url ?>">

				<div class="input-group mb-3">
					<input type="email" class="form-control" placeholder="Email" name="signin_email" id="signin_email">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="password" class="form-control" placeholder="Password" name="signin_password" id="signin_password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary btn-block">Sign In</button>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>

<script>
	function check_val(){
		var signin_email = $("#signin_email").val().trim();
		var signin_password = $("#signin_password").val().trim();
		var err = 0;

		if(signin_password==''){
			err++;
			toastr.error('Please enter password.');
		}
		if(signin_email==''){
			err++;
			toastr.error('Please enter email.');
		}

		if(err==0){
			return true;
		}else{
			return false;
		}
	}
</script>

</body>
</html>

