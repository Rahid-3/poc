<?php
include_once 'model/index_mdl.php';

class index_ctl extends index_mdl
{
	private static $site_log;

	function __construct()
	{
		global $site_log_objIndex;
		self::$site_log = $site_log_objIndex;

		//first we check user login or not, otherwise redirect to login page
		global $user_data;
		if (isset($_SESSION['login_user_id']) && !empty($_SESSION['login_user_id'])) {
			$user_data = $this->check_user_by_id($_SESSION['login_user_id']);
			if (isset($_REQUEST['do']) && !empty($_REQUEST['do']) && !in_array($_REQUEST['do'], ['dashboard', 'profile']) && !checkUserPermission($_REQUEST['do'], 'link')) {
				header('location:index.php?do=dashboard');
				exit;
			}
		} else {
			//below code is set query param in redirect-url. $_SERVER['QUERY_STRING'] is not working due to some reason.
			$qs = '';
			if (isset($_GET) && !empty($_GET)) {
				foreach ($_GET as $k => $v) {
					$qs .= $k . '=' . $v . '&';
				}
			}
			$qs = trim($qs, '&');

			$_SESSION['REDIRECT_URL'] = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . ($qs != '' ? '?' . $qs : '');

			header('location:login.php');
			exit;
		}
		if (isset($_REQUEST['action'])) {
			$action = $_REQUEST['action'];
			if ($action == 'edit_profile_personal_details_post') {
				$this->edit_profile_personal_details_post();
				exit;
			} else if ($action == 'edit_profile_change_password_post') {
				$this->edit_profile_change_password_post();
				exit;
			} else if ($action == 'admin_logout') {
				$this->admin_logout();
				exit;
			} else if ($action == 'get_shop_installation_list_post') {
				$this->get_shop_installation_list_post();
				exit;
			} else if ($action == 'get_main_option') {
				$this->get_main_option();
				exit;
			} else if ($action == 'add_mainoption') {
				$this->add_mainoption();
				exit;
			} else if ($action == 'add_suboption') {
				$this->add_suboption();
				exit;
			} else if ($action == 'get_sub_option') {
				$this->get_sub_option();
				exit;
			} else if ($action == 'add_new_shop_install_token_post') {
				$this->add_new_shop_install_token_post();
				exit;
			} else if ($action == 'delete_shop_install_token_post') {
				$this->delete_shop_install_token_post();
				exit;
			} else if ($action == 'delete_main_option') {
				$this->delete_main_option();
				exit;
			} else if ($action == 'delete_sub_option') {
				$this->delete_sub_option();
				exit;
			} else if ($action == 'edit_shop_install_token_post') {
				$this->edit_shop_install_token_post();
				exit;
			} else if ($action == 'edit_mainoption') {
				$this->edit_mainoption();
				exit;
			} else if ($action == 'edit_sub_option') {
				$this->edit_sub_option();
				exit;
			} else if ($action == 'get_page_permission_list_post') {
				$this->get_page_permission_list_post();
				exit;
			} else if ($action == 'change_permission_status') {
				$this->change_permission_status();
				exit;
			} else if ($action == 'edit_shop_app_labels_post') {
				$this->edit_shop_app_labels_post();
				exit;
			} else if ($action == 'edit_shop_details') {
				$this->edit_shop_details();
				exit;
			} else if ($action == 'get_language_list_post') {
				$this->get_language_list_post();
				exit;
			} else if ($action == 'change_language_status') {
				$this->change_language_status();
				exit;
			} else if ($action == 'add_new_language_post') {
				$this->add_new_language_post();
				exit;
			} else if ($action == 'get_label_list_post') {
				$this->get_label_list_post();
				exit;
			} else if ($action == 'language_label_text_post') {
				$this->language_label_text_post();
				exit;
			}
			 else if ($action == 'get_admin_list_post') {
				$this->get_admin_list_post();
			} else if ($action == 'get_module_list_post') {
				$this->get_module_list_post();
			} else if ($action == "update_permission") {
				$this->update_permission();
			} else if ($action == 'add_admin_post') {
				$this->add_admin_post();
				exit;
			} else if ($action == 'delete_admin') {
				$this->delete_admin();
				exit;
			} else if ($action == 'select_admin') {
				$this->select_admin();
				exit;
			} else if ($action == 'superadmin_status') {
				$this->superadmin_status();
				exit;
			} else if ($action == "status") {
				$this->change_status();
				exit;
			} 
		}
	}

	public function admin_logout()
	{
		$login_user_id = @$_SESSION['login_user_id'];
		if (isset($_SESSION['login_user_id'])) {
			unset($_SESSION['login_user_id']);
		}
		if (isset($_SESSION['login_store_manager_id'])) {
			unset($_SESSION['login_store_manager_id']);
		};
		if (isset($_SESSION['login_store_master_id'])) {
			unset($_SESSION['login_store_master_id']);
		}

		self::$site_log->insert_log("", "", "Logout", "Profile", '', 'Successfully Logout.', $_SESSION, $login_user_id);

		session_destroy();

		$_SESSION['SUCCESS'] = 'TRUE';
		$_SESSION['MESSAGE'] = 'Successfully Logout.';
		header('location:login.php');
	}
	public function check_user_by_id($id)
	{
		$sql = 'SELECT * FROM `admin_master` WHERE status="1" AND id="' . $id . '"';
		$user_data = parent::selectTable_f_mdl($sql);
		if (isset($user_data) && !empty($user_data)) {
			$_SESSION['login_user_id'] = $user_data[0]['id'];
			return $user_data;
		} else {
			session_destroy();
			header('location:login.php');
		}
	}

	public function edit_profile_personal_details_post()
	{
		$login_user_id = $_SESSION['login_user_id'];
		//check email exist or not
		$sql = 'SELECT id FROM `admin_master` WHERE email="' . trim($_POST['email']) . '" AND id!="' . $login_user_id . '"';
		$email_exist = parent::selectTable_f_mdl($sql);
		if (!empty($email_exist)) {
			self::$site_log->insert_log("", "", "Update", "Profile", 'id="' . $login_user_id . '"', 'Email is already existed.', [trim($_POST['email'])]);

			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Email is already existed.';
		} else {
			$update_data = [
				'first_name' => trim($_POST['first_name']),
				'last_name' => trim($_POST['last_name']),
				'email' => trim($_POST['email'])
			];
			parent::updateTable_f_mdl('admin_master', $update_data, 'id="' . $login_user_id . '"');
			self::$site_log->insert_log("", "", "Update", "Profile", 'id="' . $login_user_id . '"', 'Profile updated successfully.', $update_data);

			$_SESSION['SUCCESS'] = 'TRUE';
			$_SESSION['MESSAGE'] = 'Profile updated successfully.';
		}

		header('location:index.php?do=profile');
	}
	public function edit_profile_change_password_post()
	{
		$login_user_id = $_SESSION['login_user_id'];

		$update_data = [
			'password' => md5(trim($_POST['password']))
		];
		parent::updateTable_f_mdl('admin_master', $update_data, 'id="' . $login_user_id . '"');
		self::$site_log->insert_log("", "", "Update", "Profile Password", 'id="' . $login_user_id . '"', 'Password changed successfully.', $update_data);

		$_SESSION['SUCCESS'] = 'TRUE';
		$_SESSION['MESSAGE'] = 'Password changed successfully.';

		header('location:index.php?do=profile');
	}

