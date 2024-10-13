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
			}else if ($action == 'add_new_shop_install_token_post') {
				$this->add_new_shop_install_token_post();
				exit;
			}else if ($action == 'add_product') {
				$this->add_product();
				exit;
			}else if ($action == 'get_product_shop') {
				$this->get_product_shop();
				exit;
			}else if ($action == 'get_product_list') {
				$this->get_product_list();
				exit;
			}else if ($action == 'delete_shop_install_token_post') {
				$this->delete_shop_install_token_post();
				exit;
			}else if ($action == 'edit_shop_install_token_post') {
				$this->edit_shop_install_token_post();
				exit;
			} else if ($action == 'get_admin_list_post') {
				$this->get_admin_list_post();
			}else if ($action == 'add_admin_post') {
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

	public function admin_logout(){
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
	public function check_user_by_id($id){
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
	public function edit_profile_personal_details_post(){
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
	public function edit_profile_change_password_post(){
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

	public function get_shop_installation_list_post(){
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
			$html .= '<th>Install Token</th>';
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
					$html .= '<td>' . $single['install_token'] . '</td>';
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

	public function get_product_list(){
		
		$sql = "SELECT id, shop, install_token FROM `shop_install_token`";
        $all_list = parent::selectTable_f_mdl($sql);
        // Include the view (page)
        //include('./pages/addproduct.php');  // Pass the $shops to the view
        if (!empty($all_list)) {
         $html = '';
         $html .= '<select class="form-control" name="pro_shop" id="pro_shop">';
         $html .= '<option value="">Select Shop</option>';
         foreach($all_list as $key => $value){
             $html .= '<option value="'.$value['id'].'">'.$value['shop'].'</option>';
         }
         $html .= '</select>';
         $res['DATA'] = $html;       
         echo json_encode($html);
      
        }else{
         echo json_encode(['status'=>'error']);
        }
	}

	public function get_product_shop(){
		
		$sql = "SELECT id, shop, install_token FROM `shop_install_token`";
        $all_list = parent::selectTable_f_mdl($sql);
        // Include the view (page)
        //include('./pages/addproduct.php');  // Pass the $shops to the view
        if (!empty($all_list)) {
         $html = '';
         $html .= '<select class="form-control" name="pro_shop" id="pro_shop">';
         $html .= '<option value="">Select Shop</option>';
         foreach($all_list as $key => $value){
             $html .= '<option value="'.$value['id'].'">'.$value['shop'].'</option>';
         }
         $html .= '</select>';
         $res['DATA'] = $html;       
         echo json_encode($html);
      
        }else{
         echo json_encode(['status'=>'error']);
        }
	}
	public function add_product() {
		if (isset($_POST['product_Shop']) && !empty($_POST['product_Shop'])) {
			$product_Shop = trim($_POST['product_Shop']);
			$product_title = trim($_POST['product_title']);
			$product_desc = isset($_POST['product_desc']) ? trim($_POST['product_desc']) : "";
			$product_status = isset($_POST['product_status']) ? trim($_POST['product_status']) : "";
			$product_type = isset($_POST['product_type']) ? trim($_POST['product_type']) : "";
			$product_vendor = isset($_POST['product_vendor']) ? trim($_POST['product_vendor']) : "";
			$product_tgs = isset($_POST['product_tgs']) ? trim($_POST['product_tgs']) : "";
			$product_option = trim($_POST['product_VarOpt1']) . ',' . trim($_POST['product_VarOpt2']) . ',' . trim($_POST['product_VarOpt3']);
			$shopify_product_id = ''; // Null as of now
			$updated_at = date('Y-m-d H:i:s');
			$created_at = date('Y-m-d H:i:s');
	
			$insert_data = [
				'shop_id' => $product_Shop,
				'title' => $product_title,
				'pro_description' => $product_desc,
				'product_status' => $product_status,
				'product_type' => $product_type,
				'option_product' => $product_option,
				'vendor' => $product_vendor,
				'tags' => $product_tgs,
				'shopify_product_id' => $shopify_product_id,
				'created_at' => $created_at,
				'updated_at' => $updated_at
			];
			var_dump($insert_data);
			//$product_id = parent::insertTable_f_mdl('products', $insert_data);
			$product_id_result = parent::insertTable_f_mdl('products', $insert_data); // Inserting the product

			// Ensure only the 'insert_id' is used as product_id
			$product_id = $product_id_result['insert_id'];
			var_dump($product_id);
			if ($product_id) {
				// Step 2: Insert variant data into the Variant table
				$variantTitles = $_POST['variat-title'];
				$variantPrices = $_POST['variat-price'];

				for ($i = 0; $i < count($variantTitles); $i++) {
					$variantTitle = is_array($variantTitles[$i]) ? implode(',', $variantTitles[$i]) : trim($variantTitles[$i]);
					$variantPrice = is_array($variantPrices[$i]) ? implode(',', $variantPrices[$i]) : trim($variantPrices[$i]);
					$shopify_variant_id = ''; // Null as of now

					$insert_data = [
						'product_id' => $product_id, // Ensure this is just the insert_id, not an array
						'title' => $variantTitle,
						'price' => $variantPrice,
						'shopify_variant_id' => $shopify_variant_id,
						'created_at' => $created_at,
						'updated_at' => $updated_at
					];

					var_dump($insert_data); // Debugging data for variants
					$sqlVariant = parent::insertTable_f_mdl('variants', $insert_data);

					if (!$sqlVariant) {
						$_SESSION['SUCCESS'] = 'FALSE';
						$_SESSION['MESSAGE'] = 'Variants Not added. Something went wrong.';
						break;
					}
				}
			}
			else {
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Product not added. Please check.';
			}
		} else {
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Shop ID is required.';
		}
	
		header('location:index.php?do=product');
		exit();
	}
	
	public function add_new_shop_install_token_post(){
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

	public function updateTable_f_mdl($table, $data, $where){
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

	public function edit_shop_install_token_post(){
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

	public function delete_shop_install_token_post(){
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

	public function get_details_by_shop_id($shop_id){
		$sql = 'SELECT shop_name, email FROM shop_management WHERE id="' . $shop_id . '"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function get_item_details(){
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
	public function get_admin_list_post(){
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

	public function add_admin_post(){
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
	public function delete_admin(){
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
	public function select_admin(){
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
	public function superadmin_status(){
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

	public function change_status(){
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

	public function check_labels_by_shop_id($shop_id){
		$sql = 'SELECT app_labels.*,
		(
		SELECT sal_label FROM `shop_app_labels` WHERE sal_shop_id="' . $shop_id . '" AND sal_al_id = app_labels.al_id LIMIT 1
		) as sal_label
		FROM app_labels';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function get_permission_by_shop_id($shop_id){
		$sql = 'SELECT * FROM search_page_permission WHERE shop_id="' . $shop_id . '"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function get_email_sender_address_by_shop_id($shop_id){
		$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="' . $shop_id . '"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}

	public function activeAdminCount(){
		$sql = "SELECT count(id) active_admin FROM `admin_master` WHERE status = '1' LIMIT 1";
		return parent::selectTable_f_mdl($sql);
	}
	public function superAdminCount(){
		$sql = "SELECT count(id) super_admin FROM `admin_master` WHERE is_super_admin = '1' LIMIT 1";
		return parent::selectTable_f_mdl($sql);
	}

}
