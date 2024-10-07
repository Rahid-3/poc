<?php
include_once 'model/login_mdl.php';

class login_ctl extends login_mdl
{
	function __construct(){
		if(isset($_REQUEST['action'])){
			$action = $_REQUEST['action'];
			if($action=='admin_login'){
				$this->admin_login();exit;
			}else if($action=='store_manager_password_change'){
				$this->store_manager_password_change();exit;
			}
		}
	}

	public function admin_login(){
		if(isset($_POST['signin_email']) && !empty($_POST['signin_email']) && isset($_POST['signin_password']) && !empty($_POST['signin_password'])){
			$sql = 'SELECT * FROM `admin_master`
			WHERE status="1"
			AND email="'.$_POST['signin_email'].'"
			AND password="'.md5($_POST['signin_password']).'"
			';
			$login_user_data = parent::selectTable_f_mdl($sql);
			if(!empty($login_user_data)){
				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Login success.';
				$_SESSION['login_user_id'] = $login_user_data[0]['id'];
				$_SESSION['login_user_name'] = $login_user_data[0]['first_name'] . ' ' . $login_user_data[0]['last_name'];

				global $site_log_objIndex;
				$site_log_objIndex->insert_log("", "", "Login", "Profile", '', $log_message='Login success', []);
				/*if(isset($_POST['redirect_url']) && !empty($_POST['redirect_url'])){
					header('location:'.$_POST['redirect_url']);
				}else{
					header('location:index.php');
				}*/
				header('location:index.php');
			}else{
				// $siteLog->adminLoginLog($_REQUEST);
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Email or password is wrong.';
				header('location:login.php');
			}
		}else{
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
			header('location:login.php');
		}
	}
	
	public function fetch_store_manager_data($store_owner_manager_master_id, $store_master_id, $email){
		$sql = 'SELECT id FROM `store_owner_manager_master`
		WHERE status=1
		AND email="'.$email.'"
		AND id="'.$store_owner_manager_master_id.'"
		AND store_master_id="'.$store_master_id.'"
		';
		$user_data = parent::selectTable_f_mdl($sql);
		return $user_data;
	}
	public function store_manager_password_change(){
		$sql = 'SELECT id FROM `store_owner_manager_master`
		WHERE status=1
		AND email="'.$_POST['email'].'"
		AND id="'.$_POST['id'].'"
		AND store_master_id="'.$_POST['store_master_id'].'"
		';
		$user_data = parent::selectTable_f_mdl($sql);
		if(!empty($user_data)){
			$somm_update_data = [
				'password' => md5($_POST['password'])
			];
			parent::updateTable_f_mdl('store_owner_manager_master',$somm_update_data,'id="'.$user_data[0]['id'].'"');
			
			$_SESSION['SUCCESS'] = 'TRUE';
			$_SESSION['MESSAGE'] = 'Account is activated. Please login to access you account.';
			header('location:login.php');
		}else{
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
			header('location:login.php');
		}
	}
}