	public function get_shop_installation_list_post()
	{
		//fixed, no change for any module
		$record_count = 0;
		$page = 0;
		$current_page = 1;
		$rows = '10';
		$keyword = '';
		if ((isset($_REQUEST['rows'])) && (!empty($_REQUEST['rows']))) {
			$rows = $_REQUEST['rows'];
		}
		if ((isset($_REQUEST['keyword'])) && (!empty($_REQUEST['keyword']))) {
			$keyword = $_REQUEST['keyword'];
		}
		if ((isset($_REQUEST['current_page'])) && (!empty($_REQUEST['current_page']))) {
			$current_page = $_REQUEST['current_page'];
		}
		$start = ($current_page - 1) * $rows;
		$end = $rows;
		$sort_field = '';
		if (isset($_POST['sort_field']) && !empty($_POST['sort_field'])) {
			$sort_field = $_POST['sort_field'];
		}
		$sort_type = '';
		if (isset($_POST['sort_type']) && !empty($_POST['sort_type'])) {
			$sort_type = $_POST['sort_type'];
		}
		//end fixed, no change for any module

		$cond_keyword = '';
		if (isset($keyword) && !empty($keyword)) {
			$cond_keyword = "AND (
					shop LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY id DESC';
		if (!empty($sort_field)) {
			$cond_order = 'ORDER BY ' . $sort_field . ' ' . $sort_type;
		}

		$sql = "
                SELECT count(id) as count
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1 = "
                SELECT id, shop, install_token, add_date
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::selectTable_f_mdl($sql1);

		if ((isset($all_count[0]['count'])) && (!empty($all_count[0]['count']))) {
			$record_count = $all_count[0]['count'];
			$page = $record_count / $rows;
			$page = ceil($page);
		}
		$sr_start = 0;
		if ($record_count >= 1) {
			$sr_start = (($current_page - 1) * $rows) + 1;
		}
		$sr_end = ($current_page) * $rows;
		if ($record_count <= $sr_end) {
			$sr_end = $record_count;
		}

		if (isset($_POST['pagination_export']) && $_POST['pagination_export'] == 'Y') {
			/*if(isset($all_list) && !empty($all_list)){
								  $date_formate=Config::get('constant.DATE_FORMATE');
								  $file_full_path = public_path().Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv";
								  $file_full_url = asset(Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv");
								  $file_for_download_data = fopen($file_full_path,"w");
								  fputcsv($file_for_download_data,array('#','Name','Email','Mobile','Add Date'));
								  $i=$sr_start;
								  foreach ($all_list as $single){
									  if($single->add_date!=''){
										  $add_date = date($date_formate, $single->add_date);
									  }else{
										  $add_date = '';
									  }
									  fputcsv($file_for_download_data,array(
										  $i,
										  $single->first_name.' '.$single->last_name,
										  $single->email,
										  $single->mobile,
										  $add_date
									  ));
									  $i++;
								  }
								  fclose($file_for_download_data);
								  $this->param['SUCCESS']='TRUE';
								  $this->param['file_full_url']=$file_full_url;
							  }else{
								  $this->param['SUCCESS']='FALSE';
							  }
							  echo json_encode($this->param,1);*/
		} else {
			$html = '';
			$html .= '<div class="row">';
			$html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			$html .= '<div class="table-responsive">';
			$html .= '<table class="table table-bordered table-hover">';

			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>#</th>';
			$html .= '<th>Shop</th>'; // class="sort_th" data-sort_field="shop_order_id"
			//$html .= '<th>Installation Link</th>';
			$html .= '<th>Date</th>';
			$html .= '<th>Actions</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if (!empty($all_list)) {
				$sr = $sr_start;
				foreach ($all_list as $single) {
					$install_link = common::APP_INSTALL_URL . '?install_token=' . $single['install_token'];
					$html .= '<tr>';
					$html .= '<td>' . $sr . '</td>';
					$html .= '<td>' . $single['shop'] . '</td>';
					/*$html .= '<td>'.$install_link.' ';
												  $html .= '<button type="button" class="btn btn-xs btn-info copy_install_link" data-link="'.$install_link.'">Copy</button>';
												  $html .= '</td>';*/
					$html .= '<td>' . ($single['add_date'] != '' ? date('d M Y', $single['add_date']) : '') . '</td>';
					$html .= '<td>';
					$html .= '<button type="button" class="btn btn-primary btn-xs edit-shop-btn" data-id="' . $single['id'] . '" data-shop="' . $single['shop'] . '" data-token="' . $single['install_token'] . '">Edit</button> ';
					$html .= '<button type="button" class="btn btn-danger btn-xs delete-shop-btn" data-id="' . $single['id'] . '">Delete</button>';
					$html .= '</td>';
					$html .= '</tr>';
					$sr++;
				}
			} else {
				$html .= '<tr>';
				$html .= '<td colspan="4" align="center">No Record Found</td>';
				$html .= '</tr>';
			}

			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';

			$res['DATA'] = $html;
			$res['page_count'] = $page;
			$res['record_count'] = $record_count;
			$res['sr_start'] = $sr_start;
			$res['sr_end'] = $sr_end;
			echo json_encode($res, 1);
		}
	}

	public function get_main_option()
	{
		//fixed, no change for any module
		$record_count = 0;
		$page = 0;
		$current_page = 1;
		$rows = '10';
		$keyword = '';
		if ((isset($_REQUEST['rows'])) && (!empty($_REQUEST['rows']))) {
			$rows = $_REQUEST['rows'];
		}
		if ((isset($_REQUEST['keyword'])) && (!empty($_REQUEST['keyword']))) {
			$keyword = $_REQUEST['keyword'];
		}
		if ((isset($_REQUEST['current_page'])) && (!empty($_REQUEST['current_page']))) {
			$current_page = $_REQUEST['current_page'];
		}
		$start = ($current_page - 1) * $rows;
		$end = $rows;
		$sort_field = '';
		if (isset($_POST['sort_field']) && !empty($_POST['sort_field'])) {
			$sort_field = $_POST['sort_field'];
		}
		$sort_type = '';
		if (isset($_POST['sort_type']) && !empty($_POST['sort_type'])) {
			$sort_type = $_POST['sort_type'];
		}
		//end fixed, no change for any module

		$cond_keyword = '';
		if (isset($keyword) && !empty($keyword)) {
			$cond_keyword = "AND (
						shop LIKE '%$keyword%'
					)";
		}
		$cond_order = 'ORDER BY id DESC';
		if (!empty($sort_field)) {
			$cond_order = 'ORDER BY ' . $sort_field . ' ' . $sort_type;
		}

		$sql = "
					SELECT count(id) as count
					FROM `main_option`
					WHERE 1
					$cond_keyword
				";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1 = "
					SELECT id, mainoption	
					FROM `main_option`
					WHERE 1
					$cond_keyword
					$cond_order
					LIMIT $start,$end
				";
		$all_list = parent::selectTable_f_mdl($sql1);

		if ((isset($all_count[0]['count'])) && (!empty($all_count[0]['count']))) {
			$record_count = $all_count[0]['count'];
			$page = $record_count / $rows;
			$page = ceil($page);
		}
		$sr_start = 0;
		if ($record_count >= 1) {
			$sr_start = (($current_page - 1) * $rows) + 1;
		}
		$sr_end = ($current_page) * $rows;
		if ($record_count <= $sr_end) {
			$sr_end = $record_count;
		}

		if (isset($_POST['pagination_export']) && $_POST['pagination_export'] == 'Y') {
			/*if(isset($all_list) && !empty($all_list)){
									  $date_formate=Config::get('constant.DATE_FORMATE');
									  $file_full_path = public_path().Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv";
									  $file_full_url = asset(Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv");
									  $file_for_download_data = fopen($file_full_path,"w");
									  fputcsv($file_for_download_data,array('#','Name','Email','Mobile','Add Date'));
									  $i=$sr_start;
									  foreach ($all_list as $single){
										  if($single->add_date!=''){
											  $add_date = date($date_formate, $single->add_date);
										  }else{
											  $add_date = '';
										  }
										  fputcsv($file_for_download_data,array(
											  $i,
											  $single->first_name.' '.$single->last_name,
											  $single->email,
											  $single->mobile,
											  $add_date
										  ));
										  $i++;
									  }
									  fclose($file_for_download_data);
									  $this->param['SUCCESS']='TRUE';
									  $this->param['file_full_url']=$file_full_url;
								  }else{
									  $this->param['SUCCESS']='FALSE';
								  }
								  echo json_encode($this->param,1);*/
		} else {
			$html = '';
			$html .= '<div class="row">';
			$html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			$html .= '<div class="table-responsive">';
			$html .= '<table class="table table-bordered table-hover">';

			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>#</th>';
			$html .= '<th>Main Option</th>'; // class="sort_th" data-sort_field="shop_order_id"
			$html .= '<th>Actions</th>';
			$html .= '<th>Actions</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if (!empty($all_list)) {
				$sr = $sr_start;


				foreach ($all_list as $single) {
					$html .= '<tr>';
					$html .= '<td>' . $sr . '</td>';
					$html .= '<td>' . htmlspecialchars($single['mainoption'], ENT_QUOTES, 'UTF-8') . '</td>';
					$html .= '<td>';
					$html .= '<button type="button" class="btn btn-primary btn-xs edit-shop-btn" '
						. 'data-id="' . htmlspecialchars($single['id'], ENT_QUOTES, 'UTF-8') . '" '
						. 'data-shop="' . (isset($single['shop_id']) ? htmlspecialchars($single['shop_id'], ENT_QUOTES, 'UTF-8') : '') . '" '
						. 'data-mainoption="' . htmlspecialchars($single['mainoption'], ENT_QUOTES, 'UTF-8') . '">Edit</button>';
					$html .= '</td>';
					$html .= '<td>';
					$html .= '<button type="button" class="btn btn-danger btn-xs delete-shop-btn" '
						. 'data-id="' . htmlspecialchars($single['id'], ENT_QUOTES, 'UTF-8') . '">Delete</button>';
					$html .= '</td>';
					$html .= '</tr>';
					$sr++;
				}
			} else {
				$html .= '<tr>';
				$html .= '<td colspan="4" align="center">No Record Found</td>';
				$html .= '</tr>';
			}

			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';

			$res['DATA'] = $html;
			$res['page_count'] = $page;
			$res['record_count'] = $record_count;
			$res['sr_start'] = $sr_start;
			$res['sr_end'] = $sr_end;
			echo json_encode($res, 1);
		}
	}
	public function get_sub_option()
	{
		//fixed, no change for any module
		$record_count = 0;
		$page = 0;
		$current_page = 1;
		$rows = '10';
		$keyword = '';
		if ((isset($_REQUEST['rows'])) && (!empty($_REQUEST['rows']))) {
			$rows = $_REQUEST['rows'];
		}
		if ((isset($_REQUEST['keyword'])) && (!empty($_REQUEST['keyword']))) {
			$keyword = $_REQUEST['keyword'];
		}
		if ((isset($_REQUEST['current_page'])) && (!empty($_REQUEST['current_page']))) {
			$current_page = $_REQUEST['current_page'];
		}
		$start = ($current_page - 1) * $rows;
		$end = $rows;
		$sort_field = '';
		if (isset($_POST['sort_field']) && !empty($_POST['sort_field'])) {
			$sort_field = $_POST['sort_field'];
		}
		$sort_type = '';
		if (isset($_POST['sort_type']) && !empty($_POST['sort_type'])) {
			$sort_type = $_POST['sort_type'];
		}
		//end fixed, no change for any module

		$cond_keyword = '';
		if (isset($keyword) && !empty($keyword)) {
			$cond_keyword = "AND (
					shop LIKE '%$keyword%'
				)";
		}
		$cond_order = 'ORDER BY id DESC';
		if (!empty($sort_field)) {
			$cond_order = 'ORDER BY ' . $sort_field . ' ' . $sort_type;
		}

		$sql = "
				SELECT count(id) as count
				FROM `sub_option`
				WHERE 1
				$cond_keyword
			";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1 = "
				SELECT id, sub_option_title	
				FROM `sub_option`
				WHERE 1
				$cond_keyword
				$cond_order
				LIMIT $start,$end
			";
		$all_list = parent::selectTable_f_mdl($sql1);

		if ((isset($all_count[0]['count'])) && (!empty($all_count[0]['count']))) {
			$record_count = $all_count[0]['count'];
			$page = $record_count / $rows;
			$page = ceil($page);
		}
		$sr_start = 0;
		if ($record_count >= 1) {
			$sr_start = (($current_page - 1) * $rows) + 1;
		}
		$sr_end = ($current_page) * $rows;
		if ($record_count <= $sr_end) {
			$sr_end = $record_count;
		}

		if (isset($_POST['pagination_export']) && $_POST['pagination_export'] == 'Y') {
			/*if(isset($all_list) && !empty($all_list)){
								  $date_formate=Config::get('constant.DATE_FORMATE');
								  $file_full_path = public_path().Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv";
								  $file_full_url = asset(Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv");
								  $file_for_download_data = fopen($file_full_path,"w");
								  fputcsv($file_for_download_data,array('#','Name','Email','Mobile','Add Date'));
								  $i=$sr_start;
								  foreach ($all_list as $single){
									  if($single->add_date!=''){
										  $add_date = date($date_formate, $single->add_date);
									  }else{
										  $add_date = '';
									  }
									  fputcsv($file_for_download_data,array(
										  $i,
										  $single->first_name.' '.$single->last_name,
										  $single->email,
										  $single->mobile,
										  $add_date
									  ));
									  $i++;
								  }
								  fclose($file_for_download_data);
								  $this->param['SUCCESS']='TRUE';
								  $this->param['file_full_url']=$file_full_url;
							  }else{
								  $this->param['SUCCESS']='FALSE';
							  }
							  echo json_encode($this->param,1);*/
		} else {
			$html = '';
			$html .= '<div class="row">';
			$html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			$html .= '<div class="table-responsive">';
			$html .= '<table class="table table-bordered table-hover">';

			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>#</th>';
			$html .= '<th>Sub Option</th>'; 
			$html .= '<th>Actions</th>';
			$html .= '<th>Actions</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if (!empty($all_list)) {
				$sr = $sr_start;
				foreach ($all_list as $single) {
					// $install_link = common::APP_INSTALL_URL . '?install_token=' . $single['install_token'];
					$html .= '<tr>';
					$html .= '<td>' . $sr . '</td>';
					$html .= '<td>' . $single['sub_option_title'] . '</td>';
					$html .= '<td>';
					$html .= '<button type="button" class="btn btn-primary btn-xs edit-sub-option-btn" '
						. 'data-id="' . htmlspecialchars($single['id'], ENT_QUOTES, 'UTF-8') . '" '
						. 'data-shop="' . (isset($single['shop_options']) ? htmlspecialchars($single['shop_options'], ENT_QUOTES, 'UTF-8') : '') . '" '
						. 'data-title="' . htmlspecialchars($single['sub_option_title'], ENT_QUOTES, 'UTF-8') . '">Edit</button>';
					$html .= '</td>';
					$html .= '<td>';
					$html .= '<button type="button" class="btn btn-danger btn-xs delete-shop-btn" '
						. 'data-id="' . htmlspecialchars($single['id'], ENT_QUOTES, 'UTF-8') . '">Delete</button>';
					// $html .= '<button type="button" class="btn btn-danger btn-xs delete-shop-btn" data-id="' . $single['id'] . '">Delete</button>';
					$html .= '</td>';
					$html .= '</tr>';
					$sr++;
				}
			} else {
				$html .= '<tr>';
				$html .= '<td colspan="4" align="center">No Record Found</td>';
				$html .= '</tr>';
			}

			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';

			$res['DATA'] = $html;
			$res['page_count'] = $page;
			$res['record_count'] = $record_count;
			$res['sr_start'] = $sr_start;
			$res['sr_end'] = $sr_end;
			echo json_encode($res, 1);
		}
	}
	public function add_mainoption()
	{

		if (isset($_POST['shop_options']) && isset($_POST['mainoption']) && !empty($_POST['shop_options']) && !empty($_POST['mainoption'])) {
			$shop_option = trim($_POST['shop_options']);
			$main_option = trim($_POST['mainoption']);
			$main_option = isset($_POST['mainoption']) ? trim($_POST['mainoption']) : ''; // Get main_option if provided
			$slug_main_option = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $main_option)));

			// Check if the shop option already exists
			$sql = 'SELECT * FROM `main_option` WHERE mainoption	="' . $main_option . '"';
			$exist = parent::selectTable_f_mdl($sql);
			if (empty($exist)) {
				// You might want to adjust the insert_data array according to your schema
				$insert_data = [
					'shop_id' => $shop_option,
					'main_option_slug' => $slug_main_option, // Store slug version of main_option
					'mainoption' => $main_option,
				];

				self::$site_log->insert_log($shop_option, common::APP_NAME, "Add", "Shop Installation", '', 'Added successfully', $insert_data);
				parent::insertTable_f_mdl('main_option', $insert_data);

				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			} else {
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Shop option already exists. Please check in the list for installation link.';

				self::$site_log->insert_log($shop_option, common::APP_NAME, "Add", "Shop Installation", '', 'Shop option already exists. Please check in the list for installation link', []);
			}
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('location:index.php?do=main-option');
	}


	public function add_suboption()
	{
		if (isset($_POST['main_options']) && isset($_POST['sub_option']) && !empty($_POST['main_options']) && !empty($_POST['sub_option'])) {
			$main_option_id = trim($_POST['main_options']);
			$sub_option = trim($_POST['sub_option']);
			$slug_main_option = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $sub_option)));

			// Handle image upload
			$image_path = '';
			if (isset($_FILES['suboption_image']) && $_FILES['suboption_image']['error'] === UPLOAD_ERR_OK) {
				$file_tmp = $_FILES['suboption_image']['tmp_name'];
				$file_name = basename($_FILES['suboption_image']['name']);
				$upload_dir = 'uploads/';
				$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

				// Validate file extension
				$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
				if (!in_array($file_ext, $allowed_extensions)) {
					$_SESSION['SUCCESS'] = 'FALSE';
					$_SESSION['MESSAGE'] = 'Invalid image file type. Allowed types are jpg, jpeg, png, gif.';
					header('Location: index.php?do=sub_option');
					exit;
				}

				// Generate a unique file name
				$file_name = uniqid() . '.' . $file_ext;
				$image_path = $upload_dir . $file_name;

				// Check if upload directory exists
				if (!file_exists($upload_dir)) {
					if (!mkdir($upload_dir, 0755, true)) {
						$_SESSION['SUCCESS'] = 'FALSE';
						$_SESSION['MESSAGE'] = 'Failed to create upload directory.';
						header('Location: index.php?do=sub_option');
						exit;
					}
				}

				// Move uploaded file to the upload directory
				if (!move_uploaded_file($file_tmp, $image_path)) {
					$_SESSION['SUCCESS'] = 'FALSE';
					$_SESSION['MESSAGE'] = 'Failed to upload image.';
					header('Location: index.php?do=sub_option');
					exit;
				}
			} elseif (isset($_FILES['suboption_image']) && $_FILES['suboption_image']['error'] !== UPLOAD_ERR_OK) {
				// More detailed error reporting
				$upload_error_codes = [
					UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
					UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
					UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
					UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
					UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
					UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
					UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
				];
				$error_message = $upload_error_codes[$_FILES['suboption_image']['error']] ?? 'Unknown upload error.';
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Image upload error: ' . $error_message;
				header('Location: index.php?do=sub_option');
				exit;
			}

			// Check if the sub-option already exists
			$sql = 'SELECT id FROM `sub_option` WHERE sub_option_title	="' . $sub_option . '"';
			$exist = parent::selectTable_f_mdl($sql);

			if (empty($exist)) {
				// Prepare insert data
				$insert_data = [
					'main_option_id' => $main_option_id,
					'sub_option_title' => $sub_option,
					'sub_option_sulg' => $slug_main_option,
					'icon' => $image_path // Save image path to the database
				];

				self::$site_log->insert_log($main_option_id, common::APP_NAME, "Add", "Sub Option", '', 'Added successfully', $insert_data);
				parent::insertTable_f_mdl('sub_option', $insert_data);

				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			} else {
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Sub-option already exists.';

				self::$site_log->insert_log($main_option_id, common::APP_NAME, "Add", "Sub Option", '', 'Sub-option already exists.', []);
			}
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('Location: index.php?do=sub_option');
		exit;
	}


	public function add_new_shop_install_token_post()
	{
		if (isset($_POST['sit_shop']) && isset($_POST['token']) && !empty($_POST['sit_shop']) && !empty($_POST['token'])) {
			$shop = trim($_POST['sit_shop']);
			$token = trim($_POST['token']);

			$sql = 'SELECT id FROM `shop_install_token` WHERE shop="' . $shop . '"';
			$exist = parent::selectTable_f_mdl($sql);
			if (empty($exist)) {
				// $token = str_replace('==','',base64_encode(rand(100000,999999).time()));
				$insert_data = [
					'shop' => $shop,
					'install_token' => $token,
					'add_date' => time()
				];

				self::$site_log->insert_log($shop, common::APP_NAME, "Add", "Shop Installation", '', 'Added successfully', $insert_data);
				parent::insertTable_f_mdl('shop_install_token', $insert_data);

				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			} else {
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Shop is already existed. Please check in list for installation link.';

				self::$site_log->insert_log($shop, common::APP_NAME, "Add", "Shop Installation", '', 'Shop is already existed. Please check in list for installation link', []);
			}
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('location:index.php?do=shop_installation');
	}

	public function get_language_list_post()
	{
		//fixed, no change for any module
		$record_count = 0;
		$page = 0;
		$current_page = 1;
		$rows = '10';
		$keyword = '';
		if ((isset($_REQUEST['rows'])) && (!empty($_REQUEST['rows']))) {
			$rows = $_REQUEST['rows'];
		}
		if ((isset($_REQUEST['keyword'])) && (!empty($_REQUEST['keyword']))) {
			$keyword = $_REQUEST['keyword'];
		}
		if ((isset($_REQUEST['current_page'])) && (!empty($_REQUEST['current_page']))) {
			$current_page = $_REQUEST['current_page'];
		}
		$start = ($current_page - 1) * $rows;
		$end = $rows;
		$sort_field = '';
		if (isset($_POST['sort_field']) && !empty($_POST['sort_field'])) {
			$sort_field = $_POST['sort_field'];
		}
		$sort_type = '';
		if (isset($_POST['sort_type']) && !empty($_POST['sort_type'])) {
			$sort_type = $_POST['sort_type'];
		}
		//end fixed, no change for any module

		$cond_keyword = '';
		if (isset($keyword) && !empty($keyword)) {
			$cond_keyword = "AND (
					language LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY language_master.id DESC';
		if (!empty($sort_field)) {
			$cond_order = 'ORDER BY ' . $sort_field . ' ' . $sort_type;
		}

		$sql = "
                SELECT count(language_master.id) as count
                FROM `language_master`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1 = "
                SELECT language_master.id, language_master.language, language_master.status
                FROM `language_master`
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::selectTable_f_mdl($sql1);

		if ((isset($all_count[0]['count'])) && (!empty($all_count[0]['count']))) {
			$record_count = $all_count[0]['count'];
			$page = $record_count / $rows;
			$page = ceil($page);
		}
		$sr_start = 0;
		if ($record_count >= 1) {
			$sr_start = (($current_page - 1) * $rows) + 1;
		}
		$sr_end = ($current_page) * $rows;
		if ($record_count <= $sr_end) {
			$sr_end = $record_count;
		}

		if (isset($_POST['pagination_export']) && $_POST['pagination_export'] == 'Y') {
			/*if(isset($all_list) && !empty($all_list)){
								  $date_formate=Config::get('constant.DATE_FORMATE');
								  $file_full_path = public_path().Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv";
								  $file_full_url = asset(Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv");
								  $file_for_download_data = fopen($file_full_path,"w");
								  fputcsv($file_for_download_data,array('#','Name','Email','Mobile','Add Date'));
								  $i=$sr_start;
								  foreach ($all_list as $single){
									  if($single->add_date!=''){
										  $add_date = date($date_formate, $single->add_date);
									  }else{
										  $add_date = '';
									  }
									  fputcsv($file_for_download_data,array(
										  $i,
										  $single->first_name.' '.$single->last_name,
										  $single->email,
										  $single->mobile,
										  $add_date
									  ));
									  $i++;
								  }
								  fclose($file_for_download_data);
								  $this->param['SUCCESS']='TRUE';
								  $this->param['file_full_url']=$file_full_url;
							  }else{
								  $this->param['SUCCESS']='FALSE';
							  }
							  echo json_encode($this->param,1);*/
		} else {
			$html = '';
			$html .= '<div class="row">';
			$html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			$html .= '<div class="table-responsive">';
			$html .= '<table class="table table-bordered table-hover">';

			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>#</th>';
			$html .= '<th>Language</th>'; // class="sort_th" data-sort_field="shop_order_id"
			$html .= '<th>Status</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if (!empty($all_list)) {
				$sr = $sr_start;
				foreach ($all_list as $single) {
					if ($single['status'] == '1') {
						$status_chk = 'checked';
					} else {
						$status_chk = '';
					}
					$html .= '<tr>';
					$html .= '<td>' . $sr . '</td>';
					$html .= '<td>' . $single['language'] . '</td>';
					$html .= '<td><input type="checkbox" class="status_class" data-on-text="Active" data-off-text="Inactive" data-id="' . $single['id'] . '" data-bootstrap-switch ' . $status_chk . '></td>';
					$html .= '</tr>';
					$sr++;
				}
			} else {
				$html .= '<tr>';
				$html .= '<td colspan="3" align="center">No Record Found</td>';
				$html .= '</tr>';
			}

			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';

			$res['DATA'] = $html;
			$res['page_count'] = $page;
			$res['record_count'] = $record_count;
			$res['sr_start'] = $sr_start;
			$res['sr_end'] = $sr_end;
			echo json_encode($res, 1);
		}
	}
	public function change_language_status()
	{
		if (isset($_POST['id']) && isset($_POST['new_status'])) {
			$update_data = [
				'status' => $_POST['new_status']
			];

			self::$site_log->insert_log("", common::APP_NAME, "Update", "Language", '', 'Status changed successfully', $update_data);
			parent::updateTable_f_mdl('language_master', $update_data, 'id="' . $_POST['id'] . '"');

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Status changed successfully.';
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}
	public function add_new_language_post()
	{
		if (isset($_POST['language']) && !empty($_POST['language'])) {
			$language = trim($_POST['language']);
			$sql = 'SELECT id FROM `language_master` WHERE language="' . $language . '"';
			$exist = parent::selectTable_f_mdl($sql);
			if (empty($exist)) {
				$insert_data = [
					'language' => $language,
					'shortcode' => preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($language)),
					'status' => '1'
				];

				self::$site_log->insert_log("", common::APP_NAME, "Add", "Language", '', 'Added successfully.', $insert_data);
				parent::insertTable_f_mdl('language_master', $insert_data);

				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			} else {
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Language is already existed.';

				self::$site_log->insert_log("", common::APP_NAME, "Add", "Language", '', 'Language is already existed.', []);
			}
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('location:index.php?do=languages');
	}

	public function updateTable_f_mdl($table, $data, $where)
	{
		try {
			$set_parts = [];
			foreach ($data as $key => $value) {
				$set_parts[] = "$key = :" . $key;
			}
			$set_sql = implode(', ', $set_parts);

			$sql = "UPDATE $table SET $set_sql WHERE $where";

			// Prepare the SQL statement
			$stmt = $this->pdo->prepare($sql);

			// Bind parameters
			foreach ($data as $key => &$value) {
				$stmt->bindParam(':' . $key, $value);
			}

			// Execute the query
			return $stmt->execute();
		} catch (PDOException $e) {
			// Handle exception
			error_log('Database update error: ' . $e->getMessage());
			return false;
		}
	}

	public function edit_shop_install_token_post()
	{
		if (isset($_POST['shop_id']) && isset($_POST['sit_shop']) && isset($_POST['token'])) {
			$shop_id = trim(
				$_POST['shop_id']
			);
			$shop_name = trim($_POST['sit_shop']);
			$install_token = trim($_POST['token']);

			if ($shop_id && $shop_name && $install_token) {
				// Prepare the update data
				$update_data = [
					'shop' => $shop_name,
					'install_token' => $install_token
				];
				$where_condition = 'id = ' . intval($shop_id);

				// Call the method to perform the update
				$result = parent::updateTable_f_mdl('shop_install_token', $update_data, $where_condition);

				if ($result) {
					// Log the successful update
					self::$site_log->insert_log($shop_name, common::APP_NAME, "Update", "Shop Installation", '', 'Shop installation updated successfully', [
						'shop_id' => $shop_id,
						'shop_name' => $shop_name,
						'install_token' => $install_token
					]);

					$_SESSION['SUCCESS'] = 'TRUE';
					$_SESSION['MESSAGE'] = 'Shop installation updated successfully.';
				} else {
					// Log the failure
					self::$site_log->insert_log($shop_name, common::APP_NAME, "Update", "Shop Installation", '', 'Failed to update shop installation', [
						'shop_id' => $shop_id,
						'shop_name' => $shop_name,
						'install_token' => $install_token
					]);

					$_SESSION['SUCCESS'] = 'FALSE';
					$_SESSION['MESSAGE'] = 'Failed to update shop installation.';
				}
			} else {
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Invalid data provided.';
			}
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('Location: index.php?do=shop_installation');
		exit;
	}


	public function edit_mainoption()
	{
		if (isset($_POST['edit_id']) && isset($_POST['shop_options']) && isset($_POST['mainoption'])) {
			$shop_id = trim($_POST['edit_id']);
			$shop_option = trim($_POST['shop_options']);
			$main_option = trim($_POST['mainoption']);
			$slug_main_option = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $main_option)));

			if ($shop_id && $shop_option && $main_option) {
				// Prepare the update data
				$update_data = [
					'shop_id' => $shop_option,
					'main_option_slug' => $slug_main_option,
					'mainoption' => $main_option
				];
				$where_condition = 'id = ' . intval($shop_id);

				// Call the method to perform the update
				$result = parent::updateTable_f_mdl('main_option', $update_data, $where_condition);

				if ($result) {
					// Log the successful update
					self::$site_log->insert_log($shop_option, common::APP_NAME, "Update", "Main Option", '', 'Main option updated successfully', [
						'shop_id' => $shop_id,
						'main_option_slug' => $$slug_main_option,
						'mainoption' => $main_option
					]);

					$_SESSION['SUCCESS'] = 'TRUE';
					$_SESSION['MESSAGE'] = 'Main option updated successfully.';
				} else {
					// Log the failure
					self::$site_log->insert_log($shop_option, common::APP_NAME, "Update", "Main Option", '', 'Failed to update main option', [
						'shop_id' => $shop_id,
						'shop_option' => $shop_option,
						'main_option' => $main_option
					]);

					$_SESSION['SUCCESS'] = 'FALSE';
					$_SESSION['MESSAGE'] = 'Failed to update main option.';
				}
			} else {
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Invalid data provided.';
			}
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('Location: index.php?do=main-option');
		exit;
	}
	public function edit_sub_option()
	{
		if (isset($_POST['edit_id']) && isset($_POST['main_options']) && isset($_POST['sub_option'])) {
			$sub_option_id = trim($_POST['edit_id']);
			$main_option_id = trim($_POST['main_options']);
			$sub_option_title = trim($_POST['sub_option']);
			$image = $_FILES['suboption_image']['name'];
			$slug_main_option = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $sub_option_title)));

			// Handle image upload if a new image is provided
			if (!empty($image)) {
				$image_path = 'uploads/' . basename($image);
				move_uploaded_file($_FILES['suboption_image']['tmp_name'], $image_path);
			}

			if ($sub_option_id && $main_option_id && $sub_option_title) {
				// Prepare the update data
				$update_data = [
					'main_option_id' => $main_option_id,
					'sub_option_title' => $sub_option_title,
					'sub_option_sulg' =>$slug_main_option
				];

				if (!empty($image)) {
					$update_data['icon'] = $image_path;
				}

				$where_condition = 'id = ' . intval($sub_option_id);

				// Call the method to perform the update
				$result = parent::updateTable_f_mdl('sub_option', $update_data, $where_condition);

				if ($result) {
					$_SESSION['SUCCESS'] = 'TRUE';
					$_SESSION['MESSAGE'] = 'Sub option updated successfully.';
				} else {
					$_SESSION['SUCCESS'] = 'FALSE';
					$_SESSION['MESSAGE'] = 'Failed to update sub option.';
				}
			} else {
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Invalid data provided.';
			}
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('Location: index.php?do=sub_option');
		exit;
	}

	public function delete_shop_install_token_post()
	{
		if (isset($_POST['id']) && !empty($_POST['id'])) {
			$id = trim($_POST['id']);
			$sql = 'SELECT * FROM shop_install_token WHERE id="' . $id . '"';
			$data = parent::selectTable_f_mdl($sql);
			if (!empty($data)) {
				parent::deleteTable_f_mdl('shop_install_token', 'id="' . $id . '"');
				self::$site_log->insert_log('', common::APP_NAME, "Delete", "Admin", '', @$data[0]['email'] . ' Admin Deleted', [$id]);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			} else {
				self::$site_log->insert_log($id, common::APP_NAME, "Delete", "Admin", '', 'Invalid request.', [$id]);
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}
	public function delete_main_option()
	{
		if (isset($_POST['id']) && !empty($_POST['id'])) {
			$id = trim($_POST['id']);
			$sql = 'SELECT * FROM main_option WHERE id="' . $id . '"';
			$data = parent::selectTable_f_mdl($sql);
			if (!empty($data)) {
				parent::deleteTable_f_mdl('main_option', 'id="' . $id . '"');
				self::$site_log->insert_log('', common::APP_NAME, "Delete", "Main option", '', @$data[0]['email'] . ' Main option Deleted', [$id]);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			} else {
				self::$site_log->insert_log($id, common::APP_NAME, "Delete", "Main option", '', 'Invalid request.', [$id]);
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}
	public function delete_sub_option()
	{
		if (isset($_POST['id']) && !empty($_POST['id'])) {
			$id = trim($_POST['id']);
			$sql = 'SELECT * FROM sub_option WHERE id="' . $id . '"';
			$data = parent::selectTable_f_mdl($sql);
			if (!empty($data)) {
				parent::deleteTable_f_mdl('sub_option', 'id="' . $id . '"');
				self::$site_log->insert_log('', common::APP_NAME, "Delete", "Sub option", '', @$data[0]['email'] . ' Sub option Deleted', [$id]);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			} else {
				self::$site_log->insert_log($id, common::APP_NAME, "Delete", "Sub option", '', 'Invalid request.', [$id]);
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}



	public function get_page_permission_list_post()
	{
		//fixed, no change for any module
		$record_count = 0;
		$page = 0;
		$current_page = 1;
		$rows = '10';
		$keyword = '';
		if ((isset($_REQUEST['rows'])) && (!empty($_REQUEST['rows']))) {
			$rows = $_REQUEST['rows'];
		}
		if ((isset($_REQUEST['keyword'])) && (!empty($_REQUEST['keyword']))) {
			$keyword = $_REQUEST['keyword'];
		}
		if ((isset($_REQUEST['current_page'])) && (!empty($_REQUEST['current_page']))) {
			$current_page = $_REQUEST['current_page'];
		}
		$start = ($current_page - 1) * $rows;
		$end = $rows;
		$sort_field = '';
		if (isset($_POST['sort_field']) && !empty($_POST['sort_field'])) {
			$sort_field = $_POST['sort_field'];
		}
		$sort_type = '';
		if (isset($_POST['sort_type']) && !empty($_POST['sort_type'])) {
			$sort_type = $_POST['sort_type'];
		}
		//end fixed, no change for any module

		$cond_keyword = '';
		if (isset($keyword) && !empty($keyword)) {
			$cond_keyword = "AND (
					shop_management.shop_name LIKE '%$keyword%' OR
					shop_management.email LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY search_page_permission.id DESC';
		if (!empty($sort_field)) {
			$cond_order = 'ORDER BY ' . $sort_field . ' ' . $sort_type;
		}

		$sql = "
                SELECT count(search_page_permission.id) as count
                FROM `search_page_permission`
                RIGHT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1 = "
                SELECT search_page_permission.id, search_page_permission.shop_id, search_page_permission.search_diamond_allow, search_page_permission.search_lab_grown_allow, search_page_permission.search_gemstone_allow, search_page_permission.preview_request_allow, search_page_permission.cert_open_in_new_tab_allow, search_page_permission.own_inventory_allow,
				shop_management.shop_name, shop_management.email
                FROM `search_page_permission`
                RIGHT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::selectTable_f_mdl($sql1);

		if ((isset($all_count[0]['count'])) && (!empty($all_count[0]['count']))) {
			$record_count = $all_count[0]['count'];
			$page = $record_count / $rows;
			$page = ceil($page);
		}
		$sr_start = 0;
		if ($record_count >= 1) {
			$sr_start = (($current_page - 1) * $rows) + 1;
		}
		$sr_end = ($current_page) * $rows;
		if ($record_count <= $sr_end) {
			$sr_end = $record_count;
		}

		$image_upload_url = str_replace('login.php', '', common::APP_INSTALL_URL) . 'images/uploads/';

		if (isset($_POST['pagination_export']) && $_POST['pagination_export'] == 'Y') {
			/*if(isset($all_list) && !empty($all_list)){
								  $date_formate=Config::get('constant.DATE_FORMATE');
								  $file_full_path = public_path().Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv";
								  $file_full_url = asset(Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv");
								  $file_for_download_data = fopen($file_full_path,"w");
								  fputcsv($file_for_download_data,array('#','Name','Email','Mobile','Add Date'));
								  $i=$sr_start;
								  foreach ($all_list as $single){
									  if($single->add_date!=''){
										  $add_date = date($date_formate, $single->add_date);
									  }else{
										  $add_date = '';
									  }
									  fputcsv($file_for_download_data,array(
										  $i,
										  $single->first_name.' '.$single->last_name,
										  $single->email,
										  $single->mobile,
										  $add_date
									  ));
									  $i++;
								  }
								  fclose($file_for_download_data);
								  $this->param['SUCCESS']='TRUE';
								  $this->param['file_full_url']=$file_full_url;
							  }else{
								  $this->param['SUCCESS']='FALSE';
							  }
							  echo json_encode($this->param,1);*/
		} else {
			$html = '';
			$html .= '<div class="row">';
			$html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			$html .= '<div class="table-responsive">';
			$html .= '<table class="table table-bordered table-hover">';

			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>#</th>';
			$html .= '<th>Shop & Email</th>'; // class="sort_th" data-sort_field="shop_order_id"
			$html .= '<th>Natural Diamond</th>';
			$html .= '<th>Labgrown Diamond</th>';
			$html .= '<th>Gemstone</th>';
			$html .= '<th>Preview Request</th>';
			$html .= '<th>Cert open in New Tab</th>';
			$html .= '<th>Disable Auto Buy Request on VDB</th>';
			$html .= '<th>Action</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if (!empty($all_list)) {
				$sr = $sr_start;
				foreach ($all_list as $single) {
					$sql = 'SELECT shop_logo FROM api_settings WHERE shop_id="' . $single['shop_id'] . '"';
					$as_data = parent::selectTable_f_mdl($sql);
					$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="' . $single['shop_id'] . '"';
					$ets_data = parent::selectTable_f_mdl($sql);

					if ($single['search_diamond_allow'] == '1') {
						$search_diamond_allow_chk = 'Yes';
					} else {
						$search_diamond_allow_chk = 'No';
					}
					if ($single['search_lab_grown_allow'] == '1') {
						$search_lab_grown_allow_chk = 'Yes';
					} else {
						$search_lab_grown_allow_chk = 'No';
					}
					if ($single['search_gemstone_allow'] == '1') {
						$search_gemstone_allow_chk = 'Yes';
					} else {
						$search_gemstone_allow_chk = 'No';
					}
					if ($single['preview_request_allow'] == '1') {
						$preview_request_allow_chk = 'Yes';
					} else {
						$preview_request_allow_chk = 'No';
					}
					if ($single['cert_open_in_new_tab_allow'] == '1') {
						$cert_open_in_new_tab_allow_chk = 'Yes';
					} else {
						$cert_open_in_new_tab_allow_chk = 'No';
					}
					if ($single['own_inventory_allow'] == '1') {
						$own_inventory_allow_chk = 'Yes';
					} else {
						$own_inventory_allow_chk = 'No';
					}
					$sender_email = $single['email'];
					if (isset($ets_data[0]['email_sender_address']) && !empty($ets_data[0]['email_sender_address'])) {
						$sender_email = $ets_data[0]['email_sender_address'];
					}

					$html .= '<tr>';
					$html .= '<td>' . $sr . '</td>';
					$html .= '<td>';
					// if(isset($as_data[0]['shop_logo']) && !empty($as_data[0]['shop_logo'])){
					// 	$html .= '<img src="'.$image_upload_url.$as_data[0]['shop_logo'].'" style="width:70px;">';
					// }
					$html .= ' ' . $single['shop_name'] . '<br><b>' . $sender_email . '</b>';
					$html .= '</td>';
					$html .= '<td>' . $search_diamond_allow_chk . '</td>';
					$html .= '<td>' . $search_lab_grown_allow_chk . '</td>';
					$html .= '<td>' . $search_gemstone_allow_chk . '</td>';
					$html .= '<td>' . $preview_request_allow_chk . '</td>';
					$html .= '<td>' . $cert_open_in_new_tab_allow_chk . '</td>';
					$html .= '<td>' . $own_inventory_allow_chk . '</td>';

					$html .= '<td>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary upload_logo_btn" data-shop_id="'.$single['shop_id'].'">Upload Logo</button>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary edit_shop_btn" data-shop_id="'.$single['shop_id'].'" data-sender_email="'.$sender_email.'">Edit Email</button>';
					if (checkUserPermission('diamond_page_permission', 'actions')) {
						$html .= '<a href="index.php?do=page_shop_settings&shop_id=' . $single['shop_id'] . '" class="btn btn-sm btn-primary">Settings</a>';
					}
					$html .= '</td>';

					$html .= '</tr>';
					$sr++;
				}
			} else {
				$html .= '<tr>';
				$html .= '<td colspan="5" align="center">No Record Found</td>';
				$html .= '</tr>';
			}

			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';

			$res['DATA'] = $html;
			$res['page_count'] = $page;
			$res['record_count'] = $record_count;
			$res['sr_start'] = $sr_start;
			$res['sr_end'] = $sr_end;
			echo json_encode($res, 1);
		}
	}
	public function change_permission_status()
	{
		if (isset($_POST['id']) && isset($_POST['new_status']) && isset($_POST['field'])) {
			$search_id = $_POST['id'];
			$field = $_POST['field'];
			$status = $_POST['new_status'];

			$update_data = [
				$_POST['field'] => $_POST['new_status']
			];

			$sql = "SELECT spm.shop_id,sm.shop_name FROM search_page_permission AS spm INNER JOIN shop_management AS sm ON spm.shop_id = sm.id WHERE spm.id = " . $search_id;
			$get_shop = parent::selectTable_f_mdl($sql);
			$shop = @$get_shop[0]['shop_name'];

			self::$site_log->insert_log($shop, common::APP_NAME, "Update", "Shop Settings", 'id="' . $_POST['id'] . '"', 'Status changed successfully', $update_data);
			parent::updateTable_f_mdl('search_page_permission', $update_data, 'id="' . $_POST['id'] . '"');

			# Below codes only for gemstone. Added gemstone settings
			if ($field == 'search_gemstone_allow' && $status == 1) {
				$sql = "SELECT shop_id, search_gemstone_allow  FROM `search_page_permission` WHERE id=" . $search_id;
				$get_shop = parent::selectTable_f_mdl($sql);
				if (!empty($get_shop) && $get_shop[0]['search_gemstone_allow'] == 1) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT shop_id FROM `search_page_settings_gemstone` WHERE shop_id = " . $shop_id;
					$get_search_page = parent::selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						parent::insertShopidInSearchPageSettings_f_mdl($shop_id); // GEMSTONE
						$this->insertShopidInSearchSettingsGemstone_f($shop_id); // GEMSTONE
					}
				}
			}
			#END

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Status changed successfully.';
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}
	public function edit_shop_details()
	{
		if (isset($_POST['shop_id']) && !empty($_POST['shop_id'])) {
			$shop_id = $_POST['shop_id'];

			$sql = 'SELECT shop_name FROM shop_management WHERE id="' . $shop_id . '"';
			$shop_data = parent::selectTable_f_mdl($sql);

			$shop = @$shop_data[0]['shop_name'];

			$sql = 'SELECT id FROM email_template_settings WHERE shop_id="' . $shop_id . '"';
			$email_template_settings_data = parent::selectTable_f_mdl($sql);
			if (isset($email_template_settings_data[0]['id'])) {
				$update_data = [
					'email_sender_address' => $_POST['sender_email']
				];

				parent::updateTable_f_mdl('email_template_settings', $update_data, 'id="' . $email_template_settings_data[0]['id'] . '"');
				self::$site_log->insert_log($shop, common::APP_NAME, "Update", "Shop Settings", 'id="' . $email_template_settings_data[0]['id'] . '"', 'Saved successfully', $update_data);
			} else {
				$insert_data = [
					'shop_id' => $shop_id,
					'email_sender' => '',
					'email_sender_address' => $_POST['sender_email'],
					'email_reciever_address' => '',
					'email_template' => '',
					'status' => '1',
				];
				parent::insertTable_f_mdl('email_template_settings', $insert_data);

				self::$site_log->insert_log($shop, common::APP_NAME, "Add", "Shop Settings", '', 'Saved successfully', $insert_data);
			}


			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Saved successfully.';
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}
	public function get_details_by_shop_id($shop_id)
	{
		$sql = 'SELECT shop_name, email FROM shop_management WHERE id="' . $shop_id . '"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function get_item_details()
	{
		$html = '';
		$html .= '<div class="row">';
		$html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
		$html .= '<div class="table-responsive">';
		$html .= '<table class="table table-bordered table-hover">';
		$html .= '<tbody>';
		if (isset($_POST['id']) && !empty($_POST['id'])) {
			$sql = 'SELECT payload_request, payload_response FROM purchase_request_logs WHERE order_line_item_id="' . $_POST['id'] . '"';
			$data = parent::selectTable_f_mdl($sql);
			if (isset($data) && !empty($data)) {
				foreach ($data as $single) {
					$jsonString = json_decode(json_encode($single['payload_response'], JSON_PRETTY_PRINT), true);
					$html .= '<tr>';
					$html .= '<td> <h5>Request</h5> ' . $single['payload_request'] . '</td>';
					$html .= '</tr><tr>';
					$html .= '<td width="100"> <h5>Response</h5>' . $jsonString . '</td>';
					$html .= '</tr>';
				}
			} else {
				$html .= '<tr>';
				$html .= '<td colspan="2" align="center">No Record Found</td>';
				$html .= '</tr>';
			}
		} else {
			$html .= '<tr>';
			$html .= '<td colspan="2" align="center">No Record Found</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}
	// Blocked IP Functions Starts
	
	// Blocked IP Functions Ends

	// Admin Function starts
	public function get_admin_list_post()
	{
		//fixed, no change for any module
		$record_count = 0;
		$page = 0;
		$current_page = 1;
		$rows = '10';
		$keyword = '';
		if ((isset($_REQUEST['rows'])) && (!empty($_REQUEST['rows']))) {
			$rows = $_REQUEST['rows'];
		}
		if ((isset($_REQUEST['keyword'])) && (!empty($_REQUEST['keyword']))) {
			$keyword = $_REQUEST['keyword'];
		}
		if ((isset($_REQUEST['current_page'])) && (!empty($_REQUEST['current_page']))) {
			$current_page = $_REQUEST['current_page'];
		}
		$start = ($current_page - 1) * $rows;
		$end = $rows;
		$sort_field = '';
		if (isset($_POST['sort_field']) && !empty($_POST['sort_field'])) {
			$sort_field = $_POST['sort_field'];
		}
		$sort_type = '';
		if (isset($_POST['sort_type']) && !empty($_POST['sort_type'])) {
			$sort_type = $_POST['sort_type'];
		}
		//end fixed, no change for any module

		$cond_keyword = '';
		if (isset($keyword) && !empty($keyword)) {
			$cond_keyword = "AND (
					first_name LIKE '%$keyword%' OR
					last_name LIKE '%$keyword%' OR
					email LIKE '%$keyword%' OR
					id LIKE '%$keyword%'
		        )";
		}
		$cond_order = 'ORDER BY id DESC';
		if (!empty($sort_field)) {
			$cond_order = 'ORDER BY ' . $sort_field . ' ' . $sort_type;
		}

		$sql = "
				SELECT count(id) as count
				FROM `admin_master`
				WHERE 1
				$cond_keyword
			";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1 = "
				SELECT id, first_name, last_name, email, is_super_admin, status, created_on
				FROM `admin_master`
				WHERE 1
				$cond_keyword
				$cond_order
				LIMIT $start,$end
			";
		$all_list = parent::selectTable_f_mdl($sql1);

		if ((isset($all_count[0]['count'])) && (!empty($all_count[0]['count']))) {
			$record_count = $all_count[0]['count'];
			$page = $record_count / $rows;
			$page = ceil($page);
		}
		$sr_start = 0;
		if ($record_count >= 1) {
			$sr_start = (($current_page - 1) * $rows) + 1;
		}
		$sr_end = ($current_page) * $rows;
		if ($record_count <= $sr_end) {
			$sr_end = $record_count;
		}

		if (isset($_POST['pagination_export']) && $_POST['pagination_export'] == 'Y') {
		} else {
			$html = '';
			$html .= '<div class="row">';
			$html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			$html .= '<div class="table-responsive">';
			$html .= '<table class="table table-bordered table-hover">';

			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>#</th>';
			$html .= '<th>Name</th>';
			$html .= '<th>Email</th>';
			$html .= '<th>Super Admin</th>';
			$html .= '<th>Status</th>';
			$html .= '<th>Action</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';

			if (!empty($all_list)) {
				$sr = $sr_start;
				foreach ($all_list as $single) {
					$html .= '<tr>';
					$html .= '<td>' . $sr . '</td>';
					$html .= '<td>' . $single['first_name'] . '  ' . $single['last_name'] . '</td>';
					$html .= '<td>' . $single['email'] . '</td>';
					$isSuperAdmin = ($single['is_super_admin'] == 1) ? 'checked' : '';
					$html .= '<td><div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input  superadmin_status" id="customSwitch' . $single['id'] . '" ' . $isSuperAdmin . ' >
                      <label class="custom-control-label" for="customSwitch' . $single['id'] . '"></label>
                    </div>
                  </div></td>';
					$adminStatus = ($single['status'] == 1) ? 'checked' : '';
					$html .= '<td><div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input status" id="statusSwitch' . $single['id'] . '" ' . $adminStatus . ' >
                      <label class="custom-control-label" for="statusSwitch' . $single['id'] . '"></label>
                    </div>
                  </div></td>';
					// $html .= '<td>'.($single['created_on']!=''?date('d M Y',strtotime($single['created_on'])):'').'</td>';
					$html .= '<td>
					<button class="btn btn-sm btn-warning btn-minier edit_admin mr-1" data-id="' . $single['id'] . '"><i class="fas fa-edit"></i></button>';
					if ($_SESSION['login_user_id'] != $single['id']) {
						$html .= '<a href ="index.php?do=module-list&admin_id=' . $single['id'] . '" ><button  class="btn btn-sm btn-primary btn-minier permission" data-id="' . $single['id'] . '"><i class="fas fa-lock"></i></button></a>';
						$html .= '<button class="btn btn-sm btn-danger btn-minier delete_admin ml-1" data-id="' . $single['id'] . '"><i class="fas fa-trash"></i></button>';
					}
					$html .= '</td>';
					$html .= '</tr>';
					$sr++;
				}
			} else {
				$html .= '<tr>';
				$html .= '<td colspan="6" align="center">No Record Found</td>';
				$html .= '</tr>';
			}

			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';

			$res['DATA'] = $html;
			$res['page_count'] = $page;
			$res['record_count'] = $record_count;
			$res['sr_start'] = $sr_start;
			$res['sr_end'] = $sr_end;
			echo json_encode($res, 1);
			exit;
		}
	}
	public function get_module_list_post()
	{
		if (isset($_GET['admin_id']) && !empty($_GET['admin_id'])) {
			$sql1 = "SELECT id, permission
			FROM `admin_master` where id = " . $_GET['admin_id'];
			$admin = parent::selectTable_f_mdl($sql1);
			$permission = [];
			if (isset($admin[0]['permission']) && !empty($admin[0]['permission'])) {
				$permission = json_decode($admin[0]['permission']);
				$permission = array_column($permission, 'permission', 'module_shortcode');
			}

			$html = '';
			$html .= '<div class="row">';
			$html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			$html .= '<div class="table-responsive">';
			$html .= '<table class="table table-bordered table-hover">';

			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>#</th>';
			$html .= '<th>Module</th>';
			$html .= '<th>Permission</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$common = new common();
			$moduleList = $common->moduleList;
			if (!empty($moduleList)) {
				$sr = 0;
				foreach ($moduleList as $key => $single) {
					$readSelected = $writeSelected = $noneSelected = '';

					if (isset($permission[$single['module_shortcode']]) && !empty($permission[$single['module_shortcode']]) && $permission[$single['module_shortcode']] == 'write') {
						$writeSelected = 'checked';
					} else if (isset($permission[$single['module_shortcode']]) && !empty($permission[$single['module_shortcode']]) && $permission[$single['module_shortcode']] == 'read') {
						$readSelected = 'checked';
					} else if (isset($permission[$single['module_shortcode']]) && !empty($permission[$single['module_shortcode']]) && $permission[$single['module_shortcode']] == 'none') {
						$noneSelected = 'checked';
					}

					$key = $key + 1;
					$html .= '<tr>';
					$html .= '<td>' . $key . '</td>';
					$html .= '<td>' . $single['module_title'] . '</td>';
					$html .= '<td><div class="form-check form-check-inline permission_list">
					<input type="radio" class="form-check-input write_permission" id="' . $single['module_shortcode'] . '_write" name="' . $single['module_shortcode'] . '" value="write" ' . $writeSelected . ' >
					<label for="' . $single['module_shortcode'] . '_write" class=" form-check-label font-weight-bold ml-1 mr-4">Write</label><br>
					<input type="radio" class="form-check-input read_permission" id="' . $single['module_shortcode'] . '_read" name="' . $single['module_shortcode'] . '" value="read" ' . $readSelected . ' >
					<label for="' . $single['module_shortcode'] . '_read" class=" form-check-label font-weight-bold ml-1 mr-4">Read</label><br>
					<input type="radio" class="form-check-input none_permission" id="' . $single['module_shortcode'] . '_none" name="' . $single['module_shortcode'] . '" value="none" ' . $noneSelected . '>
					<label for="' . $single['module_shortcode'] . '_none" class=" form-check-label font-weight-bold ml-1 mr-4">None</label>';
					$html .= '<td></tr>';
					$sr++;
				}
			} else {
				$html .= '<tr>';
				$html .= '<td colspan="4" align="center">No Record Found</td>';
				$html .= '</tr>';
			}

			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			echo $html;
		} else {
			echo "";
		}
	}

	public function update_permission()
	{

		if (isset($_POST['admin_id']) && !empty($_POST['admin_id'])) {
			$common = new common();
			$moduleList = $common->moduleList;
			$adminPermission = [];
			foreach ($moduleList as $key => $value) {
				if (isset($_POST[$value['module_shortcode']]) && !empty($_POST[$value['module_shortcode']])) {
					$adminPermission[] = $value + ['permission' => $_POST[$value['module_shortcode']]];
				}
			}
			$adminPermission = json_encode($adminPermission);
			$update = [
				'permission' => $adminPermission,
				'updated_at' => date('Y-m-d H:i:s'),
			];
			parent::updateTable_f_mdl('admin_master', $update, 'id="' . $_POST['admin_id'] . '"');
			$_SESSION['SUCCESS'] = 'TRUE';
			$_SESSION['MESSAGE'] = 'Updated successfully.';
			$url = 'location:index.php?do=module-list&admin_id=' . $_REQUEST['admin_id'];
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid Request.';
			$url = 'location:index.php?do=admin-list';
		}
		header($url);
	}
	public function add_admin_post()
	{
		if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['first_name']) && !empty($_POST['first_name']) && isset($_POST['last_name']) && !empty($_POST['last_name'])) {
			$email = trim($_POST['email']);
			$first_name = trim($_POST['first_name']);
			$last_name = trim($_POST['last_name']);
			$password = trim($_POST['password']);
			$is_super_admin = trim($_POST['is_super_admin']);
			$status = trim($_POST['status']);
			$newAdminAdded = false;
			if (isset($_POST['admin_id']) && !empty($_POST['admin_id'])) {
				$insert_data = [
					'email' => $email,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'is_super_admin' => ($is_super_admin == 'on') ? 1 : 0,
					'status' => ($status == 'on') ? 1 : 0
				];
				self::$site_log->insert_log('', common::APP_NAME, "Update", "ADMIN", '', $email . ' Admin Updated ', $insert_data);
				parent::updateTable_f_mdl('admin_master', $insert_data, 'id="' . $_POST['admin_id'] . '"');
				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Updated successfully.';
			} else {
				$sql = 'SELECT id FROM `admin_master` WHERE email="' . $email . '"';
				$exist = parent::selectTable_f_mdl($sql);
				if (empty($exist)) {
					$insert_data = [
						'email' => $email,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'password' => md5($password),
						'is_super_admin' => ($is_super_admin == 'on') ? 1 : 0,
						'status' => ($status == 'on') ? 1 : 0,
						'created_on' => date('Y-m-d H:i:s')
					];
					self::$site_log->insert_log('', common::APP_NAME, "Add", "ADMIN", '', $email . ' New admin added ', $insert_data);
					$insertAdminResult = parent::insertTable_f_mdl('admin_master', $insert_data);
					$newAdminAdded = true;
					$_SESSION['SUCCESS'] = 'TRUE';
					$_SESSION['MESSAGE'] = 'Added successfully.';
				} else {
					$_SESSION['SUCCESS'] = 'FALSE';
					$_SESSION['MESSAGE'] = 'Admin Already Exists.';

					self::$site_log->insert_log('', common::APP_NAME, "Add", "IP Block", '', $email . ' Already added', []);
				}
			}
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}
		if ($newAdminAdded) {
			header('location:index.php?do=module-list&admin_id=' . $insertAdminResult['insert_id']);
		} else {
			header('location:index.php?do=admin-list');
		}
	}
	public function delete_admin()
	{
		if (isset($_POST['id']) && !empty($_POST['id'])) {
			$id = trim($_POST['id']);
			$sql = 'SELECT id, email FROM admin_master WHERE id="' . $id . '"';
			$data = parent::selectTable_f_mdl($sql);
			if (!empty($data)) {
				parent::deleteTable_f_mdl('admin_master', 'id="' . $id . '"');
				self::$site_log->insert_log('', common::APP_NAME, "Delete", "Admin", '', @$data[0]['email'] . ' Admin Deleted', [$id]);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			} else {
				self::$site_log->insert_log($id, common::APP_NAME, "Delete", "Admin", '', 'Invalid request.', [$id]);
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}
	public function select_admin()
	{
		if (isset($_POST['id']) && !empty($_POST['id'])) {
			$id = trim($_POST['id']);
			$sql = 'SELECT * FROM admin_master WHERE id="' . $id . '"';
			$data = parent::selectTable_f_mdl($sql);
			if (!empty($data)) {
				$res['SUCCESS'] = 'TRUE';
				$res['ADMIN'] = $data;
			} else {
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'No admin found.';
			}
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}
	public function superadmin_status()
	{
		if (isset($_POST['id']) && !empty($_POST['id'])) {
			$id = trim($_POST['id']);
			$sql = 'SELECT id FROM admin_master WHERE id="' . $id . '"';
			$data = parent::selectTable_f_mdl($sql);
			if (!empty($data)) {
				$update = [
					'is_super_admin' => $_POST['super_admin_status'],
				];
				parent::updateTable_f_mdl('admin_master', $update, 'id="' . $id . '"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}

	public function change_status()
	{
		if (isset($_POST['id']) && !empty($_POST['id'])) {
			$id = trim($_POST['id']);
			$sql = 'SELECT id FROM admin_master WHERE id="' . $id . '"';
			$data = parent::selectTable_f_mdl($sql);
			if (!empty($data)) {
				$update = [
					'status' => $_POST['status'],
				];
				parent::updateTable_f_mdl('admin_master', $update, 'id="' . $id . '"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
		} else {
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res, 1);
	}

	


	public function check_labels_by_shop_id($shop_id)
	{
		$sql = 'SELECT app_labels.*,
		(
		SELECT sal_label FROM `shop_app_labels` WHERE sal_shop_id="' . $shop_id . '" AND sal_al_id = app_labels.al_id LIMIT 1
		) as sal_label
		FROM app_labels';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function get_permission_by_shop_id($shop_id)
	{
		$sql = 'SELECT * FROM search_page_permission WHERE shop_id="' . $shop_id . '"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function get_email_sender_address_by_shop_id($shop_id)
	{
		$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="' . $shop_id . '"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	

	
	
	public function activeAdminCount()
	{
		$sql = "SELECT count(id) active_admin FROM `admin_master` WHERE status = '1' LIMIT 1";
		return parent::selectTable_f_mdl($sql);
	}
	public function superAdminCount()
	{
		$sql = "SELECT count(id) super_admin FROM `admin_master` WHERE is_super_admin = '1' LIMIT 1";
		return parent::selectTable_f_mdl($sql);
	}

}
